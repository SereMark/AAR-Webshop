// Add event listener to the document when it's fully loaded
document.addEventListener("DOMContentLoaded", function() {
    // Get the delete link element
    const deleteLink = document.querySelector('.danger-link');

    // Add click event listener to the delete link
    if (deleteLink !== null)
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

function showPdf(blobData) {
    // Convert the hexadecimal data to a Uint8Array
    let data = new Uint8Array(blobData.match(/.{1,2}/g).map(byte => parseInt(byte, 16)));

    // Create a Blob from the Uint8Array
    let blob = new Blob([data], {type: 'application/pdf'});

    // Create an object URL from the Blob
    let url = URL.createObjectURL(blob);

    // Open the URL in a new tab
    window.open(url, '_blank');
}