// Add event listener to the document when it's fully loaded
document.addEventListener("DOMContentLoaded", function() {
    // Get the delete link element
    const deleteLink = document.querySelector('.danger-link');

    // Add click event listener to the delete link
    deleteLink.addEventListener('click', function(event) {
        // Prevent the default action of the event (in this case, prevent the link from navigating to its href)
        event.preventDefault();

        // Define options for the modal
        var modalOptions = {
            confirmText: 'Yes, Delete',  // Text for the confirm button
            cancelText: 'No, Cancel',  // Text for the cancel button
            onConfirm: function() {  // Function to execute when the confirm button is clicked
                // Navigate to the href of the delete link
                window.location.href = deleteLink.href;
            }
        };

        // Display the modal with a message and the defined options
        displayModal('infoModal', 'Are you sure you want to delete your profile? This action cannot be undone.', modalOptions);
    });
});