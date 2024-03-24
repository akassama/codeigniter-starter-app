<?php
// app/Config/CustomConfig.php
namespace Config;

use CodeIgniter\Config\BaseConfig;

class CustomConfig extends BaseConfig
{
    #--------------------------------------------------------------------
    # MESSAGES
    #--------------------------------------------------------------------
    public $wrongCredentialsMsg = 'Sign In Failed. The provided username/email or password is incorrect.';
    public $loginSuccessMsg = 'Login successful.';
    public $logoutSuccessMsg = 'You have been successfully logged out.';
    public $pendingActivationMsg = 'Your account has not been activated yet or is no longer active. Please contact the administrator.';
    public $invalidAccessMsg = 'You do not have access to this area.';
    public $createSuccessMsg = 'Record created successfully.';
    public $editSuccessMsg = 'Record updated successfully.';
    public $deleteSuccessMsg = 'Record removed successfully.';
    public $missingRequiredInputsMsg = 'There are validation errors. Possible missing required inputs.';
    public $notFoundMsg = 'Record not found.';
    public $errorMsg = 'Oops! Something went wrong. Please try again later.';
    public $exceptionMsg = 'There was an error processing your request. Please try again. If this error persists, please see or send an email to system administrator.';
}