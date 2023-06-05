<?php

namespace App\Http\Controllers;

use App\Services\TodolistService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TodolistController extends Controller {
  private TodolistService $todolistService;

  public function __construct(TodolistService $todolistService) {
    $this->todolistService = $todolistService;
  }

  public function todoList(Request $request) {
    $viewData = [
      'title' => 'Todolist',
      'todolist' => $this->todolistService->getTodolist(),
    ];

    return response()->view('todolist.todolist', $viewData);
  }

  public function addTodo(Request $request) {
    $todo = $request->input('todo');

    // if $todo is empty return todolist view with error msg
    if (empty($todo)) {
      $viewData = [
        'title' => 'Todolist',
        'todolist' => $this->todolistService->getTodolist(),
        'error' => 'Todo is required',
      ];

      return response()->view('todolist.todolist', $viewData);
    }

    $this->todolistService->saveTodo(uniqid(), $todo);

    return redirect()->action([TodolistController::class, 'todoList']);
  }

  public function removeTodo(Request $request, string $todoId): RedirectResponse {
    $this->todolistService->removeTodo($todoId);
    return redirect()->action([TodolistController::class, 'todoList']);
  }
}
