<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class TestController extends BaseController
{
    protected $helpers = ['auth_helper'];
    public function index()
    {
        return view('front-end/test/index');
    }
}
