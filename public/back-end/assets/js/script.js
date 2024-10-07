
/*!
    * Start Bootstrap - SB Admin v7.0.7 (https://startbootstrap.com/template/sb-admin)
    * Copyright 2013-2023 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */
//
// Scripts
//

/**
 * Adds functionality to toggle the side navigation menu.
 * Listens for clicks on the element with the ID 'sidebarToggle'.
 * Toggles the 'sb-sidenav-toggled' class on the body element to control visibility.
 * Saves the toggle state to localStorage for persistence (currently commented out).
 */
window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
             document.body.classList.toggle('sb-sidenav-toggled');
        }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});


/**
 * Disables form submissions if there are invalid fields, applying custom Bootstrap validation styles.
 */
(function () {
    'use strict';

    /**
     * Fetches all forms with the class 'needs-validation'.
     * @type {NodeListOf<HTMLFormElement>}
     */
    var forms = document.querySelectorAll('.needs-validation');

    /**
     * Prevents form submission, applies custom Bootstrap validation styles, and stops event propagation.
     * @param {Event} event - The submit event object.
     */
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.classList.add('was-validated');
            }, false);
        });
})();

/**
 * Initializes a DataTable instance for the element with the class "datatable".
 */
$(document).ready(function () {
    $('.datatable').DataTable();
});

/**
 * Configures toastr options for displaying notification messages.
 */
toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "2000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};

/**
 * Copies text to the clipboard using the Clipboard API.
 * Shows success/error messages using toastr.
 * @param {string} text - The text to copy.
 */
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        toastr.success('Copied successfully!', '', {timeOut: 2000});
    }, function(err) {
        toastr.error('Could not copy text', '', {timeOut: 2000});
    });
}

// Event delegation for dynamically added buttons
$(document).on('click', '.btn-copy, .btn-modal-copy', function(e) {
    e.preventDefault();
    const textToCopy = $(this).data('clipboard-text');
    copyToClipboard(textToCopy);
});

//clipboard js
var clipboard = new ClipboardJS('.copy-btn');

$(document).on('click', '.copy-btn, .copy-modal-btn', function(e) {
    e.preventDefault();
    toastr.success('Copied successfully!', '', {timeOut: 2000});
});

$(document).ready(function(){
    $('[data-bs-toggle="tooltip"]').tooltip();
});

/**
 * Sets the 'max_file_size' cookie with a value of 5.
 */
Cookies.set('max_file_size', '5')
// File input validator settings
$(document).ready(function () {
    new FileInputValidator('.file-input', {
        accept: 'all',
        maxSize:  parseInt(Cookies.get('max_file_size'))
    });
});




