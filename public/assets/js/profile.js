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

function showPdf(blobData, reportName) {
    // Adapted from: https://blog.jayway.com/2017/07/13/open-pdf-downloaded-api-javascript/
    const fileName = reportName && `${ reportName }.pdf` || 'myreport.pdf';

    const newBlob = new Blob([blobData], {type: "application/pdf"});

    const newWindow = window.open('', reportName, "width=800,height=1200");
    if ((newWindow)) {
        setTimeout( () => {
            const dataUrl = window.URL.createObjectURL(newBlob);
            const title = newWindow.document.createElement('title');
            const iframe = newWindow.document.createElement('iframe');

            title.appendChild(document.createTextNode(reportName));
            newWindow.document.head.appendChild(title);

            iframe.setAttribute('src', dataUrl);
            iframe.setAttribute('width', "100%");
            iframe.setAttribute('height', "100%");

            newWindow.document.body.appendChild(iframe);

            setTimeout( () => {
                // For Firefox it is necessary to delay revoking the ObjectURL
                window.URL.revokeObjectURL(dataUrl);
            }, 100);
        }, 100);
    } else {
        alert("To display reports, please disable any pop-blockers for this page and try again.");
    }

};