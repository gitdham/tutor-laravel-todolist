<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistControllerTest extends TestCase {
  public function testTodolist() {
    $sessionData = [
      'user' => 'idham',
      'todolist' => [
        ['id' => '1', 'todo' => 'Task 1'],
        ['id' => '2', 'todo' => 'Task 2'],
      ],
    ];

    $this->withSession($sessionData)
      ->get('/todolist')
      ->assertSeeText('1')->assertSeeText('Task 1')
      ->assertSeeText('2')->assertSeeText('Task 2');
  }

  public function testAddTodoFailed() {
    $sessionData = ['user' => 'idham'];

    $this->withSession($sessionData)
      ->post('/todolist', [])
      ->assertSeeText('Todo is required');
  }

  public function testAddTodoSuccess() {
    $sessionData = ['user' => 'idham'];
    $postData = ['todo' => 'Task 1'];

    $this->withSession($sessionData)
      ->post('/todolist', $postData)
      ->assertRedirect('/todolist');
  }

  public function testRemoveTodolist() {
    $sessionData = [
      'user' => 'idham',
      'todolist' => [
        ['id' => '1', 'todo' => 'Task 1'],
        ['id' => '2', 'todo' => 'Task 2'],
      ],
    ];

    $this->withSession($sessionData)
      ->post('/todolist/1/delete')
      ->assertRedirect('/todolist');
  }
}
