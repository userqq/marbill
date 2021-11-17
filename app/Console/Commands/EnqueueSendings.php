<?php

namespace App\Console\Commands;

use Throwable;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\SendingSchedule;
use App\Jobs\EnqueueSending;

class EnqueueSendings extends Command
{
    private const BATCH_LIMIT = 1000;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enqueue:sendings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull scheduled sendings and send them to queue';

    /** Execute the console command. */
    public function handle(): int
    {
        $sendings = SendingSchedule::where('time', '<', Carbon::now())
            ->where('status', SendingSchedule::STATUS_NOT_SENT)
            ->lazyById(static::BATCH_LIMIT);

        foreach ($sendings as $sending) {
            try {

                dispatch(new EnqueueSending($sending));
                $sending->update(['status' => SendingSchedule::STATUS_ACQUIRED]);

            } catch (Throwable $t) {

                $sending->update(['status' => SendingSchedule::STATUS_ERROR]);
                throw $t;

            }
        }

        return Command::SUCCESS;
    }
}
