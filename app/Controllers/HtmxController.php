<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class HtmxController extends BaseController
{
    protected $helpers = ['data_helper', 'auth_helper'];
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



    public function backendSearchResults()
    {
        $search = $this->request->getPost('search_query');

        $searchResults = '<ul class="list-group">
                              <li class="list-group-item">First item</li>
                              <li class="list-group-item">Second item</li>
                              <li class="list-group-item">Third item</li>
                            </ul>';

        if(!empty($searchResults)){
            // Display results
            echo $searchResults;
        }

        //Exit to prevent bug: Uncaught RangeError: Maximum call stack size exceeded
        exit();
    }
}
