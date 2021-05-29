<?php include('../config/constants.php') ?>

<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Food Order System</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body class="bkgnd">
    <div class="login">
        <h1 class="text-center line">Login</h1>
        <br>

        <?php 
            if(isset($_SESSION['login']))
            {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }
            
            if(isset($_SESSION['no-login-message']))
            {
                echo $_SESSION['no-login-message'];
                unset($_SESSION['no-login-message']);
            }
        ?>
        <br>

        <!-- Login Form Starts Here -->
        <form action="" method="POST" class="text-center">

            <label for="username">Username</label>
            <br>
            <input type="text" name="username" id="username" placeholder="Enter Username" class="block">
            <br><br>

            <label for="password">Password</label>
            <br>
            <input type="password" name="password" id="password" placeholder="Enter Password" class="block">
            <br><br>

            <input type="submit" name="submit" value="Login" class="btn-primary" id="submit">
            <br><br>

        </form>
        <!-- Login Form Ends Here -->
        
        <br>
        <p class="text-center">Developed by Wow Food</p>
    </div>
</body>
</html>

<?php
    // Check whether the Submit Button is Clicked or Not
    if(isset($_POST['submit']))
    {
        // Process for Login
        // 1. Get the Data from Login Form
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        
        // 2. SQL to Check whether the User with Username and Password exist or not 
        $sql = "SELECT * FROM tbl_admin
        WHERE username = '$username' AND password = '$password'";

        // 3. Execute the Query
        $res = mysqli_query($conn, $sql);

        // 4. Count rows to check whether the user exists or not
        $count = mysqli_num_rows($res);

        if($count == 1)
        {
            // User available and Login Success
            $_SESSION['login'] = "<div class='success'>Login Successful</div>";
            $_SESSION['user'] = $username;
            // To check whether the user is logged in or not and logout will unset it

            // Redirect to Admin Dashboard
            header('location:'.SITEURL.'admin/');
        }
        else
        {
            // User not available and Login Failed
            $_SESSION['login'] = "<div class='error text-center'>Login Failed<br>Username or Password Did Not Match</div>";
            // Redirect to Admin Dashboard
            header('location:'.SITEURL.'admin/login.php');
        }

    }

?>