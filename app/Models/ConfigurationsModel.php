<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * ConfigurationsModel class
 *
 * Represents the model for the configurations table in the database.
 */
class ConfigurationsModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        helper('data'); // Load the helper here
    }

    protected $table            = 'configurations';
    protected $primaryKey       = 'config_id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['config_id', 'config_for', 'config_value', 'deletable'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'config_for' => 'required|is_unique[configurations.config_for]',
        'config_value' => 'required',
    ];
    protected $validationMessages   = [
        'config_for' => 'config_for is required',
        'config_value' => 'config_value is required',
    ];
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

    public function createConfiguration($param = array())
    {
        $data = [
            'config_id' => getGUID(),
            'config_for' => $param['config_for'],
            'config_value' => $param['config_value']
        ];
        $this->save($data);

        return true;
    }

    public function updateConfiguration($configurationId, $param = [])
    {
        // Check if contact exists
        $existingConfiguration = $this->find($configurationId);
        if (!$existingConfiguration) {
            return false; // Configuration not found
        }

        // Update the fields
        $existingConfiguration['config_for'] = $param['config_for'];
        $existingConfiguration['config_value'] = $param['config_value'];

        // Save the updated data
        $this->save($existingConfiguration);

        return true;
    }
}