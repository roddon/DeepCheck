<?php

namespace App\Observers;

use App\Models\Company;
use App\Models\TmpMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
class MediaObserver
{
    public function created(Media $media)
    {
        $userId = \Auth::user()->id;
        $companyAccountNumber = Company::where('user_id', $userId)->first()->account_number;
        
        TmpMedia::insert([
            'media_id' => $media->id,
            'name' => $companyAccountNumber.'-'.$media->id,
            'document_system' => 'doc_analysis'
        ]);
    }
}