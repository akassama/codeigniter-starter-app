<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ContactsController extends BaseController
{
    protected $helpers = ['auth_helper'];
    public function index()
    {
        return view('back-end/contacts/index');
    }
}
