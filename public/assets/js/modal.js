// Function to open a specified modal
function showModal(modalId) {
    var modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'block';
    }
}

// Function to hide a specified modal
function hideModal(modalId) {
    var modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none';
    }
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

    // Specific buttons like retry or continue could also be managed here
    else if (event.target.id === 'retryBtn') {
        checkDatabaseConnection();
    }
    else if (event.target.id === 'continueBtn') {
        hideModal('dbConnectionModal');
    }
});

// Function to update the content of the modal based on database connection status
function updateModalContent(isConnected) {
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
}

// Function to check database connection
function checkDatabaseConnection() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "/api/check-db-connection", true);
    xhr.onload = function() {
        const isConnected = JSON.parse(xhr.responseText).connected;
        updateModalContent(isConnected);
        localStorage.setItem('lastDbCheckTimestamp', new Date().getTime());
    };
    xhr.send();
}

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