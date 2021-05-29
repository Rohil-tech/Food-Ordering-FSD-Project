<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>
        <br>

        <?php

        // Check whether the ID is set or not
        if(isset($_GET['id']))
        {
            // Get the ID and all other details
            $id = $_GET['id'];

            // Create SQL Query to get all other details
            $sql = "SELECT * FROM tbl_category
            WHERE id = $id";

            // Execute the Query
            $res = mysqli_query($conn, $sql);

            // Count the Rows to Check whether the ID is Valid or not
            $count = mysqli_num_rows($res);

            if($count == 1)
            {
                // Get all the Data
                $row = mysqli_fetch_assoc($res);
                $title = $row['title'];
                $current_image = $row['image_name'];
                $featured = $row['featured'];
                $active = $row['active'];
            }
            else
            {
                // Redirect to Manage Category Page with Session Message
                $_SESSION['no-category-found'] = "<div class='error'>Category Not Found</div>";
                header('location:'.SITEURL.'admin/manage-category.php');
            }
        }
        else
        {
            // Redirect to Manage Category
            header('location:'.SITEURL.'admin/manage-category.php');
        }

        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td><label for="title">Title:</label></td>
                    <td>
                        <input type="text" name="title" id="title" value="<?php echo $title; ?>" class="block-square">
                    </td>
                </tr>

                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php
                            if($current_image != "")
                            {
                                // Display the Image
                                ?>
                                    <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="200px">
                                <?php
                            }
                            else
                            {
                                // Display Message
                                echo "<div class='error'>Image Not Added</div>";
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td><label for="image">New Image:</label></td>
                    <td>
                        <input type="file" name="image" id="image">
                    </td>
                </tr>
                    
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input <?php if($featured == "Yes"){echo "Checked";} ?> type="radio" name="featured" id="yes1" value="Yes">
                        <label for="yes1" class="radio-btn-label">Yes</label>
                        <input <?php if($featured == "No"){echo "Checked";} ?> type="radio" name="featured" id="no1" value="No">
                        <label for="no1" class="radio-btn-label">No</label>
                    </td>
                </tr>
                    
                <tr>
                    <td>Active:</td>
                    <td>
                        <input <?php if($active == "Yes"){echo "Checked";} ?> type="radio" name="active" id="yes2" value="Yes">
                        <label for="yes2" class="radio-btn-label">Yes</label>
                        <input <?php if($active == "No"){echo "Checked";} ?> type="radio" name="active" id="no2" value="No">
                        <label for="no2" class="radio-btn-label">No</label>
                    </td>
                </tr>
            </table>

            <br>
            <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="submit" name="submit" value="Update Category" class="btn-primary" id="submit">

        </form>

        <?php
            if(isset($_POST['submit']))
            {
                // 1. Get all the Values from the Form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $current_image = $_POST['current_image'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                // 2. Updating New Image if Selected
                // Check whether the Image is Selected or Not
                if(isset($_FILES['image']['name']))
                {
                    // Get the image Details
                    $image_name = $_FILES['image']['name'];

                    // Check whether the Image is Available or Not
                    if($image_name != "")
                    {
                        // Image Available
                        // A. Upload the New Image
                        
                        // Auto rename Image to prevent the same image from getting renamed
                        // Get the extension of the image
                        $ext = end(explode('.', $image_name));

                        // Rename the Image
                        $image_name = "Food_Category_".rand(000, 999).'.'.$ext;

                        $source_path = $_FILES['image']['tmp_name'];
                        $destination_path = "../images/category/".$image_name;

                        // Upload the Image
                        $upload = move_uploaded_file($source_path, $destination_path);

                        // Check whether the Image is uploaded or not
                        // If the image is not uploaded then we will stop the process and redirect with error message
                        if($upload == FALSE)
                        {
                            // Set message
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image</div>";
                            // Redirect to Add Category Page
                            header('location:'.SITEURL.'admin/manage-category.php');
                            // Stop the process
                            die();
                        }

                        // B. Remove the Current Image if Available
                        if($current_image != "")
                        {
                            $remove_path = "../images/category/".$current_image;
                            $remove = unlink($remove_path);

                            // Check whether the Image is Removed or not
                            // If Failed to Remove then Display Message and Stop the Process
                            if($remove == FALSE)
                            {
                                // Failed to Remove Image
                                $_SESSION['failed-remove'] = "<div class='error'>Failed to Remove Current Image</div>";
                                header('location:'.SITEURL.'admin/manage-category.php');
                                die(); // Stop the process
                            }
                        }
                    }
                    else
                    {
                        $image_name = $current_image;
                    }
                }
                else
                {
                    $image_name = $current_image;
                }

                // 3. Update the Database
                $sql2 = "UPDATE tbl_category SET
                    title = '$title',
                    image_name = '$image_name',
                    featured = '$featured',
                    active = '$active'
                    WHERE id = $id
                ";
                // Execute the Query
                $res2 = mysqli_query($conn, $sql2);

                // 4. Redirect to Manage Category with Message
                // Check whether Query Executed or Not
                if($res2 == TRUE)
                {
                    // Category updated
                    $_SESSION['update'] = "<div class='success'>Category Updated Successfully</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else
                {
                    // Failed to Update Category
                    $_SESSION['update'] = "<div class='error'>Failed to Update Category</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
            }
        ?>
    
    </div>
</div>

<?php include('partials/footer.php'); ?>