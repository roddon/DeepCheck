<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NewMediaDRS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $media_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mediaId)
    {
        $this->media_id = $mediaId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            exec(env('PY_SCAN_SCRIPT') . ' '  . $this->media_id);
            \Log::info(env('PY_SCAN_SCRIPT') . ' '  . $this->media_id);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }
}
