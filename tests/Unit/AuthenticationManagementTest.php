<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationManagementTest extends TestCase
{
    use RefreshDatabase;

    public function testAUserCanSignup()
    {
        $validSignupResponse = [
            "access_token",
            "token_type"
        ];
        $response = $this->post('/api/signup', $this->signupData());

        $response->assertJsonStructure($validSignupResponse);
        $response->assertSee('"access_token":"1|', $escaped = false);
        $response->assertJsonPath('token_type', 'Bearer');
    }

    public function testAUserCanLoginAfterSignup()
    {
        $this->refreshDatabase();
        $validLoginResponse = [
            "status",
            "access_token",
            "token_type"
        ];
        $response = $this->post('/api/signup', $this->signupData());
        $response = $this->post('/api/login', $this->signupData());

        $response->assertJsonStructure($validLoginResponse);
        $response->assertJsonPath('status', 'Login Success');
        $response->assertSee('"access_token":"2|', $escaped = false);
        $response->assertJsonPath('token_type', 'Bearer');
    }
    
    public function testAUserCanLogoutAfterLogin()
    {
        $validLogoutResponse = [
            "status" => "Logout Success",
            "message" => "Logged Out"
        ];
        $response = $this->post('/api/signup', $this->signupData());
        $response = $this->post('/api/login', $this->signupData());
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $response->getData()->access_token,
        ])->post('/api/logout', []);

        $response->assertExactJson($validLogoutResponse);
    } 

    private function signupData()
    {
        return [
            'name' => "Test User",
            'email' => "unused@email.com",
            'password' => "123456789",
        ];
    }
}
