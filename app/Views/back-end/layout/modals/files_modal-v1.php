<?php
$session = session();
// Get session data
$sessionUserId = $session->get('user_id');

// Load the FileUploadModel
$fileUploadsModel = new \App\Models\FileUploadModel();

// Get image files for the user
$imageFiles = $fileUploadsModel->where('user_id', $sessionUserId)
    ->whereIn('file_type', ['jpg', 'jpeg', 'png', 'gif']) // Adjust file types accordingly
    ->findAll();
?>

<!-- Image Files Modal -->
<div class="modal fade" id="imageFilesModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Image Files</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered datatable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>File</th>
                            <th>Type</th>
                            <th>Size</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($imageFiles)): ?>
                            <?php foreach ($imageFiles as $index => $file): ?>
                                <tr>
                                    <td style='width: 5%;'><?= $index + 1 ?></td>
                                    <td style='width: 50%;'>
                                        <div class='mb-1'>
                                            <img src='<?= base_url($file['upload_path']) ?>' class='img-thumbnail' alt='<?= esc($file['file_name']) ?>' style='height: 125px; width: 125px'>
                                        </div>
                                        <div class='input-group col-12 mb-3'>
                                            <input type='text' class='form-control' id='name-<?= esc($file['file_id']) ?>' value='<?= esc($file['file_name']) ?>' readonly disabled>
                                            <button class='btn btn-outline-secondary copy-modal-btn' type='button' data-clipboard-text='<?= esc($file['file_name']) ?>'>
                                                <i class='bi bi-clipboard-check'></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td><?= esc($file['file_type']) ?></td>
                                    <td><?= esc($file['file_size']) ?></td>
                                    <td>
                                        <div class='row text-center p-1'>
                                            <div class='col mb-1'>
                                                <a class='text-dark mr-1 mb-1 copy-modal-btn' href='javascript:void(0)' data-clipboard-text='<?= base_url($file['upload_path']) ?>'>
                                                    <i class='h5 bi bi-copy'></i>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan='5'>No image files found.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    /**
     * Copies the specified text to the user's clipboard.
     *
     * @param {string} text - The text to copy to the clipboard.
     */
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text)
            .then(() => {
                console.log('Copying to clipboard was successful!');
                // You can add UI feedback here
            })
            .catch(err => {
                console.error('Could not copy text: ', err);
            });
    }

    document.querySelectorAll('.copy-modal-btn').forEach(button => {
        button.addEventListener('click', () => {
            const textToCopy = button.getAttribute('data-clipboard-text');
            copyToClipboard(textToCopy);
        });
    });
</script>