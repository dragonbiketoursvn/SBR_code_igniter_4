<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class CaribeLoginFilter implements FilterInterface
{
  public function before(RequestInterface $request, $arguments = null)
  {

    if (!service('caribeAuth')->isLoggedIn()) {
      dd('penis');
      session()->set('redirect_url', current_url());

      return redirect()->to(site_url('caribe/login'))
        ->with('info', 'Please login first');
    }
  }

  //--------------------------------------------------------------------

  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
  {
    // Do something here
  }
}
