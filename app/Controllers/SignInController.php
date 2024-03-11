<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class SignInController extends BaseController
{
    protected $helpers = ['form'];

    public function index()
    {
        return view('front-end/sign-in/index');
    }
}
