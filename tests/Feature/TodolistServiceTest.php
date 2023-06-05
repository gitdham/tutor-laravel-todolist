<?php

namespace Tests\Feature;

use App\Services\TodolistService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class TodolistServiceTest extends TestCase {
  private TodolistService $todolistService;

  public function setUp(): void {
    parent::setUp();
    $this->todolistService = $this->app->make(TodolistService::class);
  }

  public function testTodolistNotNull() {
    self::assertNotNull($this->todolistService);
  }

  public function testSaveTodo() {
    $this->todolistService->saveTodo('1', 'Task 1');

    $todolist = Session::get('todolist');
    foreach ($todolist as $todo) {
      self::assertEquals('1', $todo['id']);
      self::assertEquals('Task 1', $todo['todo']);
    }
  }

  public function testGetTodolistEmpty() {
    self::assertEquals([], $this->todolistService->getTodolist());
  }

  public function testGetTodolistNotEmpty() {
    $expected = [
      ['id' => '1', 'todo' => 'Task 1'],
      ['id' => '2', 'todo' => 'Task 2'],
    ];

    $this->todolistService->saveTodo('1', 'Task 1');
    $this->todolistService->saveTodo('2', 'Task 2');

    self::assertEquals($expected, $this->todolistService->getTodolist());
  }

  public function testRemoveTodo() {
    $this->todolistService->saveTodo('1', 'Task 1');
    $this->todolistService->saveTodo('2', 'Task 2');

    self::assertEquals(2, sizeof($this->todolistService->getTodolist()));

    $this->todolistService->removeTodo('3');
    self::assertEquals(2, sizeof($this->todolistService->getTodolist()));

    $this->todolistService->removeTodo('1');
    self::assertEquals(1, sizeof($this->todolistService->getTodolist()));

    $this->todolistService->removeTodo('2');
    self::assertEquals(0, sizeof($this->todolistService->getTodolist()));
  }
}
