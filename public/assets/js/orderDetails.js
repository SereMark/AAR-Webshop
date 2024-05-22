function createPdfBlob(event) {
    event.preventDefault(); // Prevent the form from submitting prematurely

    // Get the values from the hidden inputs
    const zipcode = document.getElementById('zipcode').value;
    const city = document.getElementById('city').value;
    const address = document.getElementById('address').value;
    const payment_type = document.getElementById('payment_type').value;
    const total_amount = document.getElementById('total_amount').value;
    const cart_items = JSON.parse(document.getElementById('cart_items').value);

    // Create a new instance of jsPDF
    const doc = new jsPDF('p', 'mm', 'a4', []);

    // Add a header with your company's name and contact information
    doc.setFontSize(22);
    doc.text('Your Company Name', 10, 10);
    doc.setFontSize(12);
    doc.text('Your Company Address', 10, 20);
    doc.text('Your Company City, State, Zip', 10, 30);
    doc.text('Your Company Phone Number', 10, 40);

    // Add a unique invoice number and the date of the invoice
    doc.text('Invoice Number: ' + Math.floor(Math.random() * 1000000), 10, 50);
    doc.text('Invoice Date: ' + new Date().toLocaleDateString(), 10, 60);

    // Add the customer's shipping information
    doc.text('Ship To:', 10, 70);
    doc.text('Zipcode: ' + zipcode, 10, 80);
    doc.text('City: ' + city, 10, 90);
    doc.text('Address: ' + address, 10, 100);

    // Add the payment type
    doc.text('Payment Type: ' + payment_type, 10, 110);
    doc.setFontSize(14);

    // Add a title for the cart items
    doc.text('Cart Items:', 10, 120);

    // Iterate over the cart items and add each one to the PDF
    let y = 130;
    let subtotal = 0;
    for (let i = 0; i < cart_items.length; i++) {
        const item = cart_items[i];
        doc.setFontSize(12);
        doc.text('Item ' + (i + 1) + ': ' + item.productname, 10, y);
        doc.text('Quantity: ' + item.quantity, 10, y + 10);
        doc.text('Price: ' + item.price, 10, y + 20);
        subtotal += item.quantity * item.price;
        y += 30;
    }

    // Add the subtotal, taxes (if applicable), and total amount
    doc.setFontSize(14);
    doc.text('Subtotal: ' + subtotal, 10, y);
    doc.text('Taxes: ' + (total_amount - subtotal), 10, y + 10);
    doc.text('Total Amount: ' + total_amount, 10, y + 20);

    // Output the PDF as a blob
    const blob = doc.output('blob');

    // Create a Blob object from the PDF data
    const pdfBlob = new Blob([blob], {type: 'application/pdf'});

    // Convert the blob to a base64 string
    const reader = new FileReader();
    reader.readAsDataURL(blob);
    reader.onloadend = function() {
        const base64data = reader.result;
        document.getElementById("blob").value = base64data;
        // Trigger the form submission here, after the FileReader has completed
        document.getElementById("order-form").submit();
    }

    // Create an object URL from the Blob
    const url = URL.createObjectURL(pdfBlob);


    // Open the URL in a new tab
    window.open(url, '_blank');
}