<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect fields from any of the three forms
    $fullname = isset($_POST["fullname"]) ? strip_tags(trim($_POST["fullname"])) : '';
    $lastname = isset($_POST["lastname"]) ? strip_tags(trim($_POST["lastname"])) : '';
    $email    = isset($_POST["email"]) ? filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL) : '';
    $phone    = isset($_POST["phone"]) ? strip_tags(trim($_POST["phone"])) : '';
    $company  = isset($_POST["company"]) ? strip_tags(trim($_POST["company"])) : '';
    $url      = isset($_POST["url"]) ? strip_tags(trim($_POST["url"])) : '';
    $topic    = isset($_POST["topic"]) ? strip_tags(trim($_POST["topic"])) : '';
    $other    = isset($_POST["other_topic"]) ? strip_tags(trim($_POST["other_topic"])) : '';
    $message  = isset($_POST["message"]) ? trim($_POST["message"]) : '';

    // If "other_topic" is filled, override topic
    if (!empty($other)) {
        $topic = $other;
    }

    // Validation - require fullname and topic
    if (empty($fullname) || empty($topic)) {
        http_response_code(400);
        echo "Please provide your name and select a topic.";
        exit;
    }

    // Recipient email
    $recipient = "info@oxodonia.co.uk"; // Change to your actual email
    $subject = "New Contact Request from $fullname $lastname";

    // Email content
    $email_content  = "Name: $fullname $lastname\n";
    if (!empty($company)) $email_content .= "Company: $company\n";
    if (!empty($email))   $email_content .= "Email: $email\n";
    if (!empty($phone))   $email_content .= "Phone: $phone\n";
    if (!empty($url))     $email_content .= "Website: $url\n";
    if (!empty($topic))   $email_content .= "Topic: $topic\n";
    if (!empty($message)) $email_content .= "Message:\n$message\n";

    // Email headers
    $headers = "From: $fullname <$email>";

    // Send email
    if (mail($recipient, $subject, $email_content, $headers)) {
        http_response_code(200); // Success for AJAX
        header("Location: /index.html");
        echo "Message sent successfully.";
    } else {
        http_response_code(500);
        echo "Oops! Something went wrong and we couldn't send your message.";
    }
} else {
    http_response_code(403);
    echo "Invalid request.";
}
    // Only process POST reqeusts.
    // if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //     // Get the form fields and remove whitespace.
    //     $fullname = strip_tags(trim($_POST["fullname"]));
	// 	$fullname = str_replace(array("\r","\n"),array(" "," "),$fullname);
    //     $phone = strip_tags(trim($_POST["phone"]));
    //     $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    //     $message = trim($_POST["message"]);

    //     // Check that data was sent to the mailer.
    //     if ( empty($fullname) OR empty($phone) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //         // Set a 400 (bad request) response code and exit.
    //         http_response_code(400);
    //         echo "Oops! There was a problem with your submission. Please complete the form and try again.";
    //         exit;
    //     }

    //     // Update this to your desired email address.
    //     $recipient = "contact@yourdomain.com";
	// 	$subject = "Message from $fullname";

    //     // Email content.
    //     $email_content = "Name: $fullname\n";
    //     $email_content .= "Email: $email\n\n";
    //     $email_content .= "Subject: $subject\n\n";
    //     $email_content .= "Phone: $phone\n\n";
    //     $email_content .= "Message: $message\n";

    //     // Email headers.
    //     $email_headers = "From: $fullname <$email>\r\nReply-to: <$email>";

    //     // Send the email.
    //     if (mail($recipient, $subject, $email_content, $email_headers)) {
    //         // Set a 200 (okay) response code.
    //         http_response_code(200);
    //         header("Location: index.html"); // Redirect after success
    //         echo "Thank You! Your message has been sent.";
    //     } else {
    //         // Set a 500 (internal server error) response code.
    //         http_response_code(500);
    //         echo "Oops! Something went wrong and we couldn't send your message.";
    //     }

    // } else {
    //     // Not a POST request, set a 403 (forbidden) response code.
    //     http_response_code(403);
    //     echo "There was a problem with your submission, please try again.";
    // }

?>