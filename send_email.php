<?php
// send_email.php
// This script sends an email with order details to mansoursalsabil2005@gmail.com

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $full_name = htmlspecialchars($_POST['full_name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $address = htmlspecialchars($_POST['address']);
    $city = htmlspecialchars($_POST['city']);
    $postal_code = htmlspecialchars($_POST['postal_code']);
    $notes = htmlspecialchars($_POST['notes']);
    $payment_method = htmlspecialchars($_POST['payment_method']);
    $order_summary = htmlspecialchars($_POST['order_summary']);
    $order_total = htmlspecialchars($_POST['order_total']);
    
    // Generate order number
    $order_number = "VS-" . rand(10000, 99999);
    
    // Email settings
    $to_admin = "mansoursalsabil2005@gmail.com"; // Your email
    $admin_subject = "🚨 NEW ORDER #$order_number - Vanilla Sky Perfumes 🚨";
    
    // Email message to YOU
    $admin_message = "
    <html>
    <head>
        <title>NEW ORDER #$order_number - Vanilla Sky</title>
    </head>
    <body>
        <h1>🚨 NEW ORDER RECEIVED 🚨</h1>
        <h2>Order #$order_number</h2>
        <p><strong>Date:</strong> " . date('F j, Y, g:i a') . "</p>
        
        <h3>📦 ORDER DETAILS</h3>
        <pre>$order_summary</pre>
        
        <h3>👤 CUSTOMER INFORMATION</h3>
        <p><strong>Name:</strong> $full_name</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Phone:</strong> $phone</p>
        <p><strong>Address:</strong> $address, $city" . (!empty($postal_code) ? " ($postal_code)" : "") . "</p>
        
        <h3>💳 PAYMENT METHOD</h3>
        <p>" . ($payment_method == 'cash_on_delivery' ? 'Cash on Delivery' : 'Bank Transfer') . "</p>
        
        <h3>📝 CUSTOMER NOTES</h3>
        <p>" . (!empty($notes) ? $notes : 'No notes provided') . "</p>
        
        <p><strong>ORDER TOTAL: $order_total</strong></p>
        
        <p>🛍️ Vanilla Sky Perfumes | Marque 100% tunisienne 🇹🇳</p>
    </body>
    </html>
    ";
    
    // Headers
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: Vanilla Sky Orders <orders@vanillasky.tn>" . "\r\n";
    $headers .= "Reply-To: $email" . "\r\n";
    
    // Send email to admin
    mail($to_admin, $admin_subject, $admin_message, $headers);
    
    // Also send confirmation to customer
    $customer_subject = "✅ Order Confirmation #$order_number - Vanilla Sky Perfumes";
    $customer_message = "
    <html>
    <head>
        <title>Order Confirmation</title>
    </head>
    <body>
        <h2>Thank you for your order, $full_name!</h2>
        <p>Your order #$order_number has been received and is being processed.</p>
        
        <h3>Order Summary:</h3>
        <pre>$order_summary</pre>
        
        <p><strong>Total: $order_total</strong></p>
        
        <p>Our delivery team will contact you at <strong>$phone</strong> within 24 hours.</p>
        <p>Payment Method: " . ($payment_method == 'cash_on_delivery' ? 'Cash on Delivery (Pay when you receive)' : 'Bank Transfer') . "</p>
        
        <p>If you have any questions, please contact us at mansoursalsabil2005@gmail.com</p>
        
        <p>Best regards,<br>
        Vanilla Sky Perfumes Team</p>
    </body>
    </html>
    ";
    
    $customer_headers = "MIME-Version: 1.0" . "\r\n";
    $customer_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $customer_headers .= "From: Vanilla Sky Perfumes <mansoursalsabil2005@gmail.com>" . "\r\n";
    
    // Send confirmation to customer
    mail($email, $customer_subject, $customer_message, $customer_headers);
    
    // Redirect to thank you page
    header("Location: thankyou.html?order=" . $order_number);
    exit();
} else {
    // If not POST request, redirect to checkout
    header("Location: checkout.html");
    exit();
}
?>