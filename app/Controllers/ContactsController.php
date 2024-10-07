<?php

namespace App\Controllers;

use App\Constants\ActivityTypes;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ContactsModel;

class ContactsController extends BaseController
{
    protected $helpers = ['auth_helper'];
    protected $session;
    public function __construct()
    {
        // Initialize session once in the constructor
        $this->session = session();
    }

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
        //get logged-in user id
        $loggedInUserId = $this->session->get('user_id');

        // Load the ContactsModel
        $contactsModel = new ContactsModel();

        // Validate the input
        $rules = $contactsModel->getValidationRules();
        if (!$this->validate($rules)) {
            return view('back-end/contacts/new-contact', ['validation' => $this->validator]);
        }

        // Prepare data for insertion
        $data = [
            'contact_name' => $this->request->getPost('contact_name'),
            'contact_picture' => $this->request->getPost('contact_picture'),
            'contact_document' => $this->request->getPost('contact_document'),
            'contact_audio' => $this->request->getPost('contact_audio'),
            'contact_video' => $this->request->getPost('contact_video'),
            'other_document' => $this->request->getPost('other_document'),
            'contact_email' => $this->request->getPost('contact_email'),
            'contact_number' => $this->request->getPost('contact_number'),
            'contact_address' => $this->request->getPost('contact_address')
        ];

        // Attempt to create the contact
        if ($contactsModel->createContact($data)) {
            $insertedId = $contactsModel->getInsertID();

            // Record created successfully. Redirect to dashboard
            $createSuccessMsg = config('CustomConfig')->createSuccessMsg;
            session()->setFlashdata('successAlert', $createSuccessMsg);

            //log activity
            logActivity($loggedInUserId, ActivityTypes::CONTACT_CREATION, 'Contact created with id: ' . $insertedId);

            return redirect()->to('/account/contacts');
        } else {
            // Failed to create record. Redirect to dashboard
            $errorMsg = config('CustomConfig')->errorMsg;
            session()->setFlashdata('errorAlert', $errorMsg);

            //log activity
            logActivity($loggedInUserId, ActivityTypes::FAILED_USER_CREATION, 'Failed to create contact with email: ' . $this->request->getPost('contact_email'));

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
        //get logged-in user id
        $loggedInUserId = $this->session->get('user_id');

        $contactsModel = new ContactsModel();

        // Validate the input
        $rules = $contactsModel->getValidationRules();
        // Remove the 'is_unique' rule for contact_number as it's an update
        $rules['contact_number'] = str_replace('|is_unique[contacts.contact_number]', '', $rules['contact_number']);

        if (!$this->validate($rules)) {
            $data['validation'] = $this->validator;
            $errorMsg = config('CustomConfig')->missingRequiredInputsMsg;
            session()->setFlashdata('errorAlert', $errorMsg);

            return view('back-end/contacts/edit-contact', $data);
        }

        $contactId = $this->request->getPost('contact_id');

        // Prepare data for update
        $data = [
            'contact_name' => $this->request->getPost('contact_name'),
            'contact_picture' => $this->request->getPost('contact_picture'),
            'contact_document' => $this->request->getPost('contact_document'),
            'contact_audio' => $this->request->getPost('contact_audio'),
            'contact_video' => $this->request->getPost('contact_video'),
            'other_document' => $this->request->getPost('other_document'),
            'contact_email' => $this->request->getPost('contact_email'),
            'contact_number' => $this->request->getPost('contact_number'),
            'contact_address' => $this->request->getPost('contact_address')
        ];

        // Attempt to update the contact
        if ($contactsModel->updateContactWithQuery($contactId, $data)) {

            // Success message and redirect
            $updateSuccessMsg = config('CustomConfig')->editSuccessMsg;
            session()->setFlashdata('successAlert', $updateSuccessMsg);

            //log activity
            logActivity($loggedInUserId, ActivityTypes::CONTACT_UPDATE, 'Contact updated with id: ' . $contactId);

            return redirect()->to('/account/contacts');
        } else {
            $errorMsg = config('CustomConfig')->errorMsg;
            session()->setFlashdata('errorAlert', $errorMsg);

            //log activity
            logActivity($loggedInUserId, ActivityTypes::FAILED_CONTACT_UPDATE, 'Failed to update contact with id: ' . $contactId);

            return redirect()->to('/account/contacts/edit-contact/' . $contactId);
        }
    }

}
