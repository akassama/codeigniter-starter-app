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
        $contactsModel = new ContactsModel();

        // Set data to pass in view
        $data = [
            'contacts' => $contactsModel->orderBy('contact_name', 'ASC')->findAll(),
            'totalContacts' => getTotalRecords($tableName)
        ];

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
        $contactPicture = "";
        $defaultResponse = "public/uploads/contacts/default/default-profile.png";
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
            $contactPicture = uploadFile($uploadedFile, $savePath, $defaultResponse);
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
            // Record created successfully. Redirect to dashboard
            $createSuccessMsg = config('CustomConfig')->createSuccessMsg;
            session()->setFlashdata('successAlert', $createSuccessMsg);
            return redirect()->to('/account/contacts');

        } else {
            // Failed to create record. Redirect to dashboard
            $errorMsg = config('CustomConfig')->errorMsg;
            session()->setFlashdata('errorAlert', $errorMsg);
            return view('back-end/contacts/new-contact');
        }
    }

    public function viewContact($contactId)
    {
        $contactsModel = new ContactsModel();

        // Fetch the data based on the id
        $contact = $contactsModel->where('contact_id', $contactId)->first();

        // Set data to pass in view
        $data = [
            'contact_data' => $contact
        ];

        return view('back-end/contacts/view-contact', $data);
    }

    public function editContact($contactId)
    {
        $contactsModel = new ContactsModel();

        // Fetch the data based on the id
        $contact = $contactsModel->where('contact_id', $contactId)->first();

        // Set data to pass in view
        $data = [
            'contact_data' => $contact
        ];

        return view('back-end/contacts/edit-contact', $data);
    }


    public function updateContact()
    {
        $contactsModel = new ContactsModel();

        // Custom validation rules
        $rules = [
            'contact_id' => 'required',
            'contact_name' => 'required|max_length[50]|min_length[2]',
            'contact_email' => 'required|max_length[50]|min_length[3]|valid_email',
            'contact_number' => 'required|max_length[20]|min_length[6]',
            'contact_address' => 'required|max_length[255]|min_length[2]',
        ];

        $contactId = $this->request->getVar('contact_id');
        $contactPicture = $this->request->getVar('current_contact_picture');
        $defaultResponse = "public/uploads/contacts/default/default-profile.png";
        $data['contact_data'] = $contactsModel->where('contact_id', $contactId)->first();

        if($this->validate($rules)){

            if($this->request->getFile('contact_picture')->isValid()){

                //check if valid file type
                if(!isValidImage($this->request->getFile('contact_picture'))){
                    $errorMsg = "Invalid file type";
                    session()->setFlashdata('errorAlert', $errorMsg);
                    return redirect()->to('/account/contacts/edit-contact/'.$contactId);
                };

                //check if valid file size
                if(getFileSize($this->request->getFile('contact_picture'), "MB") > 2){
                    $errorMsg = "File size greater than max allowed size ('2MB')";
                    session()->setFlashdata('errorAlert', $errorMsg);
                    return redirect()->to('/account/contacts/edit-contact/'.$contactId);
                };

                $uploadedFile = $this->request->getFile('contact_picture');
                $savePath = 'public/uploads/contacts'; // desired save path
                // Call the uploadFile() function
                $contactPicture = uploadFile($uploadedFile, $savePath, $defaultResponse);
            }

            $contactsModel->set('contact_name', $this->request->getVar('contact_name'));
            $contactsModel->set('contact_email', $this->request->getVar('contact_email'));
            $contactsModel->set('contact_number', $this->request->getVar('contact_number'));
            $contactsModel->set('contact_address', $this->request->getVar('contact_address'));
            $contactsModel->set('contact_picture', $contactPicture);
            //update via id
            $contactsModel->where('contact_id', $contactId);
            $contactsModel->update();

            // Record updated successfully. Redirect to dashboard
            $createSuccessMsg = config('CustomConfig')->editSuccessMsg;
            session()->setFlashdata('successAlert', $createSuccessMsg);
            return redirect()->to('/account/contacts');
        }
        else{
            $data['validation'] = $this->validator;
            $errorMsg = config('CustomConfig')->missingRequiredInputsMsg;
            session()->setFlashdata('errorAlert', $errorMsg);
            return view('back-end/contacts/edit-contact', $data);
        }

    }


}
