<?php

namespace App\Constants;

/**
 * ActivityTypes class
 *
 * This class defines constants representing different activity types used in the application.
 *
 * @namespace App\Constants
 */
class ActivityTypes
{
    //AUTH LOGS
    const USER_REGISTRATION = 'user_registration';
    const FAILED_USER_REGISTRATION = 'failed_user_registration';
    const USER_LOGIN = 'user_login';
    const USER_LOGOUT = 'user_logout';
    const FAILED_USER_LOGIN = 'failed_user_login';

    //CONTACT LOGS
    const CONTACT_CREATION = 'contact_created';
    const FAILED_CONTACT_CREATION = 'failed_contact_creation';
    const CONTACT_UPDATE = 'contact_updated';
    const FAILED_CONTACT_UPDATE = 'failed_contact_update';
    const CONTACT_DELETION = 'contact_delete';

    //USER LOGS
    const USER_CREATION = 'user_created';
    const FAILED_USER_CREATION = 'failed_user_creation';
    const USER_UPDATE = 'user_updated';
    const FAILED_USER_UPDATE = 'failed_user_update';
    const USER_DELETION = 'user_delete';

    //USER LOGS
    const FILE_UPLOADED = 'file_uploaded';
    const FAILED_FILE_UPLOAD = 'failed_file_upload';
    const FILE_DELETION = 'file_delete';

    //PASSWORD LOGS
    const PASSWORD_CHANGED = 'password_changed';
    const FAILED_PASSWORD_CHANGED = 'failed_password_changed';

    //SETTINGS LOG
    const ACCOUNT_DETAILS_UPDATE = 'account_details_update';
    const FAILED_ACCOUNT_DETAILS_UPDATE = 'failed_account_details_update';
    const SETTINGS_UPDATE = 'settings_update';

    //PASSWORD RESETS
    const PASSWORD_RESET_SUCCESS = 'password_reset';
    const PASSWORD_RESET_SENT = 'password_reset_link_sent';
    const PASSWORD_RESET_FAILED = 'failed_password_reset_link';

    //CONFIGURATIONS
    const CONFIG_CREATION = 'config_created';
    const FAILED_CONFIG_CREATION = 'failed_config_creation';
    const CONFIG_UPDATE = 'config_updated';
    const FAILED_CONFIG_UPDATE = 'failed_config_update';
    const CONFIG_DELETION = 'config_delete';

    //SEARCH LOG
    const MODULE_SEARCH = 'module_search';

    //DELETE LOG
    const DELETE_LOG = 'delete_log';
    const FAILED_DELETE_LOG = 'failed_delete_log';
    // Add more activity types as needed

    /**
     * Gets the description for a given activity type.
     *
     * @param string $type The activity type.
     * @return string The description of the activity type, or "Unknown Activity" if not found.
     */
    public static function getDescription($type)
    {
        $descriptions = [
            self::USER_REGISTRATION => 'User Registration',
            self::FAILED_USER_REGISTRATION => 'User Registration Failed',
            self::USER_LOGIN => 'User Login',
            self::USER_LOGOUT => 'User Logout',
            self::FAILED_USER_LOGIN => 'Failed User Login',

            self::CONTACT_CREATION => 'Contact Creation',
            self::FAILED_CONTACT_CREATION => 'Contact Creation Failed',
            self::CONTACT_UPDATE => 'Contact Update',
            self::FAILED_CONTACT_UPDATE => 'Contact Update Failed',
            self::CONTACT_DELETION => 'Contact Deletion',

            self::USER_CREATION => 'User Creation',
            self::FAILED_USER_CREATION => 'User Creation Failed',
            self::USER_UPDATE => 'User Update',
            self::FAILED_USER_UPDATE => 'User Update Failed',
            self::USER_DELETION => 'User Deletion',

            self::FILE_UPLOADED => 'File Uploaded',
            self::FAILED_FILE_UPLOAD => 'File Upload Failed',
            self::FILE_DELETION => 'File Deleted',

            self::PASSWORD_CHANGED => 'Password Changed',
            self::FAILED_PASSWORD_CHANGED => 'Password Changed Failed',

            self::PASSWORD_RESET_SUCCESS => 'Password Reset',
            self::PASSWORD_RESET_SENT => 'Password Reset Link Sent',
            self::PASSWORD_RESET_FAILED => 'Password Reset Link Failed',

            self::CONFIG_CREATION => 'Config Creation',
            self::FAILED_CONFIG_CREATION => 'Config Creation Failed',
            self::CONFIG_UPDATE => 'Config Update',
            self::FAILED_CONFIG_UPDATE => 'Config Update Failed',
            self::CONFIG_DELETION => 'Config Deletion',

            self::ACCOUNT_DETAILS_UPDATE => 'Account Details Update',
            self::SETTINGS_UPDATE => 'Settings Update',

            self::MODULE_SEARCH => 'Module Search',

            self::DELETE_LOG => 'Delete Action',
            self::FAILED_DELETE_LOG => 'Failed Delete Action',
            // Add more descriptions as needed
        ];

        return $descriptions[$type] ?? 'Unknown Activity';
    }
}