<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class HtmxController extends BaseController
{
    protected $helpers = ['data_helper', 'auth_helper'];

    /**
     * Checks if a user email exists in the database.
     * Echoes a message if the email already exists.
     * @return void
     */
    public function userEmailExists()
    {
        $userEmail = $this->request->getPost('email');
        $tableName = 'users';
        $primaryKey = 'email';

        if(!empty($userEmail)){
            if (recordExists($tableName, $primaryKey, $userEmail)) {
                // Record already exists
                echo '<span class="text-danger">User with email ('.$userEmail.') already exists</span>';
            }
        }

        //Exit to prevent bug: Uncaught RangeError: Maximum call stack size exceeded
        exit();
    }

    /**
     * Checks if a username exists in the database.
     * Echoes a message if the username already exists.
     * @return void
     */
    public function userUsernameExists()
    {
        $username = $this->request->getPost('username');
        $tableName = 'users';
        $primaryKey = 'username';

        if(!empty($username)){
            if (recordExists($tableName, $primaryKey, $username)) {
                // Record already exists
                echo '<span class="text-danger">User with username ('.$username.') already exists</span>';
            }
        }

        //Exit to prevent bug: Uncaught RangeError: Maximum call stack size exceeded
        exit();
    }

    /**
     * Validates the given password against a pattern.
     * Echoes an error message if the password is invalid.
     * @return void
     */
    public function checkPasswordIsValid()
    {
        $password = $this->request->getPost('password');

        // Regex pattern for password validation
        $pattern = '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[^A-Za-z\d]).{6,}$/';

        if(!empty($password)){
            // Check if the password matches the pattern
            if (!preg_match($pattern, $password)) {
                echo '<span class="text-danger">
                    <p>The password must be at least 6 characters long.<br/>
                    The password must contain at least one letter, one digit, and one special character.</p>
                  </span>';
            }
        }

        //Exit to prevent bug: Uncaught RangeError: Maximum call stack size exceeded
        exit();
    }

    /**
     * Checks if two passwords match.
     * Echoes an error message if passwords do not match.
     * @return void
     */
    public function checkPasswordsMatch()
    {
        $password = $this->request->getPost('password');
        $repeatPassword = $this->request->getPost('repeat_password');

        if($password != $repeatPassword){
            // Passwords do not match
            echo '<span class="text-danger">Passwords do not match</span>';
        }

        //Exit to prevent bug: Uncaught RangeError: Maximum call stack size exceeded
        exit();
    }

    /**
     * Checks if a contact number exists in the database.
     * Echoes a message if the contact number already exists.
     * @return void
     */
    public function contactNumberExists()
    {
        $contactNumber = $this->request->getPost('contact_number');
        $tableName = 'contacts';
        $primaryKey = 'contact_number';

        if(!empty($contactNumber)){
            if (recordExists($tableName, $primaryKey, $contactNumber)) {
                // Record already exists
                echo '<span class="text-danger">Contact with number ('.$contactNumber.') already exists</span>';
            }
        }

        //Exit to prevent bug: Uncaught RangeError: Maximum call stack size exceeded
        exit();
    }

    /**
     * Checks if an edited contact number already exists in the database.
     * Echoes a message if the contact number already exists.
     * @return void
     */
    public function editContactNumberExists()
    {
        $contactId = $this->request->getPost('contact_id');
        $contactNumber = $this->request->getPost('contact_number');
        $tableName = 'contacts';
        $primaryKey = 'contact_number';
        $whereClause = "contact_number = '$contactNumber' AND contact_id != '$contactId'";

        if(!empty($contactNumber) && !empty($contactId)){
            if (checkRecordExists($tableName, $primaryKey, $whereClause)) {
                // Record already exists
                echo '<span class="text-danger">Another contact with number ('.$contactNumber.') already exists</span>';
            }
        }

        //Exit to prevent bug: Uncaught RangeError: Maximum call stack size exceeded
        exit();
    }

    /**
     * Checks if a configuration with a specific identifier exists in the database.
     * Echoes a message if the configuration already exists.
     * @return void
     */
    public function configForExists()
    {
        $configFor = $this->request->getPost('config_for');
        $tableName = 'configurations';
        $primaryKey = 'config_for';

        if(!empty($configFor)){
            if (recordExists($tableName, $primaryKey, $configFor)) {
                // Record already exists
                echo '<span class="text-danger">Config for ('.$configFor.') already exists</span>';
            }
        }

        //Exit to prevent bug: Uncaught RangeError: Maximum call stack size exceeded
        exit();
    }
}
