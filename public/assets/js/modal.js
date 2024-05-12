// Define messages for different actions
if (typeof messages === 'undefined') {
    var messages = {
        'login': 'Login successful!',
        'LoginRequired': 'You must be logged in to continue!',
        'register': 'Registration successful!',
        'update': 'Update successful!',
        'delete': 'Deletion successful!',
        'logout': 'Logout successful!',
        'upload': 'Upload successful!',
        'error': 'An error has occurred!',
        'cartAdd': 'Item added to cart!',
        'cartRemove': 'Item removed from cart!',
        'productAdd': 'Product added successfully!',
        'reviewAdd': 'Review added successfully!',
        'reviewDelete': 'Review deleted successfully!',
        'profileUpdated': 'Profile info updated successfully!',
        'balanceUpdated': 'Balance updated successfully!',
        'passwordChangedPleaseLoginAgain': 'Password changed successfully! Please login again.',
        'notAdmin': 'You must be an admin to access this page!',
        'categoryAdded': 'Category added successfully!',
        'orderInserted': 'Order placed! Thank you for your purchase!',
        'couponAdded': 'Coupon added successfully!',
        'CodeAlreadyExists' : 'Coupon code already exists!',
        'numberError' : 'Please enter a valid number!',
        'codeError': 'Coupon code cannot be empty or whitespace!',
        'codeLengthError': 'Coupon code exceeds the maximum length of 255 characters!',
        'discountRangeError': 'Discount value must be between 0 and 999.99!',
        'decimalError': 'Discount must not have more than two decimal places!',
        'genericDatabaseError': 'Database operation failed, please try again!',
        'Success': 'Success!',
    };
}

// Add event listeners when the document is ready
document.addEventListener('DOMContentLoaded', function() {
    handleInfoModal();
    handleDbConnectionModal();
    handleModalClicks();
});

// Handle the information modal
function handleInfoModal() {
    // Get URL parameters
    const urlParams = new URLSearchParams(window.location.search);

    // If there's an 'info' parameter, display the corresponding message
    if (urlParams.has('info')) {
        var infoKey = urlParams.get('info');
        var message = messages[infoKey] || 'Invalid message.';
        displayModal('infoModal', message);
        history.pushState(null, '', location.pathname);
    }

    // Add a click event listener to the close button
    const closeButton = document.querySelector('.close');
    if (closeButton) {
        closeButton.addEventListener('click', function() {
            hideModal('infoModal');
        });
    }
}

// Handle the database connection modal
function handleDbConnectionModal() {
    // Get the last checked timestamp from local storage
    const lastCheckedTimestamp = localStorage.getItem('lastDbCheckTimestamp');
    const currentTime = new Date().getTime();

    // If the last checked timestamp is not set or it's been more than showModalAfterSeconds since the last check, show the modal and check the database connection
    if (!lastCheckedTimestamp || currentTime - lastCheckedTimestamp > showModalAfterSeconds * 1000) {
        showModal('dbConnectionModal', true);
        checkDatabaseConnection();
    } else {
        hideModal('dbConnectionModal');
    }
}

// Display a modal with a message and optional confirm and cancel buttons
function displayModal(modalId, message, options = {}) {
    const modal = document.getElementById(modalId);
    const infoMessageElement = document.getElementById('infoMessage');
    const confirmButton = document.getElementById('confirm');
    const cancelButton = document.getElementById('cancel');

    // Set the message
    infoMessageElement.innerText = message;

    // Configure the confirm and cancel buttons
    configureButton(confirmButton, options.confirmText, options.onConfirm);
    configureButton(cancelButton, options.cancelText, function() {
        hideModal(modalId);
    });

    // Show the modal
    showModal(modalId);
}

// Configure a button with text and a click event handler
function configureButton(button, text, onClick) {
    if (text) {
        button.innerText = text;
        button.style.display = 'block';
        button.onclick = onClick;
    } else {
        button.style.display = 'none';
    }
}

// Show a modal
function showModal(modalId, preventCloseOnClickOutside = false) {
    const modal = document.getElementById(modalId);
    modal.style.display = 'block';

    if (preventCloseOnClickOutside) {
        modal.setAttribute('preventCloseOnClickOutside', '');
    } else {
        modal.removeAttribute('preventCloseOnClickOutside');
    }
}

// Hide a modal
function hideModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.style.display = 'none';
}

// Handle clicks on the document
function handleModalClicks() {
    document.addEventListener('click', function(event) {
        // If the clicked element is a modal, hide it only if it doesn't have the 'preventCloseOnClickOutside' attribute
        if (event.target.className === 'modal' && !event.target.hasAttribute('preventCloseOnClickOutside')) {
            hideModal(event.target.id);
        } 
        // If the clicked element is a close button, hide the closest modal
        else if (event.target.classList.contains('close')) {
            const modal = event.target.closest('.modal');
            if (modal) {
                hideModal(modal.id);
            }
        } 
        // If the clicked element is the retry button, check the database connection
        else if (event.target.id === 'retryBtn') {
            const btn = event.target;
            btn.disabled = true; // Disable the button
            btn.style.backgroundColor = 'grey'; // Change the background color to grey
            btn.style.cursor = 'not-allowed'; // Change the cursor to 'not-allowed'
            checkDatabaseConnection();
            setTimeout(function() {
                btn.disabled = false; // Enable the button after 1 second
                btn.style.backgroundColor = ''; // Reset the background color
                btn.style.cursor = ''; // Reset the cursor
            }, 1000);
        }
        // If the clicked element is the continue button, hide the database connection modal
        else if (event.target.id === 'continueBtn') {
            hideModal('dbConnectionModal');
            this.location.reload();
        }
    });
}

// Check the database connection
function checkDatabaseConnection() {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "/check-db-connection", true);
    xhr.onload = function() {
        handleDbConnectionResponse(JSON.parse(xhr.responseText).connected);
    };
    xhr.send();
}

// Handle the response from the database connection check
function handleDbConnectionResponse(isConnected) {
    const modal = document.getElementById('dbConnectionModal');
    const statusText = modal.querySelector('#dbConnectionStatus');
    const statusIcon = modal.querySelector('#connectionStatusIcon');
    const continueBtn = modal.querySelector('#continueBtn');
    const retryBtn = modal.querySelector('#retryBtn');

    // Update the status text and icon
    statusText.textContent = isConnected ? "Database connection successful!" : "Database connection failed!";
    statusIcon.innerHTML = `<img src="../assets/images/${isConnected ? 'success' : 'failure'}.png" alt="${isConnected ? 'Success' : 'Failure'}" style="width:150px; height:auto;">`;

    // Show the continue button if the connection is successful, otherwise show the retry button
    continueBtn.style.display = isConnected ? 'block' : 'none';
    retryBtn.style.display = isConnected ? 'none' : 'block';

    // Store the connection status and the current timestamp in local storage
    localStorage.setItem('dbConnected', isConnected ? 'true' : 'false');
    localStorage.setItem('lastDbCheckTimestamp', new Date().getTime().toString());
}