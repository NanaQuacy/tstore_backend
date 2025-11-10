<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void
    {
        try {
            Mail::to($event->user->email)->send(new WelcomeMail($event->user));
            Log::info('Welcome email sent successfully to user: ' . $event->user->email, [
                'user_id' => $event->user->id,
            ]);
        } catch (\Exception $e) {
            // Log the error but don't break registration
            Log::error('Failed to send welcome email to user: ' . $event->user->email, [
                'error' => $e->getMessage(),
                'error_class' => get_class($e),
                'user_id' => $event->user->id,
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }
}
