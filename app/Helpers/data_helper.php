<?php
use App\Models\ActivityLogsModel;
use App\Constants\ActivityTypes;
use App\Models\FileUploadModel;

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
 * Generates a directory name based on a username.
 *
 * @param string $username The username to use.
 * @return string The generated directory name.
 */
if(!function_exists('generateUserDirectory')) {
    function generateUserDirectory($username) {
        $randomString = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789', 5)), 0, 5);

        if (empty($username)) {
            $directoryName = $randomString;
        } else {
            $directoryName = $username . '_' . $randomString;
        }

        return $directoryName;
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
 * Checks if a record exists in the specified table based on a WHERE clause.
 *
 * @param {string} $tableName - The name of the table to search.
 * @param {string} $whereClause - The condition for checking (e.g., 'emp_id = 123').
 * @return {bool} Returns true if a matching record exists, otherwise false.
 */
if (!function_exists('checkRecordExists')) {
    function checkRecordExists(string $tableName, string $primaryKey, string $whereClause): bool
    {
        $db = \Config\Database::connect();

        // Build the query
        $query = $db->table($tableName)
            ->select($primaryKey) // Assuming 'emp_id' is the primary key or unique identifier
            ->where($whereClause)
            ->get();

        // Check if any rows match the condition
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
 * Soft deletes a record in the database by updating the 'deleted' column to 0.
 *
 * @param {string} tableName - The name of the table where the record exists.
 * @param {string} primaryKey - The name of the primary key column.
 * @param {*} primaryKeyValue - The value of the primary key for the record to be deleted.
 * @returns {boolean} - True if the record was successfully soft deleted, false otherwise.
 */
if (!function_exists('softDeleteRecord')) {
    function softDeleteRecord(string $tableName, string $primaryKey, $primaryKeyValue): bool
    {
        $db = \Config\Database::connect();

        // Define the data to be updated
        $data = ['deleted' => 1];

        // Build the query
        $db->table($tableName)
            ->where($primaryKey, $primaryKeyValue)
            ->update($data);

        // Check if the update was successful
        if ($db->affectedRows() > 0) {
            return true; // Return true if successful
        } else {
            return false; // Return false if no rows were affected
        }
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
 * Updates a specific column in a database table based on the provided parameters.
 *
 * @param string $tableName The name of the table to update.
 * @param string $data The column data to be updated in "column = value" format.
 * @param string $whereClause The WHERE condition to specify which record(s) to update.
 * @return bool Returns true if the update was successful, false otherwise.
 */
if (!function_exists('updateRecordColumn')) {
    function updateRecordColumn(string $tableName, string $data, string $whereClause): bool
    {
        $db = \Config\Database::connect();
        
        // Split the data string into column and value
        list($column, $value) = explode('=', $data);
        
        // Trim whitespace and remove any surrounding quotes
        $column = trim($column, " '\"");
        $value = trim($value, " '\"");
        
        // Prepare the data array
        $updateData = [
            $column => $value
        ];
        
        // Perform the update
        $result = $db->table($tableName)
                     ->where($whereClause)
                     ->update($updateData);
        
        // Return true if the update was successful, false otherwise
        return $result;
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
 * Gets the file extension from a given filename.
 *
 * @param string $filename The filename to extract the extension from.
 * @return string The file extension, or an empty string if no extension is found.
 */
if (!function_exists('getFileExtension')) {
    function getFileExtension($filename) {
        // Explode the filename by the dot character.
        $parts = explode('.', $filename);
    
        // If there is at least one part after the dot, return the last part as the extension.
        if (count($parts) > 1) {
            return end($parts);
        }
    
        // If no extension is found, return an empty string.
        return '';
    }
}

/**
 * Converts a file size in bytes to KB, MB, or GB.
 *
 * @param int $sizeInBytes The file size in bytes.
 * @param string $convertTo The desired unit for the converted file size (KB, MB, or GB).
 * @return string The formatted file size with the unit.
 */
if (!function_exists('convertFileSize')) {
    function convertFileSize($sizeInBytes, $convertTo) {
        $units = array('B' => 0, 'KB' => 1024, 'MB' => 1048576, 'GB' => 1073741824);
    
        if (!isset($units[$convertTo])) {
            return 'Invalid conversion unit.';
        }
    
        $convertedSize = $sizeInBytes / $units[$convertTo];
        $formattedSize = number_format($convertedSize, 2);
    
        return $formattedSize . ' ' . $convertTo;
    }
}

/**
 * Converts a file size in bytes to KB, MB, or GB based on the size.
 *
 * @param int $sizeInBytes The file size in bytes.
 * @return string The formatted file size with the unit.
 */
if (!function_exists('displayFileSize')) {
    function displayFileSize($sizeInBytes) {
        $units = array('B', 'KB', 'MB', 'GB');
        $factor = 1024;
    
        for ($i = 0; $i < count($units); $i++) {
            if ($sizeInBytes < $factor) {
                break;
            }
            $sizeInBytes /= $factor;
        }
    
        $formattedSize = number_format($sizeInBytes, 2);
        return $formattedSize . ' ' . $units[$i];
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

        // Validate file types
        $allowedExtensions = getAllowedFileExtensions();

        $fileExtension = strtolower(pathinfo($file->getName(), PATHINFO_EXTENSION)); // Use getName() method
        if (!in_array($fileExtension, $allowedExtensions)) {
            return "Invalid file type (".$fileExtension.")";
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

/**
 * Checks if a file extension is allowed.
 *
 * @param {File} file - The file to check.
 * @returns {boolean} True if the file extension is allowed, false otherwise.
 */
if (!function_exists('isAllowedFileExtension')) {
    function isAllowedFileExtension($file) {
        // Validate file types
        $allowedExtensions = getAllowedFileExtensions();

        $fileExtension = strtolower(pathinfo($file->getName(), PATHINFO_EXTENSION)); // Use getName() method
        if (!in_array($fileExtension, $allowedExtensions)) {
            return false;
        }
        else{
            return true;
        }
    }
}

/**
 * Gets a list of allowed file extensions.
 *
 * @returns {string[]} An array of allowed file extensions.
 */
if (!function_exists('getAllowedFileExtensions')) {
    function getAllowedFileExtensions() {
        // Validate file types
        $allowedExtensions = [
            // Images
            'png', 'jpg', 'jpeg', 'gif', 'webp', 'bmp', 'tiff',

            // Documents
            'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'rtf', 'odt', 'ods', 'odp',

            // Videos
            'mp4', 'mov', 'avi', 'mkv', 'webm', 'flv', 'wmv', 'mpeg', 'mpg',

            // Audio
            'mp3', 'wav', 'ogg', 'flac', 'aac',

            // Archives
            'zip', 'rar', 'tar', 'gz', '7z',

            // Other
            'csv', 'json', 'xml', 'html', 'css'
        ];

        return $allowedExtensions;
    }
}

/**
 * Get the appropriate file input icon based on the file extension.
 *
 * @param {string} $fileExtension - The file extension to check.
 * @return {string} HTML - The HTML string for the corresponding Bootstrap icon.
 *
 * @example
 * // returns '<i class="bi bi-image"></i>'
 * getFileInputIcon('png');
 *
 * @example
 * // returns '<i class="bi bi-filetype-pdf"></i>'
 * getFileInputIcon('pdf');
 *
 * @example
 * // returns '<i class="bi bi-file-earmark"></i>'
 * getFileInputIcon('unknown');
 */
if (!function_exists('getFileInputIcon')) {
    function getFileInputIcon($fileExtension) {
        // Normalize the file extension to lower case
        $fileExtension = strtolower(trim($fileExtension));

        switch ($fileExtension) {
            case 'png':
            case 'jpg':
            case 'jpeg':
            case 'gif':
            case 'webp':
            case 'bmp':
            case 'tiff':
                return '<i class="bi bi-image"></i>';

            case 'pdf':
                return '<i class="bi bi-filetype-pdf"></i>';

            case 'doc':
            case 'docx':
                return '<i class="bi bi-filetype-docx"></i>';

            case 'xls':
            case 'xlsx':
            case 'csv':
                return '<i class="bi bi-filetype-xls"></i>';

            case 'ppt':
            case 'pptx':
                return '<i class="bi bi-filetype-ppt"></i>';

            case 'txt':
            case 'rtf':
            case 'odt':
            case 'ods':
            case 'odp':
                return '<i class="bi bi-file-earmark-text"></i>';

            case 'mp4':
            case 'mov':
            case 'avi':
            case 'mkv':
            case 'webm':
            case 'flv':
            case 'wmv':
            case 'mpeg':
            case 'mpg':
                return '<i class="bi bi-file-play-fill"></i>';

            case 'mp3':
            case 'wav':
            case 'ogg':
            case 'flac':
            case 'aac':
                return '<i class="bi bi-music-note-beamed"></i>';

            case 'zip':
            case 'rar':
            case 'tar':
            case 'gz':
            case '7z':
                return '<i class="bi bi-file-earmark-zip"></i>';

            case 'html':
                return '<i class="bi bi-filetype-html"></i>';

            case 'json':
                return '<i class="bi bi-filetype-json"></i>';

            case 'css':
                return '<i class="bi bi-filetype-css"></i>';

            default:
                return '<i class="bi bi-file-earmark"></i>';
        }
    }
}

/**
 * Generates HTML table rows containing image files for a given user ID.
 *
 * This function fetches image files (e.g., JPG, PNG, GIF) from the database using the
 * FileUploadModel, filters them based on the provided user ID, and returns HTML table rows
 * to display the file information in a structured way.
 *
 * @param int $userId The ID of the user whose image files need to be fetched.
 * @return string HTML string representing the table rows containing image files data.
 */
if (!function_exists('getImageFilesTableData')) {
    function getImageFilesTableData($userId) {
        $fileUploadsModel = new FileUploadModel();

        // Get image files for the user
        $imageFiles = $fileUploadsModel->where('user_id', $userId)
            ->whereIn('file_type', ['jpg', 'jpeg', 'png', 'gif']) // Adjust file types accordingly
            ->findAll();

        $output = '';
        $rowCount = 1;

        if ($imageFiles) {
            foreach ($imageFiles as $file) {
                $output .= "<tr>
                                <td style='width: 5%;'>{$rowCount}</td>
                                <td style='width: 50%;'>
                                    <div class='mb-1'>
                                        <img src='" . base_url($file['upload_path']) . "' class='img-thumbnail' alt='" . esc($file['file_name']) . "' style='height: 125px; width: 125px'> 
                                    </div>
                                    <div class='input-group col-12 mb-3'>
                                        <span class='input-group-text'>" . getFileInputIcon($file['file_type']) . "</span>
                                        <input type='text' class='form-control' id='name-" . esc($file['file_id']) . "' value='" . esc($file['file_name']) . "' readonly disabled>
                                        <button class='btn btn-outline-secondary btn-modal-copy copy-btn-label' type='button' id='button-addon2' data-clipboard-text='" . esc($file['file_name']) . "'>
                                            <i class='bi bi-clipboard-check'></i>
                                        </button>
                                    </div>
                                </td>
                                <td>" . esc($file['file_type']) . "</td>
                                <td>" . displayFileSize($file['file_size']) . "</td>
                                <td>
                                    <div class='row text-center p-1'>
                                        <div class='col mb-1'>
                                            <a class='text-dark mr-1 mb-1 btn-modal-copy copy-path-label' href='javascript:void(0)' data-clipboard-text='" . $file['upload_path'] . "'>
                                                <i class='h5 bi bi-copy'></i>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>";
                $rowCount++;
            }
        }

        return $output;
    }
}

/**
 * Retrieves table data for document files uploaded by the specified user.
 *
 * @param {number} userId - The ID of the user whose files to retrieve.
 * @returns {string} The HTML output for the document files table.
 */
if (!function_exists('getDocumentFilesTableData')) {
    function getDocumentFilesTableData($userId) {
        $fileUploadsModel = new FileUploadModel();

        // Get document files for the user
        $imageFiles = $fileUploadsModel->where('user_id', $userId)
            ->whereIn('file_type', ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'rtf', 'odt', 'ods', 'odp']) // Adjust file types accordingly
            ->findAll();

        $output = '';
        $rowCount = 1;

        if ($imageFiles) {
            foreach ($imageFiles as $file) {
                $output .= "<tr>
                                <td style='width: 5%;'>{$rowCount}</td>
                                <td style='width: 50%;'>
                                    <div class='input-group col-12 mb-3'>
                                        <span class='input-group-text'>" . getFileInputIcon($file['file_type']) . "</span>
                                        <input type='text' class='form-control' id='name-" . esc($file['file_id']) . "' value='" . esc($file['file_name']) . "' readonly disabled>
                                        <button class='btn btn-outline-secondary btn-modal-copy copy-btn-label' type='button' id='button-addon2' data-clipboard-text='" . esc($file['file_name']) . "'>
                                            <i class='bi bi-clipboard-check'></i>
                                        </button>
                                    </div>
                                </td>
                                <td>" . esc($file['file_type']) . "</td>
                                <td>" . displayFileSize($file['file_size']) . "</td>
                                <td>
                                    <div class='row text-center p-1'>
                                        <div class='col mb-1'>
                                            <a class='text-dark mr-1 mb-1 btn-modal-copy copy-path-label' href='javascript:void(0)' data-clipboard-text='" . $file['upload_path'] . "'>
                                                <i class='h5 bi bi-copy'></i>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>";
                $rowCount++;
            }
        }

        return $output;
    }
}

/**
 * Retrieves table data for video files uploaded by the specified user.
 *
 * @param {number} userId - The ID of the user whose files to retrieve.
 * @returns {string} The HTML output for the video files table.
 */
if (!function_exists('getVideoFilesTableData')) {
    function getVideoFilesTableData($userId) {
        $fileUploadsModel = new FileUploadModel();

        // Get document files for the user
        $imageFiles = $fileUploadsModel->where('user_id', $userId)
            ->whereIn('file_type', ['mp4', 'mov', 'avi', 'mkv', 'webm', 'flv', 'wmv', 'mpeg', 'mpg']) // Adjust file types accordingly
            ->findAll();

        $output = '';
        $rowCount = 1;

        if ($imageFiles) {
            foreach ($imageFiles as $file) {
                $output .= "<tr>
                                <td style='width: 5%;'>{$rowCount}</td>
                                <td style='width: 50%;'>
                                    <div class='input-group col-12 mb-3'>
                                        <span class='input-group-text'>" . getFileInputIcon($file['file_type']) . "</span>
                                        <input type='text' class='form-control' id='name-" . esc($file['file_id']) . "' value='" . esc($file['file_name']) . "' readonly disabled>
                                        <button class='btn btn-outline-secondary btn-modal-copy copy-btn-label' type='button' id='button-addon2' data-clipboard-text='" . esc($file['file_name']) . "'>
                                            <i class='bi bi-clipboard-check'></i>
                                        </button>
                                    </div>
                                </td>
                                <td>" . esc($file['file_type']) . "</td>
                                <td>" . displayFileSize($file['file_size']) . "</td>
                                <td>
                                    <div class='row text-center p-1'>
                                        <div class='col mb-1'>
                                            <a class='text-dark mr-1 mb-1 btn-modal-copy copy-path-label' href='javascript:void(0)' data-clipboard-text='" . $file['upload_path'] . "'>
                                                <i class='h5 bi bi-copy'></i>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>";
                $rowCount++;
            }
        }

        return $output;
    }
}

/**
 * Retrieves table data for audio files uploaded by the specified user.
 *
 * @param {number} userId - The ID of the user whose files to retrieve.
 * @returns {string} The HTML output for the audio files table.
 */
if (!function_exists('getAudioFilesTableData')) {
    function getAudioFilesTableData($userId) {
        $fileUploadsModel = new FileUploadModel();

        // Get document files for the user
        $imageFiles = $fileUploadsModel->where('user_id', $userId)
            ->whereIn('file_type', ['mp3', 'wav', 'ogg', 'flac', 'aac']) // Adjust file types accordingly
            ->findAll();

        $output = '';
        $rowCount = 1;

        if ($imageFiles) {
            foreach ($imageFiles as $file) {
                $output .= "<tr>
                                <td style='width: 5%;'>{$rowCount}</td>
                                <td style='width: 50%;'>
                                    <div class='input-group col-12 mb-3'>
                                        <span class='input-group-text'>" . getFileInputIcon($file['file_type']) . "</span>
                                        <input type='text' class='form-control' id='name-" . esc($file['file_id']) . "' value='" . esc($file['file_name']) . "' readonly disabled>
                                        <button class='btn btn-outline-secondary btn-modal-copy copy-btn-label' type='button' id='button-addon2' data-clipboard-text='" . esc($file['file_name']) . "'>
                                            <i class='bi bi-clipboard-check'></i>
                                        </button>
                                    </div>
                                </td>
                                <td>" . esc($file['file_type']) . "</td>
                                <td>" . displayFileSize($file['file_size']) . "</td>
                                <td>
                                    <div class='row text-center p-1'>
                                        <div class='col mb-1'>
                                            <a class='text-dark mr-1 mb-1 btn-modal-copy copy-path-label' href='javascript:void(0)' data-clipboard-text='" . $file['upload_path'] . "'>
                                                <i class='h5 bi bi-copy'></i>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>";
                $rowCount++;
            }
        }

        return $output;
    }
}

/**
 * Retrieves table data for all files uploaded by the specified user.
 *
 * @param {number} userId - The ID of the user whose files to retrieve.
 * @returns {string} The HTML output for the files table.
 */
if (!function_exists('getAllFilesTableData')) {
    function getAllFilesTableData($userId) {
        $fileUploadsModel = new FileUploadModel();

        // Get document files for the user
        $imageFiles = $fileUploadsModel->where('user_id', $userId)->findAll();

        $output = '';
        $rowCount = 1;

        if ($imageFiles) {
            foreach ($imageFiles as $file) {
                $output .= "<tr>
                                <td style='width: 5%;'>{$rowCount}</td>
                                <td style='width: 50%;'>
                                    <div class='input-group col-12 mb-3'>
                                        <span class='input-group-text'>" . getFileInputIcon($file['file_type']) . "</span>
                                        <input type='text' class='form-control' id='name-" . esc($file['file_id']) . "' value='" . esc($file['file_name']) . "' readonly disabled>
                                        <button class='btn btn-outline-secondary btn-modal-copy copy-btn-label' type='button' id='button-addon2' data-clipboard-text='" . esc($file['file_name']) . "'>
                                            <i class='bi bi-clipboard-check'></i>
                                        </button>
                                    </div>
                                </td>
                                <td>" . esc($file['file_type']) . "</td>
                                <td>" . displayFileSize($file['file_size']) . "</td>
                                <td>
                                    <div class='row text-center p-1'>
                                        <div class='col mb-1'>
                                            <a class='text-dark mr-1 mb-1 btn-modal-copy copy-path-label' href='javascript:void(0)' data-clipboard-text='" . $file['upload_path'] . "'>
                                                <i class='h5 bi bi-copy'></i>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>";
                $rowCount++;
            }
        }

        return $output;
    }
}

/**
 * Retrieves table data for archive files uploaded by the specified user.
 *
 * @param {number} userId - The ID of the user whose files to retrieve.
 * @returns {string} The HTML output for the archive files table.
 */
if (!function_exists('getArchivesFilesTableData')) {
    function getArchivesFilesTableData($userId) {
        $fileUploadsModel = new FileUploadModel();

        // Get document files for the user
        $imageFiles = $fileUploadsModel->where('user_id', $userId)
            ->whereIn('file_type', ['zip', 'rar', 'tar', 'gz', '7z']) // Adjust file types accordingly
            ->findAll();

        $output = '';
        $rowCount = 1;

        if ($imageFiles) {
            foreach ($imageFiles as $file) {
                $output .= "<tr>
                                <td style='width: 5%;'>{$rowCount}</td>
                                <td style='width: 50%;'>
                                    <div class='input-group col-12 mb-3'>
                                        <span class='input-group-text'>" . getFileInputIcon($file['file_type']) . "</span>
                                        <input type='text' class='form-control' id='name-" . esc($file['file_id']) . "' value='" . esc($file['file_name']) . "' readonly disabled>
                                        <button class='btn btn-outline-secondary btn-modal-copy copy-btn-label' type='button' id='button-addon2' data-clipboard-text='" . esc($file['file_name']) . "'>
                                            <i class='bi bi-clipboard-check'></i>
                                        </button>
                                    </div>
                                </td>
                                <td>" . esc($file['file_type']) . "</td>
                                <td>" . displayFileSize($file['file_size']) . "</td>
                                <td>
                                    <div class='row text-center p-1'>
                                        <div class='col mb-1'>
                                            <a class='text-dark mr-1 mb-1 btn-modal-copy copy-path-label' href='javascript:void(0)' data-clipboard-text='" . $file['upload_path'] . "'>
                                                <i class='h5 bi bi-copy'></i>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>";
                $rowCount++;
            }
        }

        return $output;
    }
}

/**
 * Generates the HTML content for a "403 Forbidden" message.
 *
 * This function returns HTML that can be used to create an index.html file
 * that displays a "403 Forbidden" message, which prevents directory browsing.
 *
 * @return string The HTML content for a "403 Forbidden" page.
 */
if (!function_exists('generateForbiddenHtml')) {
    function generateForbiddenHtml() {
        $content = "<!DOCTYPE html>
            <html>
            <head>
                <title>403 Forbidden</title>
                <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
            </head>
            <body>
                <h1>403 Forbidden</h1>
                <p>You don't have permission to access this directory.</p>
            </body>
            </html>";

        return $content;
    }
}

/**
 * Extracts the date portion from a datetime string.
 *
 * @param string $datetime The input datetime string (e.g., "2024-10-19 00:00:00").
 * @return string The date in "YYYY-MM-DD" format.
 */
if (!function_exists('getDateOnly')) {
    function getDateOnly(string $datetime, string $format = 'Y-m-d'): string {
        $time = strtotime($datetime);
        $newformat = date($format, $time);
        return $newformat;
    }
}

/**
 * Calculates the age based on a given date.
 *
 * @param {string} datetime - The date string in the format 'YYYY-MM-DD'.
 * @returns {number} - The age calculated in years.
 */
if (!function_exists('calculateAge')) {
    function calculateAge(string $datetime): int
    {
        // Create a DateTime object from the input date string
        $dob = new DateTime($datetime);

        // Get the current date
        $now = new DateTime();

        // Calculate the interval between the two dates
        $interval = $dob->diff($now);

        // Return the difference in years
        return $interval->y;
    }
}

/**
 * Formats a date according to the specified format.
 *
 * @param {string} format - The desired date format (e.g., "d-m-Y", "Y-m-d").
 * @param {string|null} givenDate - The date to be formatted (optional). If not provided, the current time is used.
 * @returns {string} The formatted date.
 */
if(!function_exists('dateFormat'))
{
    function dateFormat($date, $format='d-m-Y') {
        // Check if the provided date is a valid timestamp
        if (strtotime($date) === false) {
            // If not, try to convert it to a timestamp using the default format
            $date = strtotime($date . ' ' . $format);
        }

        // Check if the converted date is a valid timestamp
        if (strtotime($date) === false) {
            // If not, return an empty string or handle the error as needed
            return '';
        }

        // Format the date using the provided format
        return date($format, strtotime($date));
    }
}

/**
 * Retrieves the text name of a country based on its ISO code.
 *
 * @param {string} countryIso - The ISO code of the country.
 * @returns {string} The text name of the country, or "NA" if not found.
 */
//Get country text name
if(!function_exists('getCountryTextName')){
    function getCountryTextName($countryIso){

        if($countryIso != ""){
            $db = \Config\Database::connect();
            //query countries
            $query = $db->table('countries')
                ->select('nicename')
                ->where('iso', $countryIso)
                ->get();

            if ($query->getResult() > 0) {

                try {
                    $row = $query->getRow();
                    $nicename = $row->nicename;
                    return $nicename;
                }
                    //catch exception
                catch(Exception $e) {
                    return "NA";
                }
            }
        }

        return "";
    }
}

/**
 * Logs an activity in the system.
 *
 * @param {string|int} $activityBy - The identifier of the user performing the activity (user ID or email).
 * @param {string} $activityType - The type of activity being performed.
 * @param {string} $activityDetails - Additional details about the activity (optional).
 * @return {bool} Returns true if the activity was successfully logged, false otherwise.
 */
if (!function_exists('logActivity')) {
    function logActivity($activityBy, $activityType, $activityDetails = '')
    {
        $activityLogsModel = new ActivityLogsModel();

        $data = [
            'activity_id' => uniqid(), // Generate a unique ID
            'activity_by' => $activityBy,
            'activity_type' => $activityType,
            'activity' => ActivityTypes::getDescription($activityType) . ($activityDetails ? ': ' . $activityDetails : ''),
            'ip_address' => getIPAddress(),
            'device' => getUserDevice(),
            'created_at' => date('Y-m-d H:i:s')
        ];

        return $activityLogsModel->insert($data);
    }
}

/**
 * Retrieves the full name of the user who performed an activity.
 *
 * @param {string|int} $activityBy - The identifier of the user (user ID or email).
 * @return {string} The full name of the user or "Unknown" if the user cannot be found.
 */
if(!function_exists('getActivityBy'))
{
    function getActivityBy($activityBy)
    {
        if (!empty($activityBy)) {
            $primaryKey = 'user_id';
            //check if using email instead
            if(filter_var($activityBy, FILTER_VALIDATE_EMAIL)) {
                // valid address
                $primaryKey = 'email';
            }

            if (recordExists('users',  $primaryKey, $activityBy)) {
                $whereClause = [$primaryKey => $activityBy]; // Example condition
                $firstName = getTableData('users', $whereClause, 'first_name');
                $lastName = getTableData('users', $whereClause, 'last_name');
                return $firstName.' '.$lastName;
            }
        }
        return "Unknown";
    }
}

/**
 * Retrieves the IP address of the current request.
 *
 * @return {string} The IP address of the current request. Returns '127.0.0.1' for localhost IPv6.
 */
if (!function_exists('getIPAddress')) {
    function getIPAddress(): string
    {
        $request = \Config\Services::request();
        $ip = $request->getIPAddress();

        // Check if the IP is the IPv6 localhost address
        if ($ip === '::1') {
            return '127.0.0.1';
        }

        return $ip;
    }
}

/**
 * Determines the user's device based on the user agent string.
 *
 * @return {string} A string describing the user's device and browser.
 */
if (!function_exists('getUserDevice')) {
    function getUserDevice(): string
    {
        $request = \Config\Services::request();
        $userAgent = $request->getUserAgent();

        if ($userAgent->isMobile()) {
            return $userAgent->getMobile() . ' (Mobile)';
        } elseif ($userAgent->isBrowser()) {
            return $userAgent->getBrowser() . ' on ' . $userAgent->getPlatform();
        } elseif ($userAgent->isRobot()) {
            return $userAgent->getRobot();
        }

        return 'Unknown Device';
    }
}

/**
 * Generates a reset link token for the given email and stores it in the database.
 *
 * @param string $email The email address to generate the reset link for.
 * @return string The generated reset token.
 */
if (!function_exists('generateResetLink')) {
    function generateResetLink($email)
    {
        $db = \Config\Database::connect();

        // Generate a unique token
        $token = bin2hex(random_bytes(32));

        // Set expiration time (30 minutes from now)
        $expiresAt = date('Y-m-d H:i:s', strtotime('+30 minutes'));

        // Insert or update the reset token in the database
        $db->table('password_resets')->replace([
            'reset_id' => getGUID(),
            'email' => $email,
            'token' => $token,
            'expires_at' => $expiresAt
        ]);

        return $token;
    }
}

/**
 * Validates if the provided reset token is still valid and has not expired.
 *
 * @param string $token The reset token to validate.
 * @return bool True if the token is valid, false otherwise.
 */
if (!function_exists('isValidResetToken')) {
    function isValidResetToken($token)
    {
        $db = \Config\Database::connect();

        $reset = $db->table('password_resets')
            ->where('token', $token)
            ->where('expires_at >', date('Y-m-d H:i:s'))
            ->get()
            ->getRowArray();

        return $reset !== null;
    }
}

/**
 * Retrieves the configuration data based on the configuration key.
 *
 * @param string $configKey The key to look up in the configuration table.
 * @param string $settingValue The fallback setting value if the configuration value is not found.
 * @return string The configuration value or the provided fallback setting value.
 */
if (!function_exists('getConfigData')) {
    function getConfigData($configKey, $settingValue): string
    {
        if(!empty($configKey) && !empty($settingValue))
        {
            //get config data for key
            $tableName = 'configurations';
            $whereClause = ['config_for' => $configKey];
            $returnColumn = 'config_value';
            $configValue = getTableData($tableName, $whereClause, $returnColumn);
            if(!empty($configValue)){
                return $configValue;
            }
            return $settingValue;
        }

        return '';
    }
}