<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'user_id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'first_name', 'last_name', 'username', 'email', 'password', 'status'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'first_name' => 'required',
        'last_name' => 'required',
        'username' => 'required|is_unique[users.username]',
        'email' => 'required|valid_email|is_unique[users.email]',
        'password' => 'required',
    ];
    protected $validationMessages   = [
        'first_name' => 'first name is required',
        'last_name' => 'last name is required',
        'username' => 'username is required',
        'email' => 'email is required',
        'password' => 'password is required',
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function createUser($param = array())
    {
        // Generate a unique user ID (UUID)
        $userId = bin2hex(random_bytes(16)); // Generates a 32-character hexadecimal ID
        $password = password_hash($param['password'], PASSWORD_DEFAULT);
        $defaultStatus = 0;
        $data = [
            'user_id' => $userId,
            'first_name' => $param['first_name'],
            'last_name' => $param['last_name'],
            'username' => $param['username'],
            'email' => $param['email'],
            'password' => $password,
            'status' => $defaultStatus
        ];
        $this->save($data);

        return true;
    }

    public function validateLogin($login, $password)
    {
        // Check if the login is an email or username
        $user = $this->where('email', $login)
            ->orWhere('username', $login)
            ->first();

        // If user not found, return false
        if (!$user) {
            return false;
        }

        // Check if user status is active
        if ($user['status'] != 1) {
            return false;
        }

        // Verify the password
        if (!password_verify($password, $user['password'])) {
            return false;
        }

        // Password is valid, return the user data
        return $user;
    }

    public function validateStatus($login)
    {
        // Check if the login is an email or username
        $user = $this->where('email', $login)
            ->orWhere('username', $login)
            ->first();

        // Check if user status is active
        if ($user['status'] != 1) {
            return false;
        }

        // Return the user status
        return $user;
    }

}
