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

function validateForm() {
    const zipcode = document.getElementById('zipcode').value;
    const city = document.getElementById('city').value;
    const address = document.getElementById('address').value;
    const cardnumber = document.getElementById('cardnumber').value;
    const expirydate = document.getElementById('expirydate').value;
    const cardname = document.getElementById('cardname').value;
    const cvc = document.getElementById('cvc').value;

    // Zip Code ellenőrzése
    if (!/^\d{4}$/.test(zipcode)) {
        alert('Érvénytelen irányítószám. 4 számjegyből kell állnia.');
        return false;
    }

    // Város ellenőrzése
    if (city.trim() === '') {
        alert('A város megadása kötelező.');
        return false;
    }

    // Cím ellenőrzése
    if (address.trim() === '') {
        alert('A cím megadása kötelező.');
        return false;
    }

    // Ha a bankkártyás fizetés van kiválasztva, ellenőrizze a kártyaadatokat
    if (document.getElementById('payment_type_card').checked) {
        // Kártyaszám ellenőrzése
        if (!/^\d{16}$/.test(cardnumber)) {
            alert('Érvénytelen kártyaszám. 16 számjegyből kell állnia.');
            return false;
        }

        // Lejárati dátum ellenőrzése
        if (!/^\d{2}\/\d{2}$/.test(expirydate)) {
            alert('Érvénytelen lejárati dátum. MM/YY formátumban kell lennie.');
            return false;
        }

        // Kártyatulajdonos nevének ellenőrzése
        if (cardname.trim() === '') {
            alert('A kártyatulajdonos neve kötelező.');
            return false;
        }

        // CVC ellenőrzése
        if (!/^\d{3}$/.test(cvc)) {
            alert('Érvénytelen CVC. 3 számjegyből kell állnia.');
            return false;
        }
    }
    return true;
}

function validateFormMonth() {
    let monthValue = document.getElementById("month").value;
    if (monthValue < 1 || monthValue > 12) {
        monthValue = 1;
    }
    if (monthValue.length >= 2 && monthValue < 10) {
        monthValue = monthValue.slice(monthValue.length - 1);
    }else if (monthValue.length > 2 && monthValue >= 10) {
        monthValue = monthValue.slice(monthValue.length - 2);
    }
    expirydateValidator(monthValue, 0)
}

function validateFormYear() {
    let yearValue = document.getElementById("year").value;
    if (yearValue < 24 || yearValue > 99) {
        yearValue = 24;
    }
    if (yearValue.length > 2 && yearValue <= 99 )
    {
        yearValue = yearValue.slice(yearValue.length - 2);
    }
    expirydateValidator(0, yearValue)
}

function expirydateValidator(month, year) {
    let value = "";
    const slash = '/';
    let firstTwoDigits;
    if (month !== 0) {
        firstTwoDigits = month;
    }else {
        firstTwoDigits = 1;
    }
    let firstTwoDigitsString = firstTwoDigits.toString();
    if (firstTwoDigits > 12) {
        firstTwoDigitsString = "12";
    }
    if (firstTwoDigits < 1) {
        firstTwoDigitsString = "01";
    }
    if (firstTwoDigits < 10) {
        firstTwoDigitsString = "0" + firstTwoDigits;
    }
    let lastTwoDigits;
    if (year !== 0) {
        lastTwoDigits = year;
    }else {
        lastTwoDigits = 1;
    }
    let lastTwoDigitsString = lastTwoDigits.toString();
    if (lastTwoDigits < 24) {
        lastTwoDigitsString = "24";
    }
    if (lastTwoDigits > 99) {
        lastTwoDigitsString = "99";
    }
    value = firstTwoDigitsString + slash + lastTwoDigitsString;
    document.getElementById("expirydate").value = value;
}