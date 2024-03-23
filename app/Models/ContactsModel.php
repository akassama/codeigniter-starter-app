<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactsModel extends Model
{
    protected $table            = 'contacts';
    protected $primaryKey       = 'contact_id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['contact_id', 'contact_name', 'contact_picture', 'contact_email', 'contact_number', 'contact_address'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'contact_name' => 'required|max_length[50]|min_length[2]',
        'contact_email' => 'required|max_length[50]|min_length[3]|valid_email',
        'contact_number' => 'required|max_length[20]|min_length[6]|is_unique[contacts.contact_number]',
        'contact_address' => 'required|max_length[255]|min_length[2]',
    ];
    protected $validationMessages   = [
        'contact_name' => 'Contact name is required',
        'contact_email' => 'Contact email is required',
        'contact_number' => 'Contact number name is required',
        'contact_address' => 'Username is required',
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

    public function createContact($param = array())
    {
        // Generate a unique ID (UUID)
        $contactId = bin2hex(random_bytes(16)); // Generates a 32-character hexadecimal ID
        $defaultPicture = 'public/uploads/contacts/default/default-profile.png';
        $data = [
            'contact_id' => $contactId,
            'contact_name' => $param['contact_name'],
            'contact_picture' => empty($param['contact_picture']) ? $defaultPicture : $param['contact_picture'],
            'contact_email' => $param['contact_email'],
            'contact_number' => $param['contact_number'],
            'contact_address' => $param['contact_address']
        ];
        $this->save($data);

        return true;
    }

    public function updateContact($contactId, $param = [])
    {
        // Check if contact exists
        $existingContact = $this->find($contactId);
        if (!$existingContact) {
            return false; // Contact not found
        }

        // Update the fields
        $defaultPicture = 'profiles/default-profile.png';
        $existingContact['contact_name'] = $param['contact_name'];
        $existingContact['contact_picture'] = empty($param['contact_picture']) ? $defaultPicture : $param['contact_picture'];
        $existingContact['contact_email'] = $param['contact_email'];
        $existingContact['contact_number'] = $param['contact_number'];
        $existingContact['contact_address'] = $param['contact_address'];

        // Save the updated data
        $this->save($existingContact);

        return true;
    }
}
