<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller {
  private UserService $userService;

  public function __construct(UserService $userService) {
    $this->userService = $userService;
  }

  public function login(): Response {
    $data = ['title' => 'Login'];

    return response()->view('user.login', $data);
  }

  public function doLogin(Request $request): Response|RedirectResponse {
    $user = $request->input('user');
    $password = $request->input('password');

    // validate input
    if (empty($user) || empty($password)) {
      $data = [
        'title' => 'Login',
        'error' => 'User or password is required'
      ];

      return response()->view('user.login', $data);
    }

    // validate user
    if (!$this->userService->login($user, $password)) {
      $data = [
        'title' => 'Login',
        'error' => 'User or password is wrong'
      ];

      return response()->view('user.login', $data);
    }

    // login success
    $request->session()->put('user', $user);
    return redirect('/');
  }

  public function doLogout(Request $request): RedirectResponse {
    $request->session()->forget('user');
    return redirect('/');
  }
}
