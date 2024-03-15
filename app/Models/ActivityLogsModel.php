<?php

namespace App\Models;

use CodeIgniter\Model;

class ActivityLogsModel extends Model
{
    protected $table            = 'activity_logs';
    protected $primaryKey       = 'activity_id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['activity_id','activity_by','activity_type','activity'];

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

    public function logActivity($param = array())
    {
        // Generate a unique ID (UUID)
        $activityId = bin2hex(random_bytes(16)); // Generates a 32-character hexadecimal ID
        $data = [
            'activity_id' => $activityId,
            'activity_type' => $param['activity_type'],
            'activity' => $param['activity'],
            'activity_by' => $param['activity_by']
        ];
        $this->save($data);

        return true;
    }
}
