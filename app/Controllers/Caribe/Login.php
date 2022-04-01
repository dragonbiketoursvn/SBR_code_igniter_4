<?php

namespace App\Controllers\Caribe;

class Login extends \App\Controllers\BaseController
{
  public function new()
  {
    dd('ok');
    return view('Caribe/Login/new');
  }

  public function create()
  {
    $email = $this->request->getPost('email');
    $password = $this->request->getPost('password');
    $remember_me = (bool) $this->request->getPost('remember_me');

    $auth = service('caribeAuth');

    if ($auth->login($email, $password, $remember_me)) {

      $redirect_url = session('redirect_url') ?? '/';

      unset($_SESSION['redirect_url']);

      return redirect()->to($redirect_url)
        ->with('info', 'Login successful')
        ->withCookies();
    } else {
      return redirect()->back()
        ->withInput()
        ->with('warning', 'Invalid login');
    }
  }

  // public function delete()
  // {
  //   service('auth')->logout();

  //   return redirect()->to('/login/showLogoutMessage');
  // }

  // public function showLogoutMessage()
  // {
  //   return redirect()->to('/')
  //     ->with('info', 'Logout successful');
  // }
}
