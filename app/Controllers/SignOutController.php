<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class SignOutController extends BaseController
{
    public function index()
    {
        // Remove all session data
        session()->destroy();

        return redirect()->to('sign-in');
    }
}
