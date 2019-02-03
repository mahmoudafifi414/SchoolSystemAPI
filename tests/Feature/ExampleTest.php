<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAuthorizedUserCanDeleteTheEducationalLevel()
    {
        $educationalLevel = factory('App\EducationalLevel')->create();
        //When the user hit's the endpoint to delete the EducationalLevel
        $this->delete('/api/education-level/' . $educationalLevel->id);
        //The EducationalLevel should be deleted from the database.
        $this->assertDatabaseMissing('educational_levels', ['id' => $educationalLevel->id]);
    }
}
