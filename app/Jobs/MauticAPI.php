<?php

namespace App\Jobs;

use App\Helpers\Mautic;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class MauticAPI implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($stageId, $segmentId, $contactParam)
    {
        $this->stageId = $stageId;
        $this->segmentId = $segmentId;
        $this->contactParam = $contactParam;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $mautic = new Mautic();
        
            // $stage = $mautic->createStage($stageParam);
            // $segement = $mautic->createSegment($segmentParam);
            $contact = $mautic->createContact($this->contactParam);
            $mautic->addContactToSegment($this->segmentId, $contact->contact->id);
            $mautic->addContactToStage($this->stageId, $contact->contact->id);
        } catch (\Exception $e) {
            \Log::info($e);
        }
        
    }
}
