<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class UserFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if user has the "Admin", "Manager", or "User" role
        if (!session()->has('role') || session('role') !== 'Admin' || session('role') !== 'Manager' || session('role') !== 'User') {
            return redirect()->to('account/access-denied');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
