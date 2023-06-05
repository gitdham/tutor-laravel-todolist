<?php

namespace App\Services\Impl;

use App\Services\TodolistService;
use Illuminate\Support\Facades\Session;

class TodolistServiceImpl implements TodolistService {
  public function saveTodo(string $id, string $todo): void {
    // check todo dalam session, jika tidak ada put array kosong
    if (!Session::exists('todolist')) {
      Session::put('todolist', []);
    }

    Session::push('todolist', ['id' => $id, 'todo' => $todo]);
  }

  public function getTodolist(): array {
    return Session::get('todolist', []);
  }

  public function removeTodo(string $todoId) {
    $todolist = Session::get('todolist');

    foreach ($todolist as $i => $value) {
      if ($value['id'] == $todoId) {
        unset($todolist[$i]);
        break;
      }
    }

    Session::put('todolist', $todolist);
  }
}
