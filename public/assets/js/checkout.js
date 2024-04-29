document.addEventListener('DOMContentLoaded', function () {
    const paymentType = document.querySelector('input[name="payment_type"]:checked');
    const cardDetails = document.querySelector('.card-details');
    const cardInputs = cardDetails.querySelectorAll('input[type="text"]'); // Select all text input fields within .card-details

    function togglePaymentDetails() {
        // Check if card payment is selected
        const isCard = document.getElementById('payment_type_card').checked;
        cardDetails.style.display = isCard ? 'flex' : 'none';
        // Disable input fields only when using card payment
        cardInputs.forEach(input => input.disabled = !isCard);
    }

    // Add event listener to each radio button
    document.querySelectorAll('input[name="payment_type"]').forEach(function (radio) {
        radio.addEventListener('change', togglePaymentDetails);
    });

    togglePaymentDetails();
});