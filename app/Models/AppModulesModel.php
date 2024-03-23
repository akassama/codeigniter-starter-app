<?php

namespace App\Models;

use CodeIgniter\Model;

class AppModulesModel extends Model
{
    protected $table            = 'app_modules';
    protected $primaryKey       = 'app_module_id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['app_module_id', 'module_name', 'module_description', 'module_roles', 'module_link'];

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

    public function searchModules($searchQuery, $role = "User")
    {
        return $this->like('module_name', $searchQuery)
            ->orWhere('module_description', $searchQuery)
            ->orWhere('module_link', $searchQuery)
            ->groupStart()
            ->like('module_roles', $role)
            ->groupEnd()
            ->findAll();
    }
}
