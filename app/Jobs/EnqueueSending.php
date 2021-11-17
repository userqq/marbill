<?php

namespace App\Jobs;

use Throwable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\SendingSchedule;
use App\Models\SendingsCustomer;

class EnqueueSending implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** Create a new job instance. */
    public function __construct(
        private SendingSchedule $sending
    ) {}

    /** Execute the job. */
    public function handle(): void
    {
        $this->sending->load(['sendingsCustomers', 'sendingsCustomers.customer']);

        foreach ($this->sending->sendingsCustomers as $sendingsCustomer) {
            try {

                dispatch(new SendEmail($this->sending, $this->sending->emailTemplate, $sendingsCustomer));
                $sendingsCustomer->update(['status' => SendingsCustomer::STATUS_ACQUIRED]);
            } catch (Throwable $t) {

                $sendingsCustomer->update(['status' => SendingsCustomer::STATUS_ERROR]);
                report($t);

            }
        }

        $this->sending->update(['status' => SendingSchedule::STATUS_IN_PROGRESS]);
    }
}
