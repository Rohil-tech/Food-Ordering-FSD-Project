<?php include("partials/menu.php"); ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Update Admin</h1>

            <br><br>

            <?php 
                // 1. Get the ID of selected admin
                $id = $_GET['id'];

                // 2. Create SQL Query to get the details
                $sql = "SELECT * FROM tbl_admin WHERE id = $id";

                // Execute Query
                $res = mysqli_query($conn, $sql);

                // Check whether the Query is Executed or not
                if($res == True)
                {
                    // Check whether the Data is available or not
                    $count = mysqli_num_rows($res);
                    // Check whether we have admin data or not
                    if($count == 1)
                    {
                        // Get the Details
                        $row = mysqli_fetch_assoc($res);

                        $full_name = $row['full_name'];
                        $username = $row['username'];
                    }
                    else
                    {
                        // Redirect to Manage Admin Page
                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                }
            ?>

            <form action="" method="POST">
                <table class="tbl-30">
                    <tr>
                        <td><label for="full_name">Full Name:</label></td>
                        <td>
                            <input type="text" name="full_name" id="full_name" value="<?php echo $full_name; ?>" class="block-square">
                        </td>
                    </tr>
                    <tr>
                        <td><label for="username">Username:</label></td>
                        <td>
                            <input type="text" name="username" id="username" value="<?php echo $username; ?>" class="block-square">
                        </td>
                    </tr>
                </table>
                <br>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="submit" name="submit" value="Update Admin" class="btn-primary" id="submit">
            </form>
        </div>
    </div>

<?php

    // Check whether the Submit Button is clicked or not
    if(isset($_POST['submit']))
    {
        // Get all the values from the form to update
        $id = $_POST['id'];
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];

        // Create an SQL Query to Update Admin
        $sql = "UPDATE tbl_admin SET
        full_name = '$full_name',
        username = '$username'
        WHERE id = '$id'
        ";

        // Execute the query
        $res = mysqli_query($conn, $sql);

        // Check whether the Query is executed successfully or not
        if($res == TRUE)
        {
            // Query Executed and Admin Update
            $_SESSION['update'] = '<div class="success">Admin Updated Successfully</div>';
            // Redirect to Manage Admin Page
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
        else
        {
            // Failed to Update Admin
            $_SESSION['update'] = '<div class="error">Failed to Update Admin</div>';
            // Redirect to Manage Admin Page
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
    }

?>

<?php include("partials/footer.php"); ?>