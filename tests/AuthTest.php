<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AuthTest extends TestCase
{
    /**
     * To be sure the next transactions will be rollback
     * @test
     */
    public function simple(): void
    {
        $this->assertTrue(true);
    }

    /**
     * Test json response when token is required
     *
     * @return void
     */
    public function testShouldReturnTokenFromAuth0()
    {
        $this->get('auth');
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'access_token',
            'expires_in',
            'token_type'
        ]);
    }
}
