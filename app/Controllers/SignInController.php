<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsersModel;
use CodeIgniter\HTTP\ResponseInterface;

class SignInController extends BaseController
{
    public function index()
    {
        return view('front-end/sign-in/index');
    }

    public function login()
    {
        //set validation rules
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|max_length[255]',
        ];

        //if valid
        if($this->validate($rules)){
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
                    $pendingActivationMsg = config('CustomConfig')->pendingActivationMsg;
                    session()->setFlashdata('errorAlert', $pendingActivationMsg);
                    return redirect()->to('/sign-in');
                }

                // User logged in successfully. Store user data in session
                session()->set([
                    'user_id' => $user['user_id'],
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'is_logged_in' => TRUE
                ]);

                // Redirect to dashboard
                $loginSuccessMsg = config('CustomConfig')->loginSuccessMsg;
                session()->setFlashdata('successAlert', $loginSuccessMsg);
                return redirect()->to('/account/dashboard');
            } else {
                // Login failed: Redirect back to login page with an error message
                $wrongCredentialsMsg = config('CustomConfig')->wrongCredentialsMsg;
                session()->setFlashdata('errorAlert', $wrongCredentialsMsg);
                return view('front-end/sign-in/index');
            }
        }else{
            $data['validation'] = $this->validator;
            return view('front-end/sign-in/index');
        }
    }
}
