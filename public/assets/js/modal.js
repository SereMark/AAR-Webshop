// Function to open the login modal
function showLoginModal() {
    document.getElementById('loginModal').style.display = 'block';
}

// Function to open the register modal
function showRegisterModal() {
    document.getElementById('registerModal').style.display = 'block';
}

// Close the modal when the user clicks anywhere outside of the modal
window.onclick = function(event) {
    if (event.target.className === 'modal') {
        event.target.style.display = "none";
    }
};

// Close the modal when the user clicks on the 'x' span
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('close')) {
        event.target.parentElement.parentElement.style.display = 'none';
    }
});

// Check if the connection to the database is successful
document.addEventListener('DOMContentLoaded', function() {
    const lastCheckedTimestamp = localStorage.getItem('lastDbCheckTimestamp');
    const currentTime = new Date().getTime();

    // Function to show modal
    function showModal() {
        document.getElementById('dbConnectionModal').style.display = 'block';
    }

    // Function to hide modal
    function hideModal() {
        document.getElementById('dbConnectionModal').style.display = 'none';
    }

    function updateModalContent(isConnected) {
        const statusText = document.getElementById('dbConnectionStatus');
        const statusIcon = document.getElementById('connectionStatusIcon');
        const continueBtn = document.getElementById('continueBtn');
        const retryBtn = document.getElementById('retryBtn');

        if (isConnected) {
            statusText.textContent = "Database connection successful!";
            statusIcon.innerHTML = '<img src="../assets/images/success.png" alt="Success" style="width:150px; height:auto;">';
            continueBtn.style.display = 'block';
            retryBtn.style.display = 'none';
            localStorage.setItem('dbConnected', 'true');
        } else {
            statusText.textContent = "Database connection failed!";
            statusIcon.innerHTML = '<img src="../assets/images/failure.png" alt="Failure" style="width:150px; height:auto;">';
            continueBtn.style.display = 'none';
            retryBtn.style.display = 'block';
            localStorage.setItem('dbConnected', 'false');
        }
    }

    function checkDatabaseConnection() {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "/api/check-db-connection", true);

        xhr.onload = function() {
            const isConnected = JSON.parse(xhr.responseText).connected;
            updateModalContent(isConnected);
            // Update the timestamp in localStorage
            localStorage.setItem('lastDbCheckTimestamp', currentTime);
        };

        xhr.send();
    }

    if (!lastCheckedTimestamp || currentTime - lastCheckedTimestamp > showModalAfterSeconds * 1000) {
        showModal();
        checkDatabaseConnection();
    } else {
        hideModal();
    }

    document.querySelector('.close').addEventListener('click', function() {
        hideModal();
    });

    document.getElementById('retryBtn').addEventListener('click', function() {
        checkDatabaseConnection();
    });

    document.getElementById('continueBtn').addEventListener('click', function() {
        hideModal();
    });
});