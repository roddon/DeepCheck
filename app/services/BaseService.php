<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\Company;
use App\Models\Country;
use App\Models\TmpMedia;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Encryption\EncryptException;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Carbon\Carbon;

class BaseService
{
    protected $model;

    public function get()
    {
        return $this->model->get();
    }


    public function count()
    {
        return $this->model->count();
    }


    public function find($id)
    {
        return $this->model->find($id);
    }


    public function findBy(array $columns)
    {
        $query = $this->model;
        foreach ($columns as $key => $value) {
            $query = $query->where($key, $value);
        }

        return $query->first();
    }

    public function findByAll(array $columns)
    {
        $query = $this->model;
        foreach ($columns as $key => $value) {
            $query = $query->where($key, $value);
        }

        return $query->get();
    }



    public function paginate($limit = 10)
    {
        return $this->model->paginate($limit);
    }


    public function create($data)
    {
        return $this->model->create($data);
    }


    public function updateById($id, $data)
    {
        return $this->model->where('id', $id)->update($data);
    }

    public function deleteById($id)
    {
        return $this->model->where('id', $id)->delete();
    }


    public function newQuery()
    {
        return $this->model->newQuery();
    }


    public function encrypt(string $string)
    {
        try {

            return Crypt::encryptString($string);
        } catch (EncryptException $e) {
        }
    }


    public function decrypt(string $string)
    {
        try {
            return Crypt::decryptString($string);
        } catch (DecryptException $e) {
        }
    }


    public function renameFile(Media $media, $file)
    {
        // $date = Carbon::now()->format('Ymd');
        // $time = Carbon::now()->getTimestamp();
        // $filename = $media->model->user->company->account_number . '-' . $date . '-' . $time . '-' . $file->getClientOriginalName();
        $media->name = $media->model->user->company->account_number . '-' . $media->id;
        $media->account_number = $media->model->user->company->account_number;
        $media->is_run = 0;
        $media->save();

        return $media;
    }

    public function activityLog($model, $logMessage, $status = null, $type = null)
    {
        $name = isset($model->name) && $model->name
            ? $model->name : (isset($model->company_name) && $model->company_name
                ? $model->company_name : optional($model->user)->name);

        $countryId = isset($model->country_id) ? $model->country_id : null;

        ActivityLog::create([
            'name' => $name,
            'status' => $status,
            'user_id' => optional($model->user)->id,
            'model_id' => $model->id,
            'model_type' => get_class($model),
            'log' => $logMessage,
            'type' => $type,
            'country_id' => $countryId
        ]);
    }
}
