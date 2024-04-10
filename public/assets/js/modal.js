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