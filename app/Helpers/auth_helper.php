<?php

/**
 * Checks if a user has a specific role.
 *
 * @param string $userEmail The user's email address.
 * @param string $role The role to check for.
 * @return boolean True if the user has the role, false otherwise.
 */
if(!function_exists('userHasRole')) {
    function userHasRole($userEmail, $role)
    {
        //user role
        $userRole = getUserRole($userEmail);

        if ($userRole == $role) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Gets the role of a user based on their email or username.
 *
 * @param string $userEmailOrUsername The user's email or username.
 * @return string|null The user's role, or null if not found.
 */
if (!function_exists('getUserRole')) {
    function getUserRole($userEmailOrUsername) {
        $db = \Config\Database::connect();

        $column = filter_var($userEmailOrUsername, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $query = $db->table('users')
            ->select('role')
            ->where($column, $userEmailOrUsername)
            ->get();

        return $query->getNumRows() > 0 ? $query->getRow()->role : null;
    }
}

/**
 * Gets the status of a user based on their email or username.
 *
 * @param string $userEmailOrUsername The user's email or username.
 * @return string|null The user's status, or null if not found.
 */
if (!function_exists('getUserStatus')) {
    function getUserStatus($userEmailOrUsername) {
        $db = \Config\Database::connect();

        $column = filter_var($userEmailOrUsername, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $query = $db->table('users')
            ->select('status')
            ->where($column, $userEmailOrUsername)
            ->get();

        return $query->getNumRows() > 0 ? $query->getRow()->status : null;
    }
}

/**
 * Gets the HTML label for a user's status.
 *
 * @param string $status The user's status.
 * @return string The HTML label for the status.
 */
if (!function_exists('getUserStatusLabel')) {
    function getUserStatusLabel($status) {
        if($status == '0'){
            return "<span class='badge bg-secondary'>Inactive</span>";
        }
        else if($status == '1'){
            return "<span class='badge bg-success'>Active</span>";
        }
        else if($status == '2'){
            return "<span class='badge bg-danger'>Closed</span>";
        }
        else {
            return "<span class='badge bg-danger'>NA</span>";
        }
    }
}

/**
 * Gets the plain text status of a user.
 *
 * @param string $status The user's status.
 * @return string The plain text status.
 */
if (!function_exists('getUserStatusOnly')) {
    function getUserStatusOnly($status) {
        if($status == '0'){
            return "Inactive";
        }
        else if($status == '1'){
            return "Active";
        }
        else if($status == '2'){
            return "Closed";
        }
        else {
            return "NA";
        }
    }
}
?>
