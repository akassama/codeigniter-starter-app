<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsersModel;
use CodeIgniter\HTTP\ResponseInterface;

class SignInController extends BaseController
{
    protected $helpers = ['form'];

    public function index()
    {
        return view('front-end/sign-in/index');
    }

    public function login()
    {
        //$emailOrUsername = $this->request->getPost('email_or_username');
        $emailOrUsername = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Load the UsersModel
        $usersModel = new UsersModel();

        // Attempt to log in the user
        $user = $usersModel->validateLogin($emailOrUsername, $password);

        // Check if user status is active
        if(!$usersModel->validateStatus($emailOrUsername)){
            // Login failed: Redirect back to login page with user not active error message
            return redirect()->to('/sign-in?not-active')->with('error', 'User not active');
        }

        if ($user) {
            // User logged in successfully

            // Store user data in session or set cookies, etc.

            // Redirect to dashboard or desired page
            return redirect()->to('/dashboard');
        } else {
            // Login failed: Redirect back to login page with an error message
            return redirect()->to('/sign-in')->with('error', 'Invalid email/username or password');
        }
    }
}
