<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = isset($_POST["fullname"]) ? strip_tags(trim($_POST["fullname"])) : '';
    $lastname = isset($_POST["lastname"]) ? strip_tags(trim($_POST["lastname"])) : '';
    $email    = isset($_POST["email"]) ? filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL) : '';
    $topic    = isset($_POST["topic"]) ? strip_tags(trim($_POST["topic"])) : '';
    $message  = isset($_POST["message"]) ? trim($_POST["message"]) : '';

    // Validate required fields (First name, Topic, Message)
    if (empty($fullname) || empty($topic) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Please fill in all required fields.";
        exit;
    }

    // Recipient email
    $recipient = "info@oxodonia.co.uk"; // Change to your real email
    $subject = "New Help Request from $fullname $lastname";

    // Email content
    $email_content  = "Name: $fullname $lastname\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Topic: $topic\n";
    $email_content .= "Message:\n$message\n";

    // Headers
    $headers = "From: $fullname <$email>";

    // Send email
    if (mail($recipient, $subject, $email_content, $headers)) {
        http_response_code(200);
        header("Location: index.html"); // Redirect after success
        exit;
    } else {
        http_response_code(500);
        echo "Oops! Something went wrong and we couldn't send your message.";
    }
} else {
    http_response_code(403);
    echo "Invalid request.";
}
?>
