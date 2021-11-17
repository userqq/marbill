<?php

namespace App\Jobs;

use Throwable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\Customer;
use App\Models\EmailTemplate;
use App\Models\SendingsCustomer;
use App\Models\SendingSchedule;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** Create a new job instance. */
    public function __construct(
        private SendingSchedule  $sending,
        private EmailTemplate    $template,
        private SendingsCustomer $sendingsCustomer,
    ) {}

    /** Execute the job. */
    public function handle(): void
    {
        $this->sendingsCustomer->update(['status' => SendingsCustomer::STATUS_IN_PROGRESS]);

        try {

            [$subject, $body] = $this->template->formatEmail($this->sendingsCustomer->customer);
            $this->sendEmail($subject, $body, $this->sendingsCustomer->customer->email);
            $this->sendingsCustomer->update(['status' => SendingsCustomer::STATUS_SENT]);

        } catch (Throwable $t) {

            $this->sendingsCustomer->update(['status' => SendingsCustomer::STATUS_ERROR]);
            throw $t;

        } finally {

            SendingSchedule::where('id', $this->sending->id)
                ->whereNotExists(
                    fn ($query) => $query
                        ->from((new SendingsCustomer)->getTable())
                        ->where('sending_schedule_id', $this->sending->id)
                        ->whereNotIn('status', [
                            SendingsCustomer::STATUS_SENT,
                            SendingsCustomer::STATUS_ERROR,
                        ])
                )
                ->update(['status' => SendingsCustomer::STATUS_SENT]);

        }
    }

    /** @throws EmailSendingException */
    private function sendEmail(string $subject, string $body, string $email): float
    {
        Log::info(sprintf('Attempt to send email to "%s" with subject "%s" and body "%s"', $email, $subject, $body));
        /** Not Implemented yet **/

        return 1.0;
    }
}
