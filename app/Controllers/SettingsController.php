<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class SettingsController extends BaseController
{
    protected $helpers = ['data_helper', 'auth_helper'];

    public function index()
    {
        return view('back-end/settings/index');
    }

    public function updateDetails()
    {
        return view('back-end/settings/update-details/index');
    }

    public function changePassword()
    {
        return view('back-end/settings/change-password/index');
    }
}
