<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\File;

class DeleteFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tries = 3;
    private $file;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(File $file)
    {
        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $file = File::find($this->file->id);

        if (isset($file)) {

            $path = public_path(). '/storage/'. $file->path;
            unlink($path);
            $file->delete();

        }
    }
}
