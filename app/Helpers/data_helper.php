<?php
/**
 * Returns a GUIDv4 string
 *
 * Uses the best cryptographically secure method
 * for all supported platforms with fallback to an older,
 * less secure version.
 *
 * @param bool $trim
 * @return string
 */
if(!function_exists('getGUID')){
    function getGUID ($trim = true)
    {
        // Windows
        if (function_exists('com_create_guid') === true) {
            if ($trim === true)
                return trim(com_create_guid(), '{}');
            else
                return com_create_guid();
        }

        // OSX/Linux
        if (function_exists('openssl_random_pseudo_bytes') === true) {
            $data = openssl_random_pseudo_bytes(16);
            $data[6] = chr(ord($data[6]) & 0x0f | 0x40);    // set version to 0100
            $data[8] = chr(ord($data[8]) & 0x3f | 0x80);    // set bits 6-7 to 10
            return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
        }

        // Fallback (PHP 4.2+)
        mt_srand((double)microtime() * 10000);
        $charid = strtolower(md5(uniqid(rand(), true)));
        $hyphen = chr(45);                  // "-"
        $lbrace = $trim ? "" : chr(123);    // "{"
        $rbrace = $trim ? "" : chr(125);    // "}"
        $guidv4 = $lbrace.
            substr($charid,  0,  8).$hyphen.
            substr($charid,  8,  4).$hyphen.
            substr($charid, 12,  4).$hyphen.
            substr($charid, 16,  4).$hyphen.
            substr($charid, 20, 12).
            $rbrace;
        return $guidv4;
    }
}

/**
 * Check if records exist in a table.
 *
 * @param string $tableName      The name of the table.
 * @param string $primaryKey     The primary key column name.
 * @param mixed  $primaryKeyValue The value of the primary key.
 * @return bool True if records exist, false otherwise.
 */
if(!function_exists('recordExists')) {
    function recordExists(string $tableName, string $primaryKey, $primaryKeyValue): bool
    {
        $db = \Config\Database::connect();
        $query = $db->table($tableName)->where($primaryKey, $primaryKeyValue)->get();
        return $query->getNumRows() > 0;
    }
}

/**
 * Delete a record if it exists.
 *
 * @param string $tableName      The name of the table.
 * @param string $primaryKey     The primary key column name.
 * @param mixed  $primaryKeyValue The value of the primary key.
 * @return bool True if deletion was successful, false otherwise.
 */
if(!function_exists('deleteRecord')) {
    function deleteRecord(string $tableName, string $primaryKey, $primaryKeyValue): bool
    {
        $db = \Config\Database::connect();

        $builder = $db->table($tableName);
        $builder->where($primaryKey, $primaryKeyValue);
        $result = $builder->delete();

        return $result && $db->affectedRows() > 0;
    }
}

/**
 * Get all records with an optional WHERE clause.
 *
 * @param string $tableName   The name of the table.
 * @param string $whereClause Optional WHERE clause (e.g., "status = 'active'").
 * @return array An array of records.
 */
if(!function_exists('getAllRecords')) {
    function getAllRecords(string $tableName, string $whereClause = ''): array
    {
        $db = \Config\Database::connect();
        if (!empty($whereClause)) {
            $db->where($whereClause);
        }
        $query = $db->table($tableName)->get();
        return $query->getResultArray();
    }
}

/**
 * Get a single record with a WHERE clause.
 *
 * @param string $tableName   The name of the table.
 * @param string $whereClause The WHERE clause (e.g., "user_id = 123").
 * @return array|null The record or null if not found.
 */
if(!function_exists('getSingleRecord')) {
    function getSingleRecord(string $tableName, string $whereClause): ?array
    {
        $db = \Config\Database::connect();
        $query = $db->table($tableName)->where($whereClause)->get();
        $result = $query->getRowArray();
        return $result ?: null;
    }
}

/**
 * Add a data record.
 *
 * @param string $tableName The name of the table.
 * @param array  $data      Associative array of data to insert.
 * @return bool True if insertion was successful, false otherwise.
 */
if(!function_exists('addRecord')) {
    function addRecord(string $tableName, array $data): bool
    {
        $db = \Config\Database::connect();
        return $db->table($tableName)->insert($data);
    }
}

/**
 * Update a data record.
 *
 * @param string $tableName   The name of the table.
 * @param array  $data        Associative array of data to update.
 * @param string $whereClause The WHERE clause (e.g., "user_id = 123").
 * @return bool True if update was successful, false otherwise.
 */
if(!function_exists('updateRecord')) {
    function updateRecord(string $tableName, array $data, string $whereClause): bool
    {
        $db = \Config\Database::connect();
        return $db->table($tableName)->where($whereClause)->update($data);
    }
}

/**
 * Get the total count of records with an optional WHERE clause.
 *
 * @param string $tableName   The name of the table.
 * @param string $whereClause Optional WHERE clause (e.g., "status = 'active'").
 * @return int The total count of records.
 */
if(!function_exists('getTotalRecords')) {
    function getTotalRecords(string $tableName, string $whereClause = ''): int
    {
        $db = \Config\Database::connect();
        if (!empty($whereClause)) {
            $db->where($whereClause);
        }
        return $db->table($tableName)->countAllResults();
    }
}

/**
 * Get paginated records from a table.
 *
 * @param string $tableName The name of the table.
 * @param int    $take      Number of records to retrieve.
 * @param int    $skip      Number of records to skip.
 * @param string $where     Optional WHERE clause.
 * @return array An array of paginated records.
 */
if(!function_exists('getPaginatedRecords')) {
    function getPaginatedRecords(string $tableName, int $take, int $skip, string $whereClause = ''): array
    {
        $db = \Config\Database::connect();
        if (!empty($where)) {
            $db->where($where);
        }

        $query = $db->table($tableName)->limit($take, $skip)->get();
        return $query->getResultArray();
    }
}

/**
 * Retrieves data from a specified database table based on the given conditions.
 *
 * @param {string} $tableName - The name of the database table.
 * @param {array} $whereClause - An associative array representing the WHERE clause conditions (e.g., ['column_name' => 'value']).
 * @param {string} $returnColumn - The name of the column to retrieve data from.
 * @return {mixed} The value of the specified column or null if no record is found.
 */
if(!function_exists('getTableData')) {
    function getTableData($tableName, $whereClause, $returnColumn)
    {
        // Connect to the database
        $db = \Config\Database::connect();

        // Build the query
        $query = $db->table($tableName)
            ->select($returnColumn)
            ->where($whereClause)
            ->get();

        if ($query->getNumRows() > 0) {
            // Retrieve the result
            $row = $query->getRow();
            return $row->$returnColumn;
        } else {
            // No record found, return null
            return null;
        }
    }
}

/**
 * Execute a custom SQL query.
 *
 * @param string $sql The SQL query.
 * @return mixed Result of the query (e.g., array, boolean, etc.).
 */
if(!function_exists('executeCustomQuery')) {
    function executeCustomQuery(string $sql)
    {
        $db = \Config\Database::connect();
        $query = $db->query($sql);
        return $query->getResult(); // Adjust this based on your query result type
    }
}

/**
 * Truncates a table, permanently removing all data. Use with caution!
 *
 * @param string $tableName  The name of the database table to truncate.
 * @return bool  True if truncation was successful, false otherwise.
 */
if(!function_exists('truncateTable')) {
    function truncateTable(string $tableName): bool
    {
        $db = \Config\Database::connect();
        $builder = $db->table($tableName);
        $result = $builder->truncate();

        return $result;
    }
}

/**
 * Retrieves the size of an existing file.
 *
 * @param {string} $file - The path to the file.
 * @param {string} [$type="MB"] - Measurement type ("KB" or "MB").
 * @return {float|string} The file size in the specified measurement type or an error message.
 */

if (!function_exists('getFileSize')) {
    function getFileSize($file, $type = "MB") {
        // Check if the file exists
        if (!is_file($file)) {
            return "File not found.";
        }

        // Get the file size in bytes
        $size = filesize($file);

        // Convert to the specified measurement type
        switch (strtoupper($type)) {
            case "KB":
                $sizeFormatted = round($size / 1024, 2); // Kilobytes
                break;
            case "MB":
                $sizeFormatted = round($size / (1024 * 1024), 2); // Megabytes
                break;
            default:
                return 0.0;
        }

        return $sizeFormatted;
    }
}

/**
 * Checks if the provided file is a valid image.
 *
 * @param {object} $file - The uploaded file (CodeIgniter\HTTP\Files\UploadedFile object).
 * @return {boolean} True if the file is a valid image; otherwise, false.
 */

if (!function_exists('isValidImage')) {
    function isValidImage($file) {
        // Check if file is not empty
        if (empty($file)) {
            return false;
        }

        // Validate image file types
        $allowedImageExtensions = ['png', 'jpg', 'jpeg', 'gif', 'bmp'];
        $fileExtension = strtolower(pathinfo($file->getName(), PATHINFO_EXTENSION));
        return in_array($fileExtension, $allowedImageExtensions);
    }
}

/**
 * Checks if the provided file is a valid document.
 *
 * @param {object} $file - The uploaded file (CodeIgniter\HTTP\Files\UploadedFile object).
 * @return {boolean} True if the file is a valid document; otherwise, false.
 */
if (!function_exists('isValidIDocFile')) {
    function isValidIDocFile($file) {
        // Check if file is not empty
        if (empty($file)) {
            return false;
        }

        // Validate document file types
        $allowedDocExtensions = ['pdf', 'doc', 'docx', 'xls'];
        $fileExtension = strtolower(pathinfo($file->getName(), PATHINFO_EXTENSION));
        return in_array($fileExtension, $allowedDocExtensions);
    }
}

/**
 * Checks if the file extension matches the specified extension.
 *
 * @param {object} $file - The uploaded file (CodeIgniter\HTTP\Files\UploadedFile object).
 * @param {string} $ext - The desired file extension (e.g., 'pdf', 'doc').
 * @return {boolean} True if the file extension matches; otherwise, false.
 */
if (!function_exists('hasValidFileExt')) {
    function hasValidFileExt($file, $ext) {
        // Check if file is not empty
        if (empty($file)) {
            return false;
        }

        // Validate against the provided extension
        $fileExtension = strtolower(pathinfo($file->getName(), PATHINFO_EXTENSION));
        return ($fileExtension === strtolower($ext));
    }
}

/**
 * Validates and uploads a file to the specified path.
 *
 * @param {object} $file - The uploaded file (CodeIgniter\HTTP\Files\UploadedFile object).
 * @param {string} $path - The path for saving the file.
 * @param {string} [$defaultResponse=""] - Default response if file or path is null/empty.
 * @return {string} The uploaded file path or the default response.
 */
if (!function_exists('uploadFile')) {
    function uploadFile($file, $path, $defaultResponse = "") {
        // Check if file and path are not empty
        if (empty($file) || empty($path)) {
            return $defaultResponse;
        }

        // Validate file type
        $allowedExtensions = ['png', 'jpg', 'jpeg', 'pdf', 'doc', 'docx', 'xls'];
        $fileExtension = strtolower(pathinfo($file->getName(), PATHINFO_EXTENSION)); // Use getName() method
        if (!in_array($fileExtension, $allowedExtensions)) {
            return "Invalid file type. Accepted formats: .png, .jpg, .jpeg, .pdf, .doc, .docx, .xls";
        }

        // Generate a unique filename
        $newName = $file->getRandomName();

        // Move the uploaded file to the specified path
        if ($file->move(ROOTPATH .  $path."/", $newName)) {
            $updatedFileName = $path."/".$newName;
            return $updatedFileName;
        } else {
            echo "Error uploading file.";
            return $defaultResponse;
        }
    }
}