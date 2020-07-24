<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\File;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Exports\CodeExports;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Jobs\DeleteFileJob;
class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tries = 3;

    private $user;
    private $type;
    private $start;
    private $end;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user,string $type, $start = '',$end = '')
    {
        $this->user = $user;
        $this->type = $type;
        $this->start = $start;
        $this->end = $end;
       // dd($this->end);


    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $now = Str::uuid();
        $nameFile =  $now.".xlsx";
        $pathPublic = "public\Excel\\";
        $path = "Excel/";

        $fileType = "xlsx";

        $file = new File();
        $file->file =  $nameFile;
        $file->name =  $now;
        $file->type =  $fileType;
        $file->path =  $path.$nameFile;
        $file->save();

        switch ($this->type) {
            case 'yesterday':

                (new CodeExports)
                ->forYesterday($this->type)
                ->store($pathPublic.$nameFile, 'local');

                DeleteFileJob::dispatch($file)->delay(now()->addDays(3));

                return Mail::send(new SendMail($this->user, $file));

                break;
            case 'today':

                (new CodeExports)
                ->forToday($this->type)
                ->store($pathPublic.$nameFile, 'local');

                DeleteFileJob::dispatch($file)->delay(now()->addDays(3));

                return Mail::send(new SendMail($this->user, $file));

                break;
            case 'week':

                (new CodeExports)
                ->forWeek($this->type)
                ->store($pathPublic.$nameFile, 'local');

                DeleteFileJob::dispatch($file)->delay(now()->addDays(3));

                return Mail::send(new SendMail($this->user, $file));

                break;
            case 'month':

                (new CodeExports)
                ->forMonth($this->type)
                ->store($pathPublic.$nameFile, 'local');

                DeleteFileJob::dispatch($file)->delay(now()->addDays(3));

                return Mail::send(new SendMail($this->user, $file));

                break;
            case 'interval':

                (new CodeExports)
                ->forInterval($this->type, $this->start, $this->end)
                ->store($pathPublic.$nameFile, 'local');

                DeleteFileJob::dispatch($file)->delay(now()->addDays(3));

                return Mail::send(new SendMail($this->user, $file));

                break;
        }
    }
}
