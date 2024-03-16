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

