<?php

namespace App\Listeners;

use App\Events\UserCreation;

class UserRolesListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserCreation $event
     * @return void
     */
    public function handle(UserCreation $event)
    {
        $userDetailsData = $event->userDetailsData;
        $event->userInstance->roles()->attach($userDetailsData['roles']);
    }
}
