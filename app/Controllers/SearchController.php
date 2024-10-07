<?php

namespace App\Controllers;

use App\Constants\ActivityTypes;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AppModulesModel;

class SearchController extends BaseController
{
    protected $helpers = ['auth_helper'];
    public function searchModulesResult()
    {
        $session = session();
        $searchQuery = $this->request->getGet('q');

        // Validate the search query (e.g., check minimum length)

        // Load the model
        $appModulesModel = new AppModulesModel();
        $data["searchQuery"] = $searchQuery;
        $userEmail = $session->get('email');
        $role = getUserRole($userEmail);
        $data['searchResults'] = $appModulesModel->searchModules($searchQuery, $role);

        //log activity
        logActivity($userEmail, ActivityTypes::MODULE_SEARCH, 'User with email: ' . $userEmail . ' made a search for: ' . $searchQuery );

        // Load the view to display search results
        return view('back-end/admin/search/search-results', $data);
    }

    public function searchResults()
    {
        return null;
    }
}
