<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AdminController extends BaseController
{
    protected $helpers = ['data_helper', 'auth_helper'];

    public function index()
    {
        return view('back-end/admin/index');
    }

    public function users()
    {
        return view('back-end/admin/users/index');
    }

    public function activityLogs()
    {
        return view('back-end/admin/activity-logs/index');
    }
}
