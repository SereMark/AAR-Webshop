document.addEventListener("DOMContentLoaded", function() {
    const deleteAllBtn = document.getElementById('delete-all-btn');
    const deleteAllForm = document.getElementById('delete-all-products-form');

    deleteAllBtn.addEventListener('click', function(event) {
        var modalOptions = {
            confirmText: 'Yes, Delete',
            cancelText: 'No, Cancel',
            onConfirm: function() {
                deleteAllForm.submit();
            }
        };

        displayModal('infoModal', 'Are you sure you want to delete all of your products?', modalOptions);
    });
});