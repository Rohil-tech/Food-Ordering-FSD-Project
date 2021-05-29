<?php include("partials/menu.php"); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>

        <br><br>

        <?php
            // Checking Whether the session is Set or not
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                // Displaying Session Message
                unset($_SESSION['add']);
                // Removing Session Message
            } 
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td><label for="full_name">Full Name:</label></td>
                    <td>
                        <input type="text" name="full_name" id="full_name" placeholder="Enter Your Name" class="block-square">
                    </td>
                </tr>
                <tr>
                    <td><label for="username">Username:</label></td>
                    <td>
                        <input type="text" name="username" id="username" placeholder="Enter Your Username" class="block-square">
                    </td>
                </tr>
                <tr>
                    <td><label for="password">Password:</label></td>
                    <td>
                        <input type="password" name="password" id="password" placeholder="Enter Password" class="block-square">
                    </td>
                </tr>
            </table>
            <br>
            <input type="submit" name="submit" value="Add Admin" class="btn-primary" id="submit">
        </form>

    </div>
</div>

<?php include("partials/footer.php"); ?>

<?php
    // Process the value from the form and save it in Database
    // Check whether the submit button is clicked or not

    if(isset($_POST['submit']))
    {
        // Button Clicked
        // echo "Button Clicked";

        // 1. Get the data from the form
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        // Password Encryption with md5

        // 2. SQL Query to save the data to the database
        $sql = "INSERT INTO tbl_admin SET
            full_name = '$full_name',
            username = '$username',
            password = '$password'
        ";
        
        // 3. Executing Query and Saving Data into Database
        $res = mysqli_query($conn, $sql) or die(mysqli_error());

        // 4. Check whether the Query is executed or Data is inserted or not and display appropriate message
        if($res==TRUE)
        {
            // Data Inserted
            // Create a Session Variable to Display Message
            $_SESSION['add'] = "<div class='success'>Admin Added Successfully</div>";
            // Redirect Page to Manage Admin
            header("location:".SITEURL."admin/manage-admin.php");
        }
        else
        {
            // Failed to Insert Data
            // Create a Session Variable to Display Message
            $_SESSION['add'] = "<div class='success'>Failed to Add Admin</div>";
            // Redirect Page to Manage Admin
            header("location:".SITEURL."admin/add-admin.php");
        }
        
    }
?>