<?php 
    // Authorization - Access Control
    // Check whether the user is logged in or not
    if(!isset($_SESSION['user'])) // If user session is not set
    {
        // User is not logged in
        // Redirecting to login page with message
        $_SESSION['no-login-message'] = "<div class='error text-center'>Please Login to Access Admin Panel</div>";
        header('location:'.SITEURL.'admin/login.php');
    }
?>