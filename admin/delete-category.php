<?php

    // Include Constants File
    include('../config/constants.php');

    // Check whether the Values of ID and Image Name are Passed or not from the Manage Category Page
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        // Get the Value and Delete
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        // Remove the Physical Image File if Available
        if($image_name != "")
        {
            // Image is Available So we will have to remove it
            $path = "../images/category/".$image_name;
            // Remove the Image
            $remove = unlink($path);

            // If Failed to Remove Image then Add an Error Message and Stop the Message
            if($remove == FALSE)
            {
                // Set the Session Message
                $_SESSION['remove'] = "<div class='error'>Failed to Remove Category Image</div>";

                // Redirect to Manage Category Page
                header('location:'.SITEURL.'admin/manage-category.php');

                // Stop the Process
                die();
            }
        }

        // Delete Data from Database using SQL Query
        $sql = "DELETE FROM tbl_category WHERE id = $id";

        // Execute the Query
        $res = mysqli_query($conn, $sql);
        
        // Check whether the Data is Deleted from the Database or not
        if($res == TRUE)
        {
            // Set Success Message and Redirect
            $_SESSION['delete'] = "<div class='success'>Category Deleted Successfully</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        else
        {
            // Set Failed Message and Redirect
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Category</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
        }

        // Redirect to Manage Admin Page with Message
    }
    else
    {
        // Redirect to Manage Category Page
        header('location:'.SITEURL.'admin/manage-category.php');
    }

?>