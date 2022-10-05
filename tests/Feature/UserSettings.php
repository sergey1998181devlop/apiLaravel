<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserSettings extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function getUser()
    {
        $response = $this->get('/api/lk/user-setting-profile?id=1');

        $response->assertStatus(200);
    }
}
