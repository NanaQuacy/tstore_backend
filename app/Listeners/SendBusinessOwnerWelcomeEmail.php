<?php

namespace App\Listeners;

use App\Events\BusinessCreated;
use App\Mail\BusinessOwnerWelcomeMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendBusinessOwnerWelcomeEmail
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
    public function handle(BusinessCreated $event): void
    {
        try {
            Mail::to($event->user->email)->send(
                new BusinessOwnerWelcomeMail($event->user, $event->business)
            );
            
            Log::info('Business owner welcome email sent successfully', [
                'user_id' => $event->user->id,
                'business_id' => $event->business->id,
                'business_code' => $event->business->business_code,
            ]);
        } catch (\Exception $e) {
            // Log the error but don't break the business creation
            Log::error('Failed to send business owner welcome email', [
                'error' => $e->getMessage(),
                'error_class' => get_class($e),
                'user_id' => $event->user->id,
                'business_id' => $event->business->id,
            ]);
        }
    }
}
