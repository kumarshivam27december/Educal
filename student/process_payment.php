<?php
include('../config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

if (isset($_POST['pay_now'])) {
    $user_id = $_SESSION['user_id'];
    $course_id = $_POST['course_id'];
    $amount = $_POST['amount'];
    
    // Capture payment details
    $card_number = $_POST['card_number'];
    $expiry = $_POST['expiry'];
    $cvv = $_POST['cvv'];

    // Basic validation of card details
    if (strlen($card_number) != 16 || !preg_match("/^\d{2}\/\d{2}$/", $expiry) || strlen($cvv) != 3) {
        echo "Invalid payment details!";
        exit();
    }

    // Here you would normally connect to a payment gateway
    // For demonstration, let's assume payment is successful

    // Insert payment record
    $payment_sql = "INSERT INTO payments (user_id, course_id, amount) VALUES ('$user_id', '$course_id', '$amount')";
    if ($conn->query($payment_sql) === TRUE) {
        // Enroll the student in the course
        $enroll_sql = "INSERT INTO enrollments (user_id, course_id) VALUES ('$user_id', '$course_id')";
        if ($conn->query($enroll_sql) === TRUE) {
            // Set success message and redirect to the dashboard
            $_SESSION['success_message'] = "Payment successful! You have been enrolled in the course.";
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Enrollment failed: " . $conn->error;
        }
    } else {
        echo "Payment failed: " . $conn->error;
    }
}
?>
