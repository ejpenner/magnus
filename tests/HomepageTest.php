<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HomepageTest extends TestCase
{
    public function testAlive()
    {
        $this->visit('/')->assertResponseOk();
    }

    public function testVisitAsGuest()
    {
        $this->visit('/')->see('Register');
    }

    public function testVisitAsAuth()
    {
        $user = factory(\Magnus\User::class)->create();
        $this->actingAs($user)->visit('/hot')->see('Log Out');
    }

    public function test404()
    {
        $this->visit('/sds/s/afsf/ga\\')->see('404');
    }
}
