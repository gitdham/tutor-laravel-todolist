<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase {
  public function testLoginPage() {
    $this->get('/login')
      ->assertSeeText('Login')
      ->assertSeeText('User')
      ->assertSeeText('Password')
      ->assertSeeText('Sign In');
  }

  public function testLoginPageForMember() {
    $this->withSession(['user' => 'idham'])
      ->get('/login')
      ->assertRedirect('/');
  }

  public function testLoginForUserAlreadyLogin() {
    $data = [
      'user' => 'idham',
      'password' => 'password'
    ];

    $this->withSession(['user' => 'idham'])
      ->post('/login', $data)
      ->assertRedirect('/');
  }

  public function testLoginSuccess() {
    $data = [
      'user' => 'idham',
      'password' => 'password'
    ];

    $this->post('/login', $data)
      ->assertRedirect('/')
      ->assertSessionHas('user', 'idham');
  }

  public function testLoginInvalidInput() {
    $data = [];

    $this->post('/login', $data)
      ->assertSeeText('User or password is required');
  }

  public function testLoginInvalidUser() {
    $data = [
      'user' => 'guest',
      'password' => 'test'
    ];

    $this->post('/login', $data)
      ->assertSeeText('User or password is wrong')
      ->assertSessionMissing('user');
  }

  public function testLogout() {
    $this->withSession(['user' => 'idham'])
      ->post('/logout')
      ->assertRedirect('/')
      ->assertSessionMissing('user');
  }

  public function testLogoutGuest() {
    $this->post('/logout')
      ->assertRedirect('/');
  }
}
