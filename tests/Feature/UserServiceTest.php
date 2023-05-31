<?php

namespace Tests\Feature;

use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserServiceTest extends TestCase {
    private UserService $userService;

    protected function setUp(): void {
        parent::setUp();
        $this->userService = $this->app->make(UserService::class);
    }

    public function testLoginSuccess() {
        self::assertTrue($this->userService->login('idham', 'password'));
    }

    public function testLoginNotFound() {
        self::assertNotTrue($this->userService->login('guest', 'guest'));
    }

    public function testWrongPassword() {
        self::assertNotTrue($this->userService->login('idham', 'salah'));
    }
}
