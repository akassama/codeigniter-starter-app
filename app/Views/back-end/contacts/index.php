<!-- include layout -->
<?= $this->extend('back-end/layout/_layout') ?>

<!-- begin main content -->
<?= $this->section('content') ?>

<?php
// Breadcrumbs
$breadcrumb_links = array(
    array('title' => 'Dashboard', 'url' => '/account'),
    array('title' => 'Contacts')
);
echo generateBreadcrumb($breadcrumb_links);
?>

<div class="row">
    <!--Content-->
    <div class="col-12">
        <h3>Manage Contacts</h3>
    </div>
    <div class="col-12 d-flex justify-content-end mb-2">
        <a href="<?=base_url('/account/contacts/new-contact')?>" class="btn btn-outline-dark mx-1">
            <i class="bi bi-plus"></i> New Contact
        </a>
    </div>
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-table me-1"></i>
                Contacts
                <span class="badge rounded-pill bg-dark">
                    <?= $totalContacts ?>
                </span>
            </div>
            <div class="card-body">
                <table class="table table-bordered datatable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Picture</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $rowCount = 1; ?>
                    <?php if($contacts): ?>
                        <?php foreach($contacts as $contact): ?>
                            <tr>
                                <td><?= $rowCount; ?></td>
                                <td>
                                    <img src="<?= base_url($contact['contact_picture']); ?>" class="rounded" alt="<?= $contact['contact_name']; ?>" width="50" height="50">
                                </td>
                                <td><?= $contact['contact_name']; ?></td>
                                <td><?= $contact['contact_email']; ?></td>
                                <td><?= $contact['contact_number']; ?></td>
                                <td><?= $contact['contact_address']; ?></td>
                                <td>
                                    <div class="row text-center p-1">
                                        <div class="col mb-1">
                                            <a class="text-dark mr-1 mb-1" href="<?=base_url('account/contacts/view-contact/'.$contact['contact_id'])?>" data-bs-toggle="tooltip" data-bs-placement="top" title="View contact">
                                                <i class="h5 bi bi-eye-fill"></i>
                                            </a>
                                        </div>
                                        <div class="col mb-1">
                                            <a class="text-dark mr-1 mb-1" href="<?=base_url('account/contacts/edit-contact/'.$contact['contact_id'])?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit contact">
                                                <i class="h5 bi bi-pencil-square"></i>
                                            </a>
                                        </div>
                                        <div class="col mb-1">
                                            <a class="text-dark mr-1 delete-record" href="#!" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove contact" onclick="deleteRecord('contacts', 'contact_id', '<?=$contact['contact_id'];?>', '', 'account/contacts')">
                                                <i class="h5 bi bi-trash-fill"></i>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php $rowCount++; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function deleteRecord(tableName, pkName, pkValue, childTables, returnUrl) {
        Swal.fire({
            title: 'Are you sure you want to remove this record?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                // Create the form element
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `<?= base_url('/services/remove-record') ?>`;

                // Add hidden input fields
                const tableNameInput = document.createElement('input');
                tableNameInput.type = 'hidden';
                tableNameInput.name = 'table_name';
                tableNameInput.value = tableName;
                form.appendChild(tableNameInput);

                const pkNameInput = document.createElement('input');
                pkNameInput.type = 'hidden';
                pkNameInput.name = 'pk_name';
                pkNameInput.value = pkName;
                form.appendChild(pkNameInput);

                const pkValueInput = document.createElement('input');
                pkValueInput.type = 'hidden';
                pkValueInput.name = 'pk_value';
                pkValueInput.value = pkValue;
                form.appendChild(pkValueInput);

                const childTablesInput = document.createElement('input');
                childTablesInput.type = 'hidden';
                childTablesInput.name = 'child_tables';
                childTablesInput.value = childTables;
                form.appendChild(childTablesInput);

                const returnUrlInput = document.createElement('input');
                returnUrlInput.type = 'hidden';
                returnUrlInput.name = 'return_url';
                returnUrlInput.value = returnUrl;
                form.appendChild(returnUrlInput);

                // Append the form to the body and submit it
                document.body.appendChild(form);
                form.submit();

                // Remove the form from the body after submit (optional)
                document.body.removeChild(form);
            }
        });
    }
</script>

<!-- end main content -->
<?= $this->endSection() ?>
