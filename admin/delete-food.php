<?php 
    // Include Constants Page
    include('../config/constants.php');

    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        // Process to Delete
        
        // 1. Get ID and Image Name
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        // 2. Remove the Image if Available
        // Check whether the Image is Available or Not
        // Delete the Image if it is Available
        if($image_name != "")
        {
            // Image is Available and Needs to be Removed from Folder
            // Get the Image Path
            $path = "../images/food/".$image_name;

            // Remove the Image File from the Path
            $remove = unlink($path);

            if($remove == FALSE)
            {
                // Failed to Remove the Image
                $_SESSION['upload'] = "<div class='error'>Failed to Remove Image File</div>";
                // Redirect to Manage Food
                header('location:'.SITEURL.'admin/manage-food.php');
                // Stop the Process of Deleting Food
                die();
            }
        }

        // 3. Delete Food from Database
        $sql = "DELETE FROM tbl_food WHERE id = $id";
        // Execute the Query
        $res = mysqli_query($conn, $sql);

        // 4. Redirect to Manage Food with Session Message
        // Check whether the Query Executed or Not and Set the Session Message Accordingly
        if($res == TRUE)
        {
            // Food Deleted
            $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else
        {
            // Failed to Delete Food
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Food</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
    }
    else
    {
        // Redirect to Manage Food Page
        $_SESSION['unauthorized'] = "<div class='error'>Unauthorized Access</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }

?>