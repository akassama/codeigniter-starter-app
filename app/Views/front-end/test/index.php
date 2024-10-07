<!-- include layout -->
<?= $this->extend('front-end/layout/_layout') ?>

<!-- begin main content -->
<?= $this->section('content') ?>

<div class="row mt-3">
    <h1 class="text-center">Test View</h1>
    <hr>
    <div class="col-12">
        <h2>Data Helpers</h2>
        <ul class="list-group">
            <li class="list-group-item">
                <strong class="text-danger">
                    recordExists()
                </strong>
                :
                <span class="text-info">
                    <?php
                        // Sample usage of recordExists function
                        $tableName = 'users';
                        $primaryKey = 'user_id';
                        $primaryKeyValue = 'b9d4c4f33c44f0c3e96a2603e48ac4d6';

                        if (recordExists($tableName, $primaryKey, $primaryKeyValue)) {
                            echo "Record with $primaryKey = $primaryKeyValue exists in $tableName.<br>";
                        } else {
                            echo "Record with $primaryKey = $primaryKeyValue does not exist in $tableName.<br>";
                        }
                    ?>
                </span>
            </li>
            <!-- end list-->
            <li class="list-group-item">
                <strong class="text-danger">
                    deleteRecord()
                </strong>
                :
                <span class="text-info">
                    <?php
                        // Sample usage of deleteRecord function
                        $delPrimaryKey = 'user_id';
                        $delPrimaryKeyValue = '';

                        $isDeleted = deleteRecord($tableName, $delPrimaryKey, $delPrimaryKeyValue);

                        if ($isDeleted) {
                            echo "User with ID $delPrimaryKeyValue was successfully deleted.";
                        } else {
                            echo "User deletion failed.";
                        }
                    ?>
                </span>
            </li>
            <!-- end list-->
            <li class="list-group-item">
                <strong class="text-danger">
                    getAllRecords()
                </strong>
                :
                <span class="text-info">
                    <?php
                        // Sample usage of getAllRecords function
                        $allUsers = getAllRecords($tableName);
                        echo "<pre>";
                        print_r($allUsers);
                        echo "</pre>";
                    ?>
                </span>
            </li>
            <!-- end list-->
            <li class="list-group-item">
                <strong class="text-danger">
                    getSingleRecord()
                </strong>
                :
                <span class="text-info">
                    <?php
                        // Sample usage of getSingleRecord function
                        $singleUser = getSingleRecord($tableName, "user_id = 'b9d4c4f33c44f0c3e96a2603e48ac4d6'");
                        echo "<pre>";
                        print_r($singleUser);
                        echo "</pre>";
                    ?>
                </span>
            </li>
            <!-- end list-->
            <li class="list-group-item">
                <strong class="text-danger">
                    addRecord()
                </strong>
                :
                <span class="text-info">
                    <?php
                        // Sample usage of addRecord function
                        $newUserData = [
                            'user_id' =>  getGUID(),
                            'first_name' => 'John',
                            'last_name' => 'Doe',
                            'username' => 'john.doe',
                            'email' => 'john.doe@example.com',
                            'password' => password_hash('hashed_password', PASSWORD_DEFAULT),
                            'status' => 1,
                            'role' => 'Manager'
                        ];

                        if (!recordExists($tableName, 'email', $newUserData["email"])) {
                            if (addRecord('users', $newUserData)) {
                                echo "New user added successfully.<br>";
                            } else {
                                echo "Failed to add a new user.<br>";
                            }
                        } else {
                            echo "Record with email = ". $newUserData["email"] ." already exist in $tableName.<br>";
                        }
                    ?>
                </span>
            </li>
            <!-- end list-->
            <li class="list-group-item">
                <strong class="text-danger">
                    updateRecord()
                </strong>
                :
                <span class="text-info">
                    <?php
                        // Sample usage of updateRecord function
                        $updatedUserData = [
                            'first_name' => 'Updated Name',
                            'email' => 'updated.email@example.com',
                            'status' => 0
                        ];

                        $updateWhereClause = "user_id = '.$primaryKeyValue.'";

                        if (updateRecord('users', $updatedUserData, $updateWhereClause)) {
                            echo "User updated successfully.<br>";
                        } else {
                            echo "Failed to update the user.<br>";
                        }
                    ?>
                </span>
            </li>
            <!-- end list-->
            <li class="list-group-item">
                <strong class="text-danger">
                updateRecordColumn()
                </strong>
                :
                <span class="text-info">
                    <?php
                        // Sample usage of updateRecordColumn function
                        $updateColumn =  "'first_name' = 'Updated Name'";
                        $updateWhereClause = "user_id = '$primaryKeyValue'";
                        $result = updateRecordColumn("users", $updateColumn, $updateWhereClause );

                        if ($result) {
                            echo "User updated successfully.<br>";
                        } else {
                            echo "Failed to update the user.<br>";
                        }
                    ?>
                </span>
            </li>
            <!-- end list-->
            <li class="list-group-item">
                <strong class="text-danger">
                    getTotalRecords()
                </strong>
                :
                <span class="text-info">
                    <?php
                        // Sample usage of getTotalRecords function
                        $totalUsers = getTotalRecords('users');
                        echo "Total number of users: $totalUsers<br>";
                    ?>
                </span>
            </li>
            <!-- end list-->
            <li class="list-group-item">
                <strong class="text-danger">
                    getPaginatedRecords()
                </strong>
                :
                <span class="text-info">
                    <?php
                        // Sample usage of getPaginatedRecords function
                        $take = 10;
                        $skip = 0;
                        $paginatedWhereClause = "user_id IS NOT NULL";
                        $users = getPaginatedRecords('users', $take, $skip, $paginatedWhereClause);

                        foreach ($users as $user) {
                            echo "<p>User ID: {$user['user_id']}, Name: {$user['first_name']}</p>";
                            // Add other relevant fields as needed
                        }
                    ?>
                </span>
            </li>
            <!-- end list-->
            <li class="list-group-item">
                <strong class="text-danger">
                    executeCustomQuery()
                </strong>
                :
                <span class="text-info">
                    <?php
                        // Sample usage of executeCustomQuery function
                        $sql = 'SELECT COUNT(*) as total FROM users WHERE status = "1"';
                        $result = executeCustomQuery($sql);
                        $totalCount = $result[0]->total;

                        echo "Total active users: $totalCount\n";
                    ?>
                </span>
            </li>
            <!-- end list-->
            <li class="list-group-item">
                <strong class="text-danger">
                    truncateTable()
                </strong>
                :
                <span class="text-info">
                    <?php
                        // Sample usage of truncateTable function
                        $truncateResult = truncateTable('error_logs');

                        if ($truncateResult) {
                            echo 'Error logs truncated successfully.';
                        } else {
                            echo 'Error logs truncation failed.';
                        }
                    ?>
                </span>
            </li>
            <!-- end list-->
            <li class="list-group-item">
                <strong class="text-danger">
                    getTableData()
                </strong>
                :
                <span class="text-info">
                    <?php
                        // Sample usage of getTableData function
                        $tableName = 'users';
                        $userEmail = "admin@example.com";
                        $whereClause = ['email' => $userEmail]; // Example condition
                        $returnColumn = 'role'; // Specify the column you want to retrieve
                        $tableData = getTableData($tableName, $whereClause, $returnColumn);
                        print_r(empty($tableData) ? "NULL" : $tableData);
                    ?>
                </span>
            </li>
            <!-- end list-->
            <li class="list-group-item">
                <strong class="text-danger">
                    getUserRole()
                </strong>
                :
                <span class="text-info">
                    <?php
                        // Sample usage of getUserRole function
                        $userEmail = "admin@example.com";
                        $userRole = getUserRole($userEmail);
                        print_r(empty($userRole) ? "NULL" : $userRole);
                    ?>
                </span>
            </li>
            <!-- end list-->
            <li class="list-group-item">
                <strong class="text-danger">
                    userHasRole()
                </strong>
                :
                <span class="text-info">
                    <?php
                        // Sample usage of userHasRole function
                        $userEmail = "admin@example.com";
                        $hasRole = userHasRole($userEmail, "Admin");
                        var_dump($hasRole);
                    ?>
                </span>
            </li>
            <!-- end list-->
            <li class="list-group-item">
                <strong class="text-danger">
                    getUserDevice()
                </strong>
                :
                <span class="text-info">
                    <?php
                    // Sample usage of getUserDevice function
                    var_dump(getUserDevice());
                    ?>
                </span>
            </li>
            <!-- end list-->
            <li class="list-group-item">
                <strong class="text-danger">
                    getIPAddress()
                </strong>
                :
                <span class="text-info">
                    <?php
                    // Sample usage of getIPAddress function
                    var_dump(getIPAddress());
                    ?>
                </span>
            </li>
            <!-- end list-->
            <li class="list-group-item">
                <strong class="text-danger">
                    Send Email (HTML)
                </strong>
                :
                <span class="text-info">
                    <a href="<?= base_url('/test/send-email'); ?>" target="_blank">
                        Link
                    </a>
                </span>
            </li>
            <!-- end list-->
            <?php $validation = \Config\Services::validation(); ?>
            <?= form_open_multipart('test/upload', ['class' => 'needs-validation', 'novalidate' => '']) ?>
            <div class="col-sm-12 col-md-6 mb-3">
                <label for="upload_file" class="form-label">Choose File</label>
                <input type="file" class="form-control" id="upload_file" name="upload_file" accept=".doc, .docx, .pdf, .txt, .jpg, .jpeg, .png, .gif, .mp4" required>
                <!-- Error -->
                <?php if($validation->getError('upload_file')) {?>
                    <div class='text-danger mt-2'>
                        <?= $error = $validation->getError('upload_file'); ?>
                    </div>
                <?php }?>
                <div class="invalid-feedback">
                    Please provide file
                </div>
            </div>
            <div class="mb-3">
                <small class="text-muted">
                    Allowed file types: .doc, .docx, .pdf, .txt, .jpg, .jpeg, .png, .gif, .mp4<br>
                    Maximum file size: 5MB
                </small>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
            <?= form_close() ?>
        </ul>
    </div>
</div>

<!-- end main content -->
<?= $this->endSection() ?>
