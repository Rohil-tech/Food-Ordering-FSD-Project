<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        
        <br><br>

        <?php 
            if(isset($_GET['id']))
            {
                $id = $_GET['id'];
            }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td><label for="current_password">Current Password:</label></td>
                    <td>
                        <input type="password" name="current_password" id="current_password" placeholder="Current Password" class="block-square">
                    </td>
                </tr>

                <tr>
                    <td><label for="new_password">New Password:</label></td>
                    <td>
                        <input type="password" name="new_password" id="new_password" placeholder="New Password" class="block-square">
                    </td>
                </tr>
                
                <tr>
                    <td><label for="confirm_password">Confirm Password:</label></td>
                    <td>
                        <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" class="block-square">
                    </td>
                </tr>
            </table>
            <br>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="submit" name="submit" value="Change Password" class="btn-primary" id="submit">
        </form>

    </div>
</div>

<?php
    // Check whether the submit button is clicked or not
    if(isset($_POST['submit']))
    {
        // 1. Get the data from the form
        $id = $_POST['id'];
        $current_password = md5($_POST['current_password']);
        $new_password = md5($_POST['new_password']);
        $confirm_password = md5($_POST['confirm_password']);

        // 2. Check whether the User with Current ID and Password exist or not
        $sql = "SELECT * FROM tbl_admin WHERE id = $id AND password = '$current_password'";

        // Execute the Query
        $res = mysqli_query($conn, $sql);

        if($res == TRUE)
        {
            // Check whether the Data is available or not
            $count = mysqli_num_rows($res);

            if($count == 1)
            {
                // User Exists and Password can be changed
                // Check whether the New Password and Confirm Password match or not
                if($new_password == $confirm_password)
                {
                    // Update Password
                    $sql2 = "UPDATE tbl_admin SET
                    password = '$new_password'
                    WHERE id = $id
                    ";

                    // Execute the Query
                    $res2 = mysqli_query($conn, $sql2);

                    // Check whether the Query executed or not
                    if($res2 == TRUE)
                    {
                        // Display Success Message
                        // Redirect to Manage Admin Page with Error Message
                        $_SESSION['change-pwd'] = "<div class='success'>Password Changed Successfully</div>";
                        // Redirect the User
                        header('location:'.SITEURL.'admin/manage-admin.php');    
                    }
                    else
                    {
                        // Display Error Message
                        // Redirect to Manage Admin Page with Error Message
                        $_SESSION['change-pwd'] = "<div class='error'>Failed to Change Password</div>";
                        // Redirect the User
                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                }
                else
                {
                    // Redirect to Manage Admin Page with Error Message
                    $_SESSION['pwd-not-match'] = "<div class='error'>Password Did Not Match</div>";
                    // Redirect the User
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }
            else
            {
                // User does not Exist Set Message and Redirect
                $_SESSION['user-not-found'] = "<div class='error'>User Not Found</div>";
                // Redirect the User
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
        }
        
        // 3. Check whether the New Password and Confirm Password match or not

        // 4. Change Password if all the above is True
    }
?>

<?php include('partials/footer.php'); ?>