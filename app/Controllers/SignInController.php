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

        if ($user) {
            // Check if user status is active
            if ($user['status'] != 1) {
                // Login failed: Redirect back to login page with user not active error message
                session()->setFlashdata('errorAlert', 'Your account has not been activated yet or is no longer active. Please contact the administrator.');
                return redirect()->to('/sign-in');
            }

            // User logged in successfully

            // Store user data in session or set cookies, etc.

            // Redirect to dashboard or desired page
            session()->setFlashdata('successAlert', 'Login successful!');
            return redirect()->to('/dashboard');
        } else {
            // Login failed: Redirect back to login page with an error message
            session()->setFlashdata('errorAlert', 'Invalid email/username or password');
            return view('front-end/sign-in/index');
        }
    }
}
