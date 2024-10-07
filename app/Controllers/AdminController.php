<?php

namespace App\Controllers;

use App\Constants\ActivityTypes;
use App\Controllers\BaseController;
use App\Models\ConfigurationsModel;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsersModel;
use App\Models\ActivityLogsModel;

class AdminController extends BaseController
{
    protected $helpers = ['auth_helper'];
    protected $session;
    public function __construct()
    {
        // Initialize session once in the constructor
        $this->session = session();
    }

    public function index()
    {
        return view('back-end/admin/index');
    }

    public function users()
    {
        $tableName = 'users';
        $usersModel = new UsersModel();

        // Set data to pass in view
        $data = [
            'users' => $usersModel->orderBy('first_name', 'ASC')->findAll(),
            'totalUsers' => getTotalRecords($tableName)
        ];

        return view('back-end/admin/users/index', $data);
    }

    public function newUser()
    {
        return view('back-end/admin/users/new-user');
    }

    public function addUser()
    {
        //get logged-in user id
        $loggedInUserId = $this->session->get('user_id');

        // Load the UsersModel
        $usersModel = new UsersModel();

        // Validation rules from the model
        $validationRules = $usersModel->getValidationRules();

        // Validate the incoming data
        if (!$this->validate($validationRules)) {
            // If validation fails, return validation errors
            $data['validation'] = $this->validator;
            return view('back-end/admin/users/new-user');
        }

        // If validation passes, create the user
        $userData = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'status' => $this->request->getPost('status'),
            'role' => $this->request->getPost('role'),
        ];

        // Call createUser method from the UsersModel
        if ($usersModel->createUser($userData)) {
            //inserted user_id
            $insertedId = $usersModel->getInsertID();

            // Record created successfully. Redirect to dashboard
            $createSuccessMsg = config('CustomConfig')->createSuccessMsg;
            session()->setFlashdata('successAlert', $createSuccessMsg);

            //log activity
            logActivity($loggedInUserId, ActivityTypes::USER_CREATION, 'User created with id: ' . $insertedId);

            return redirect()->to('/account/admin/users');
        } else {
            // Failed to create record. Redirect to dashboard
            $errorMsg = config('CustomConfig')->errorMsg;
            session()->setFlashdata('errorAlert', $errorMsg);

            //log activity
            logActivity($loggedInUserId, ActivityTypes::FAILED_USER_CREATION, 'Failed to create user with id: ' . $this->request->getPost('email'));

            return view('back-end/admin/users/new-user');
        }
    }

    public function editUser($userId)
    {
        $usersModel = new UsersModel();

        // Fetch the data based on the id
        $user = $usersModel->where('user_id', $userId)->first();

        if (!$user) {
            $errorMsg = config('CustomConfig')->notFoundMsg;
            session()->setFlashdata('errorAlert', $errorMsg);
            return redirect()->to('/account/admin/users');
        }

        // Set data to pass in view
        $data = [
            'user_data' => $user
        ];

        return view('back-end/admin/users/edit-user', $data);
    }

    public function updateUser()
    {
        //get logged-in user id
        $loggedInUserId = $this->session->get('user_id');

        $usersModel = new UsersModel();

        // Custom validation rules
        $rules = [
            'user_id' => 'required',
            'first_name' => 'required|max_length[50]|min_length[2]',
            'last_name' => 'required|max_length[50]|min_length[2]',
            'status' => 'required',
            'role' => 'required',
        ];

        $userId = $this->request->getVar('user_id');
        $data['user_data'] = $usersModel->where('user_id', $userId)->first();

        if($this->validate($rules)){
            $userId = $this->request->getVar('user_id');

            $db = \Config\Database::connect();
            $builder = $db->table('users');
            $data = [
                'first_name' => $this->request->getVar('first_name'),
                'last_name'  => $this->request->getVar('last_name'),
                'status'  => $this->request->getVar('status'),
                'role'  => $this->request->getVar('role'),
            ];

            $builder->where('user_id', $userId);
            $builder->update($data);

            // Record updated successfully. Redirect to dashboard
            $createSuccessMsg = config('CustomConfig')->editSuccessMsg;
            session()->setFlashdata('successAlert', $createSuccessMsg);

            //log activity
            logActivity($loggedInUserId, ActivityTypes::USER_UPDATE, 'User updated with id: ' . $userId);

            return redirect()->to('/account/admin/users');
        }
        else{
            $data['validation'] = $this->validator;
            $errorMsg = config('CustomConfig')->missingRequiredInputsMsg;
            session()->setFlashdata('errorAlert', $errorMsg);

            //log activity
            logActivity($loggedInUserId, ActivityTypes::FAILED_USER_UPDATE, 'Failed to update user with id: ' . $this->request->getPost('email'));

            return view('back-end/admin/users/edit-user', $data);
        }
    }

    public function viewUser($userId)
    {
        $usersModel = new UsersModel();

        // Fetch the data based on the id
        $user = $usersModel->where('user_id', $userId)->first();

        if (!$user) {
            $errorMsg = config('CustomConfig')->notFoundMsg;
            session()->setFlashdata('errorAlert', $errorMsg);
            return redirect()->to('/account/admin/users');
        }

        // Set data to pass in view
        $data = [
            'user_data' => $user
        ];

        return view('back-end/admin/users/view-user', $data);
    }

    public function activityLogs()
    {
        $tableName = 'activity_logs';
        $activityLogsModel = new ActivityLogsModel();

        // Set data to pass in view
        $data = [
            'activity_logs' => $activityLogsModel->orderBy('created_at', 'DESC')->findAll(),
            'totalActivities' => getTotalRecords($tableName)
        ];

        return view('back-end/admin/activity-logs/index', $data);
    }

    public function viewActivity($activityId)
    {
        $activityLogsModel = new ActivityLogsModel();

        // Fetch the data based on the id
        $activity = $activityLogsModel->where('activity_id', $activityId)->first();

        if (!$activity) {
            $errorMsg = config('CustomConfig')->notFoundMsg;
            session()->setFlashdata('errorAlert', $errorMsg);
            return redirect()->to('/account/admin/activity-logs');
        }

        // Set data to pass in view
        $data = [
            'activity_data' => $activity
        ];

        return view('back-end/admin/activity-logs/view-activity', $data);
    }

    public function configurations()
    {
        $tableName = 'configurations';
        $configModel = new ConfigurationsModel();

        // Set data to pass in view
        $data = [
            'configurations' => $configModel->orderBy('config_for', 'ASC')->findAll(),
            'totalConfigurations' => getTotalRecords($tableName)
        ];

        return view('back-end/admin/configurations/index', $data);
    }

    public function newConfiguration()
    {
        return view('back-end/admin/configurations/new-config');
    }

    public function addConfiguration()
    {
        //get logged-in user id
        $loggedInUserId = $this->session->get('user_id');

        // Load the ConfigurationsModel
        $configModel = new ConfigurationsModel();

        // Validation rules from the model
        $validationRules = $configModel->getValidationRules();

        // Validate the incoming data
        if (!$this->validate($validationRules)) {
            // If validation fails, return validation errors
            $data['validation'] = $this->validator;
            return view('back-end/admin/configurations/new-config');
        }

        // If validation passes, create the config
        $configData = [
            'config_for' => $this->request->getPost('config_for'),
            'config_value' => $this->request->getPost('config_value'),
        ];

        // Call createConfiguration method from the ConfigModel
        if ($configModel->createConfiguration($configData)) {
            //inserted user_id
            $insertedId = $configModel->getInsertID();

            // Record created successfully. Redirect to dashboard
            $createSuccessMsg = config('CustomConfig')->createSuccessMsg;
            session()->setFlashdata('successAlert', $createSuccessMsg);

            //log activity
            logActivity($loggedInUserId, ActivityTypes::CONFIG_CREATION, 'Configuration created with id: ' . $insertedId);

            return redirect()->to('/account/admin/configurations');
        } else {
            // Failed to create record. Redirect to dashboard
            $errorMsg = config('CustomConfig')->errorMsg;
            session()->setFlashdata('errorAlert', $errorMsg);

            //log activity
            logActivity($loggedInUserId, ActivityTypes::FAILED_CONFIG_CREATION, 'Failed to create configuration.');

            return view('back-end/admin/configurations/new-config');
        }
    }

    public function editConfiguration($configId)
    {
        $configModel = new ConfigurationsModel();

        // Fetch the data based on the id
        $configuration = $configModel->where('config_id', $configId)->first();

        if (!$configuration) {
            $errorMsg = config('CustomConfig')->notFoundMsg;
            session()->setFlashdata('errorAlert', $errorMsg);
            return redirect()->to('/account/admin/configurations');
        }

        // Set data to pass in view
        $data = [
            'config_data' => $configuration
        ];

        return view('back-end/admin/configurations/edit-config', $data);
    }

    public function updateConfiguration()
    {
        //get logged-in user id
        $loggedInUserId = $this->session->get('user_id');

        $configModel = new ConfigurationsModel();

        // Custom validation rules
        $rules = [
            'config_id' => 'required',
            'config_for' => 'required',
            'config_value' => 'required',
        ];

        $configId = $this->request->getVar('config_id');
        $data['config_data'] = $configModel->where('config_id', $configId)->first();

        if($this->validate($rules)){
            $db = \Config\Database::connect();
            $builder = $db->table('configurations');
            $data = [
                'config_for' => $this->request->getVar('config_for'),
                'config_value'  => $this->request->getVar('config_value'),
            ];

            $builder->where('config_id', $configId);
            $builder->update($data);

            // Record updated successfully. Redirect to dashboard
            $createSuccessMsg = config('CustomConfig')->editSuccessMsg;
            session()->setFlashdata('successAlert', $createSuccessMsg);

            //log activity
            logActivity($loggedInUserId, ActivityTypes::CONFIG_UPDATE, 'Config updated with id: ' . $configId);

            return redirect()->to('/account/admin/configurations');
        }
        else{
            $data['validation'] = $this->validator;
            $errorMsg = config('CustomConfig')->missingRequiredInputsMsg;
            session()->setFlashdata('errorAlert', $errorMsg);

            //log activity
            logActivity($loggedInUserId, ActivityTypes::FAILED_CONFIG_UPDATE, 'Failed to update config with id: ' . $this->request->getPost('config_id'));

            return view('back-end/admin/configurations/edit-config', $data);
        }
    }
}
