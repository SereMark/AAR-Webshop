// Predefined messages for different scenarios (gecironda, tudom)
const messages = {
    'login': 'Login successful!',
    'register': 'Registration successful!',
    'update': 'Update successful!',
    'delete': 'Deletion successful!',
    'logout': 'Logout successful!',
    'upload': 'Upload successful!'
};

document.addEventListener('DOMContentLoaded', function() {
    var urlParams = new URLSearchParams(window.location.search);

    // Check if the success parameter is present
    if (urlParams.has('success')) {
        var successKey = urlParams.get('success');
        var message = messages[successKey] || 'Operation successful!';
        displayModal('infoModal', message);
    }

    // Event listener for closing the modal
    var closeButton = document.querySelector('.close');
    if (closeButton) {
        closeButton.addEventListener('click', function() {
            hideModal('infoModal');
            // Remove the query parameter from the URL without refreshing the page
            history.pushState(null, '', location.pathname);
        });
    }
});

// Function to display the modal with a specific message
function displayModal(modalId, message) {
    var modal = document.getElementById(modalId);
    var infoMessageElement = document.getElementById('infoMessage');

    if (modal && infoMessageElement) {
        infoMessageElement.innerText = message;
        showModal(modalId);
    } else {
        console.error('Modal or message element not found!');
    }
}

// Function to open a specified modal
function showModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.style.display = 'block';
}

// Function to hide a specified modal
function hideModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.style.display = 'none';
}

// Handle all clicks that might involve modal interactions
document.addEventListener('click', function(event) {
    // Closing modals if the 'modal' class background is clicked
    if (event.target.className === 'modal') {
        hideModal(event.target.id);
    }

    // Handling click on any 'close' button inside modals
    else if (event.target.classList.contains('close')) {
        var modal = event.target.closest('.modal');
        if (modal) {
            hideModal(modal.id);
        }
    }

    else if (event.target.id === 'retryBtn') {
        checkDatabaseConnection();
    }
    else if (event.target.id === 'continueBtn') {
        hideModal('dbConnectionModal');
    }
});

// Initial checks on document load
document.addEventListener('DOMContentLoaded', function() {
    const lastCheckedTimestamp = localStorage.getItem('lastDbCheckTimestamp');
    const currentTime = new Date().getTime();

    if (!lastCheckedTimestamp || currentTime - lastCheckedTimestamp > showModalAfterSeconds * 1000) {
        showModal('dbConnectionModal');
        checkDatabaseConnection();
    } else {
        hideModal('dbConnectionModal');
    }
});

// Function to check database connection
function checkDatabaseConnection() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "/api/check-db-connection", true);
    xhr.onload = function() {
        const isConnected = JSON.parse(xhr.responseText).connected;
        const modal = document.getElementById('dbConnectionModal');
        const statusText = modal.querySelector('#dbConnectionStatus');
        const statusIcon = modal.querySelector('#connectionStatusIcon');
        const continueBtn = modal.querySelector('#continueBtn');
        const retryBtn = modal.querySelector('#retryBtn');
    
        statusText.textContent = isConnected ? "Database connection successful!" : "Database connection failed!";
        statusIcon.innerHTML = `<img src="../assets/images/${isConnected ? 'success' : 'failure'}.png" alt="${isConnected ? 'Success' : 'Failure'}" style="width:150px; height:auto;">`;
        continueBtn.style.display = isConnected ? 'block' : 'none';
        retryBtn.style.display = isConnected ? 'none' : 'block';

        localStorage.setItem('dbConnected', isConnected ? 'true' : 'false');
        localStorage.setItem('lastDbCheckTimestamp', new Date().getTime());
    };
    xhr.send();
}