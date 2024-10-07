# CodeIgniter 4 Starter Project

This repository provides a CodeIgniter 4 starter application with essential features that simplify starting a new project. This includes examples of CRUD operations, integration with HTMX, usage of Datatables, and a complete user login system.

## Features
* User Authentication System
    * Registration and Login
    * Password Recovery
    * Updating Account Details and Password Change

* Admin Panel
    * User and Role Management
    * Activity Logging
    * Backend Module Search
    * Configurations Settings

* CRUD Operations Example
    * Example management of records with CRUD functionality
    * Usage of file manager feature

* Media & File Management
    * File uploads, handling, and media management

* General Enhancements
    * Activity Logging
    * Global Exception Handling
    * Easily Customizable Settings
    * Emailing Service Integration

## Getting Started
* Clone the Project
  Clone the repository by running:
```
git clone https://github.com/akassama/codeigniter-starter-app.git
```

* Set Up Base URL
  Edit the configuration file located in `app/Config/App.php`:
```
public string $baseURL = 'https://localhost/ci-starter-app/';
```
Replace the URL with your desired base URL for the project.

* Set Up Database Connection
  Edit the database configuration in `app/Config/Database.php`:
```
public $default = [
    'DSN'      => '',
    'hostname' => 'localhost',
    'username' => 'your_database_username',
    'password' => 'your_database_password',
    'database' => 'your_database_name',
    'DBDriver' => 'MySQLi',
    // other settings
];
```
Make sure to update the `hostname`, `username`, `password`, and `database` fields with your database connection details.

* Create the Database
  Using your database management system (e.g., PhpMyAdmin), create a new database with the same name specified in `Database.php`.

* Run Database Migrations
  Open your terminal and navigate to the project directory, then run:
```
php spark migrate
```
This command will execute all available migrations, creating the necessary database tables.

* Start the Project
  Ensure that your local server (e.g., Apache, Nginx) is running, then navigate to the base URL you set earlier:
```
https://localhost/ci-starter-app/
```

* Default Admin Login

    You can log in using the default Admin credentials:
    * Email: admin@example.com
    * Password: Admin@1
  
    To modify the default Admin login, go to the migration file located at `app/Database/Migrations/2024-08-27-210112_Users.php` and update the `$data[]` array accordingly.

## How to Customize System Features?
### Customizing Notification Messages
To customize system messages:
* Edit `app/Config/CustomConfig.php` to modify existing messages or add new ones.

### Customizing Activity Logging
To update activity log types:
* See  `app/Constants/ActivityTypes.php`
* Update the value or add new constants, for example
```
const PUSH_NOTIFICATION = 'push_notification';
```

* Add the description in the function
```
public static function getDescription($type)
{
    $descriptions = [
        self::PUSH_NOTIFICATION => 'Push Notification Sent',
        // Add more descriptions as needed
    ];

    return $descriptions[$type] ?? 'Unknown Activity';
}
```

## Usage Examples in Controllers
To see how configurations are used, review the code in AdminController or other controllers located in the `app/Controllers` directory.

### Helper Functions
There are multiple helper functions available to ease the development process:
* Authentication Helpers: `app/Helpers/auth_helper.php`
* Data Helpers: `app/Helpers/data_helper.php`

To see the available helper functions and how they are used, visit the `/test` route in your application, which provides descriptions and usage examples of the main functions.

### File Upload System
The application has a built-in file upload system for handling various types of files:
* Supported Types: Docs (`.doc, .docx, .pdf, .txt, .rtf, .odt.`), Images (`jpg, png, gif, jpeg`), Audios (`.mp3, .wav, .ogg`) and Videos (`.mp4, .avi, .mov.`)
* Maximum File Size: 5MB. You can modify this value in `public\back-end\assest\js\script.js` and modify `Cookies.set('max_file_size', '5')`
* Validation and configuration can be updated in the relevant controller handling file uploads.

### Other Features Summary

* User & Admin Module: Management for different user roles and actions.
* Search Module: Backend search capabilities to easily navigate records.
* Global Exception Handling: Handle application-wide exceptions gracefully.
* Easily Customizable: The application structure is modular to facilitate easy updates and modifications.

### License
This project is licensed under the [MIT License](https://opensource.org/licenses/MIT).

### Contributing
If you would like to contribute to this project, please fork the repository and submit a pull request.
