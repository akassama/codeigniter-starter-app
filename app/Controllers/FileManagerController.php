<?php

namespace App\Controllers;
use App\Constants\ActivityTypes;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\FileUploadModel;

class FileManagerController extends BaseController
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
        // Get logged-in user ID
        $loggedInUserId = $this->session->get('user_id');
        $fileUploadsModel = new FileUploadModel();

        // Get file uploads for the logged-in user
        $fileUploads = $fileUploadsModel->where('user_id', $loggedInUserId)->findAll();

        // Get the total count of file uploads
        $totalFileUploads = $fileUploadsModel->countAll();

        // Set data to pass in view
        $data = [
            'file_uploads' => $fileUploads,
            'totalFileUploads' => $totalFileUploads
        ];
        return view('back-end/file-manager/index', $data);
    }

    public function newUpload()
    {
        return view('back-end/file-manager/new-upload');
    }

    public function uploadFile()
    {
        // Get logged-in user ID
        $loggedInUserId = $this->session->get('user_id');
        $uploadDirectory = $this->session->get('upload_directory');
    
        // Load the FileUploadModel
        $fileUploadModel = new FileUploadModel();
    
        // Validation rules from the model
        $validationRules = $fileUploadModel->getValidationRules();
    
        // Validate the incoming data
        if (!$this->validate($validationRules)) {
            // If validation fails, return validation errors
            $data['validation'] = $this->validator;
            return view('back-end/file-manager/new-upload', $data);
        }
    
        $dateToday = date('d-m-Y');
        $savePath = 'public/uploads/file-uploads/' . $uploadDirectory .'/' .$dateToday;
        $file = $this->request->getFile('upload_file');
    
        if ($file->isValid() && !$file->hasMoved()) {

            // Generate a random file name
            $fileName = $file->getRandomName();
    
            // Move the file to the upload directory
            if ($file->move($savePath, $fileName)) {
                $filePath = $savePath . '/' . $fileName;
                $fileSize = $file->getSize();
                $fileType = getFileExtension($fileName);

                // Write 403 Forbidden content to index.html in the upload directory
                $indexFilePath = $savePath.'/index.html';
                $forbiddenHtml = generateForbiddenHtml();
                file_put_contents($indexFilePath, $forbiddenHtml);
    
                // Prepare data for database insertion
                $fileId = getGUID();
                $fileData = [
                    'file_id' => $fileId,
                    'user_id' => $loggedInUserId,
                    'file_name' => $fileName,
                    'file_type' => $fileType,
                    'file_size' => $fileSize,
                    'upload_path' => $filePath,
                ];
    
                // Call saveFile method from the FileUploadModel
                if (addRecord('file_uploads', $fileData)) {
                    // File uploaded and record created successfully
                    $insertedId = $fileId;
                    $successMsg = config('CustomConfig')->createSuccessMsg;
                    session()->setFlashdata('successAlert', $successMsg);

                    // Log activity
                    logActivity($loggedInUserId, ActivityTypes::FILE_UPLOADED, 'File uploaded with id: ' . $insertedId);
    
                    return redirect()->to('/account/file-manager');
                } else {
                    // Failed to create database record
                    $errorMsg = config('CustomConfig')->errorMsg;
                    session()->setFlashdata('errorAlert', $errorMsg);
    
                    // Log activity
                    logActivity($loggedInUserId, ActivityTypes::FAILED_FILE_UPLOAD, 'Failed to save file record in database');
    
                    return redirect()->back()->withInput();
                }
            } else {
                // Failed to move the uploaded file
                $errorMsg = 'Failed to move the uploaded file.';
                session()->setFlashdata('errorAlert', $errorMsg);
    
                return redirect()->back()->withInput();
            }
        } else {
            // Invalid file or file has already been moved
            $errorMsg = 'Invalid file or file has already been moved.';
            session()->setFlashdata('errorAlert', $errorMsg);
    
            return redirect()->back()->withInput();
        }
    }
}
