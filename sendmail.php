<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $secretKey = "YOUR_SECRET_KEY";
    $recaptchaResponse = $_POST['g-recaptcha-response'];

    // Verify CAPTCHA
    $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaResponse}");
    $captchaSuccess = json_decode($verify);

    if (!$captchaSuccess->success) {
        echo "❌ reCAPTCHA verification failed. Please try again.";
        exit;
    }

    // Sanitize Inputs
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars(trim($_POST["message"]));
    $to = "hazdevs1@gmail.com";  // 👈 Change to your email
    $subject = "New Contact Message from Website";

    if (!empty($name) && !empty($email) && !empty($message)) {
        $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
        $headers = "From: $email";

        if (mail($to, $subject, $body, $headers)) {
            echo "✅ Thank you! Your message has been sent.";
        } else {
            echo "❌ Mail server error. Message not sent.";
        }
    } else {
        echo "⚠️ All fields are required.";
    }
} else {
    echo "Invalid request.";
}
?>
