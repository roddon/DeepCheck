<?php

namespace App\Listeners;

use App\Models\TmpMedia;
use Log;
use Spatie\MediaLibrary\MediaCollections\Events\MediaHasBeenAdded;
use App\Jobs\NewMediaDRS;

class MediaAddedListener
{
    public function handle(MediaHasBeenAdded $event)
    {
        $media = $event->media;
        $path = $media->getPath();


        if ($media->model_type == 'App\Models\Customer' || $media->model_type == 'App\Models\Invoice') {

            $name = $media->model->user->company->account_number . '-' . $media->id;


            TmpMedia::create([
                'name' => $name,
                'document_system' => $media->document_system,
                'media_id' => $media->id
            ]);

            $media->document_system = 'doc_analysis';
        }

        $media->file_path = str_replace('\\', '/', $path);
        $media->save();

        if ($media->model_type == 'App\Models\Customer' || $media->model_type == 'App\Models\Invoice') {
            NewMediaDRS::dispatch($media->id);
        }

        Log::info("file {$path} has been saved for media {$media->id}");
    }
}
