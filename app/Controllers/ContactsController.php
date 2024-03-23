<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ContactsModel;


class ContactsController extends BaseController
{
    protected $helpers = ['auth_helper'];
    public function index()
    {
        $tableName = 'contacts';
        $data['contacts'] = getAllRecords($tableName);
        $data['totalContacts'] = getTotalRecords($tableName);
        return view('back-end/contacts/index', $data);
    }

    public function newContact()
    {
        return view('back-end/contacts/new-contact');
    }


    public function addContact()
    {
        // Load the ContactsModel
        $contactsModel = new ContactsModel();

        // Validation rules from the model
        $validationRules = $contactsModel->getValidationRules();

        // Validate the incoming data
        if (!$this->validate($validationRules)) {
            // If validation fails, return validation errors
            $data['validation'] = $this->validator;
            return view('back-end/contacts/new-contact');
        }

        //check if file uploaded
        $contactPicture = "public/uploads/contacts/default/default-profile.png";
        if($this->request->getFile('contact_picture')->isValid()){

            //check if valid file type
            if(!isValidImage($this->request->getFile('contact_picture'))){
                $errorMsg = "Invalid file type";
                session()->setFlashdata('errorAlert', $errorMsg);
                return view('back-end/contacts/new-contact');
            };

            //check if valid file size
            if(getFileSize($this->request->getFile('contact_picture'), "MB") > 2){
                $errorMsg = "File size greater than max allowed size ('2MB')";
                session()->setFlashdata('errorAlert', $errorMsg);
                return view('back-end/contacts/new-contact');
            };

            $uploadedFile = $this->request->getFile('contact_picture');
            $savePath = 'public/uploads/contacts'; // desired save path
            // Call the uploadFile() function
            $contactPicture = $uploadedFilePath = uploadFile($uploadedFile, $savePath, "File upload failed.");
        }

        // If validation passes, create the user
        $contactData = [
            'contact_name' => $this->request->getPost('contact_name'),
            'contact_picture' => $contactPicture,
            'contact_email' => $this->request->getPost('contact_email'),
            'contact_number' => $this->request->getPost('contact_number'),
            'contact_address' => $this->request->getPost('contact_address'),
        ];


        // Call createContact method from the ContactsModel
        if ($contactsModel->createContact($contactData)) {
            // Contact created successfully. Redirect to dashboard
            $createSuccessMsg = config('CustomConfig')->createSuccessMsg;
            session()->setFlashdata('successAlert', $createSuccessMsg);
            return redirect()->to('/account/contacts');

        } else {
            // Failed to create user. Redirect to dashboard
            $errorMsg = config('CustomConfig')->errorMsg;
            session()->setFlashdata('errorAlert', $errorMsg);
            return view('back-end/contacts/new-contact');
        }
    }

}
