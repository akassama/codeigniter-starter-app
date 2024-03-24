<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ServicesController extends BaseController
{
    protected $helpers = ['auth_helper', 'form'];

    public function deleteService()
    {
        $tableName = $this->request->getPost('table_name');
        $pkName = $this->request->getPost('pk_name');
        $pkValue = $this->request->getPost('pk_value');
        $childTables = $this->request->getPost('child_table');
        $returnUrl = $this->request->getPost('return_url');

        try {

            //remove record
            deleteRecord($tableName, $pkName, $pkValue);

            // Check if $childTables is not empty
            if (!empty($childTables)) {
                // Split the comma-separated strings into an array
                $tablesArray = explode(',', $childTables);

                // Iterate over each table and delete records
                foreach ($tablesArray as $table) {
                    deleteRecord($table, $pkName, $pkValue);
                }
            }

            $createSuccessMsg = config('CustomConfig')->deleteSuccessMsg;
            session()->setFlashdata('successAlert', $createSuccessMsg);

            //return
            return redirect()->to($returnUrl);
        }
        catch (Exception $e){
            $errorMsg = config('CustomConfig')->exceptionMsg;
            session()->setFlashdata('errorAlert', $errorMsg);
            return redirect()->to($returnUrl);
        }
    }

    public function deleteServiceWithCode()
    {
        $tableName = $this->request->getPost('table_name');
        $pkName = $this->request->getPost('pk_name');
        $pkValue = $this->request->getPost('pk_value');
        $childTables = $this->request->getPost('child_table');
        $returnUrl = $this->request->getPost('return_url');

        try {
            // Remove the main record
            deleteRecord($tableName, $pkName, $pkValue);

            // Check if $childTables is not empty
            if (!empty($childTables)) {
                // Split the comma-separated strings into an array
                $tablesArray = explode(',', $childTables);

                // Iterate over each table and delete records
                foreach ($tablesArray as $table) {
                    deleteRecord($table, $pkName, $pkValue);
                }
            }

            // Return a successful response (HTTP 200 OK)
            http_response_code(200);
            echo json_encode(['success' => true, 'message' => 'Record(s) successfully removed.']);
        } catch (Exception $e) {
            // Return an error response (HTTP 500 Internal Server Error)
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'An error occurred while removing the record(s).']);
        }
    }

}
