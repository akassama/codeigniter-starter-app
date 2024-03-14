<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsersModel;

class SignUpController extends BaseController
{
    protected $helpers = ['form'];

    public function index()
    {
        return view('front-end/sign-up/index');
    }

    public function addRegistration()
    {
        // Load the UsersModel
        $usersModel = new UsersModel();

        // Validation rules from the model
        $validationRules = $usersModel->getValidationRules();

        // Validate the incoming data
        if (!$this->validate($validationRules)) {
            // If validation fails, return validation errors
            return $this->response->setJSON([
                'status' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        // If validation passes, create the user
        $userData = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
        ];

        // Call createUser method from the UsersModel
        if ($usersModel->createUser($userData)) {

            //inserted user_id
            $insertedId = $usersModel->getInsertID();

            // User created successfully
            return $this->response->setJSON([
                'status' => true,
                'message' => 'User created successfully'
            ]);
        } else {
            // Failed to create user
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Failed to create user'
            ]);
        }
    }

}
