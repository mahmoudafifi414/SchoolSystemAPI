<?php

namespace App\Listeners;

use App\Events\UserCreation;
use App\UserStudentDetails;

class UserRoleListener
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
        if ($userDetailsData['roleName'] == 'student') {
            $userStudentDetails = new UserStudentDetails;
            $userStudentDetails->user_id = $userDetailsData['userId'];
            $userStudentDetails->year_id = $userDetailsData['yearId'];
            $userStudentDetails->classroom_id = $userDetailsData['classroomId'];
            $userStudentDetails->save();
        }
    }
}
