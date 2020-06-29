<?php

namespace App\Observers;

use App\LoanApplication;
use App\Notifications\NewApplicationNotification;
use App\Notifications\SentForAnalysisNotification;
use App\Notifications\StatusChangeNotification;
use App\Notifications\SubmittedAnalysisNotification;
use App\Role;
use App\Status;
use Illuminate\Support\Facades\Notification;

class LoanApplicationObserver
{
    /**
     * Handle the loan application "creating" event.
     *
     * @param  \App\LoanApplication  $loanApplication
     * @return void
     */
    public function creating(LoanApplication $loanApplication)
    {
        $processingStatus = Status::whereName('Processing')->first();

        $loanApplication->status()->associate($processingStatus);
    }

    /**
     * Handle the loan application "created" event.
     *
     * @param  \App\LoanApplication  $loanApplication
     * @return void
     */
    public function created(LoanApplication $loanApplication)
    {
        $admins = Role::find(1)->users;

        Notification::send($admins, new NewApplicationNotification($loanApplication));
    }

    /**
     * Handle the loan application "updated" event.
     *
     * @param  \App\LoanApplication  $loanApplication
     * @return void
     */
    public function updated(LoanApplication $loanApplication)
    {
        if ($loanApplication->isDirty('status_id')) {
            if (in_array($loanApplication->status_id, [2, 5])) {
                if ($loanApplication->status_id == 2) {
                    $user = $loanApplication->analyst;
                } else {
                    $user = $loanApplication->cfo;
                }

                Notification::send($user, new SentForAnalysisNotification($loanApplication));
            } elseif (in_array($loanApplication->status_id, [3, 4, 6, 7])) {
                $users = Role::find(1)->users;

                Notification::send($users, new SubmittedAnalysisNotification($loanApplication));
            } elseif (in_array($loanApplication->status_id, [8, 9])) {
                $loanApplication->created_by->notify(new StatusChangeNotification($loanApplication));
            }
        }
    }
}
