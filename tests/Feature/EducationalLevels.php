<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class EducationalLevels extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function authorized_user_can_delete_the_task()
    {
        /*$educationalLevel = factory('App\EducationalLevel')->create();
        //When the user hit's the endpoint to delete the EducationalLevel
        $this->delete('/education-level/delete/' . $educationalLevel->id);
        //The EducationalLevel should be deleted from the database.
        $this->assertDatabaseMissing('educational_levels', ['id' => $educationalLevel->id]);*/
    }
}
