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
    public $resetLinkMsg = 'A password reset link has been sent to your email address. Please check your inbox and follow the instructions to reset your password. If you do not see the email in your inbox, please check your spam or junk folder.';
    public $invalidResetLinkMsg = 'Invalid or expired password reset link.';
    public $passwordResetSuccessfulMsg = 'Your password has been reset successfully. You can now log in with your new password.';
    public $passwordResetFailedMsg = 'Unable to reset password. Please try again';
    public $nonExistingResetEmailMsg = 'We are sorry, but the email address you entered is not associated with any account. Please check the email address and try again.';
    public $exceptionMsg = 'There was an error processing your request. Please try again. If this error persists, please see or send an email to system administrator.';


    #--------------------------------------------------------------------
    # COMPANY
    #--------------------------------------------------------------------
    public $companyName = 'CI-Starter App';
    public $companyEmail = 'ci-starter@mail.com';
    public $companyAddress = '123 Maple Street<br/> Watford, Hertfordshire<br/> WD17 1AA<br/> United Kingdom';

}