<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class HomepageTest extends TestCase
{

    public function testVisitAsGuest()
    {
        $this->visit('/')->see('Register');
    }

    public function testRegister()
    {
        $this->visit('/register')
            ->type('Test User', 'name')
            ->type('test@test.com', 'email')
            ->type('password', 'password')
            ->type('password', 'password_confirmation')
            ->press('Register')
            ->see('Test User');

    }

}
