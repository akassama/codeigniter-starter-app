<?php

namespace App\Models;

use CodeIgniter\Model;

class ErrorLogsModel extends Model
{
    protected $table            = 'errorlogs';
    protected $primaryKey       = 'error_log_id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['error_log_id', 'user', 'severity', 'error_message'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function logError($param = array())
    {
        // Generate a unique ID (UUID)
        $errorLogId = bin2hex(random_bytes(16)); // Generates a 32-character hexadecimal ID
        $data = [
            'error_log_id' => $errorLogId,
            'user' => $param['user'],
            'severity' => $param['severity'],
            'error_message' => $param['error_message']
        ];
        $this->save($data);

        return true;
    }
}
