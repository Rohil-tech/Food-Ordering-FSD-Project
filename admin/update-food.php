<?php include('partials/menu.php'); ?>

<?php 
    // Check whether ID is Set or Not
    if(isset($_GET['id']))
    {
        // Get all the Details
        $id = $_GET['id'];

        // SQL Query to Get the Selected Food
        $sql2 = "SELECT * FROM tbl_food WHERE id = $id";

        // Execute the Query
        $res2 = mysqli_query($conn, $sql2);

        // Get the Value Based on Query Executed
        $row2 = mysqli_fetch_assoc($res2);

        // Get the Individual Values of Selected Food
        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category_id'];
        $featured = $row2['featured'];
        $active = $row2['active'];
    }
    else
    {
        // Redirect to Manage Food
        header('location:'.SITEURL.'admin/manage-food.php');
    }
?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Update Food</h1>
            <br>

            <br>
            <form action="" method="POST" enctype="multipart/form-data">
                <table class="tbl-30">
                    <tr>
                        <td><label for="title">Title:</label></td>
                        <td>
                            <input type="text" name="title" id="title" class="block-square" value="<?php echo $title; ?>">
                        </td>
                    </tr>
                    
                    <tr>
                        <td><label for="description">Description:</label></td>
                        <td>
                            <textarea name="description" id="title" cols="30" rows="5" class="block-square"><?php echo $description; ?></textarea>
                        </td>
                    </tr>

                    <tr>
                        <td><label for="price">Price:</label></td>
                        <td>
                            <input type="number" name="price" id="price" class="block-square" value="<?php echo $price; ?>">
                        </td>
                    </tr>

                    <tr>
                        <td>Current Image:</td>
                        <td>
                            <?php
                                if($current_image == "")
                                {
                                    // Image Not Available
                                    echo "<div class='error'>Image Not Available</div>";
                                }
                                else
                                {
                                    // Image Available
                                    ?>
                                    
                                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="200px">
                                    
                                    <?php
                                }
                            ?>
                        </td>
                    </tr>
                    
                    <tr>
                        <td><label for="image">Select Image:</label></td>
                        <td>
                            <input type="file" name="image" id="image">
                        </td>
                    </tr>

                    <tr>
                        <td><label for="category">Category:</label></td>
                        <td>
                            <select name="category" id="category" class="block-square">

                                <?php
                                    // Query to Get Active Categories 
                                    $sql = "SELECT * FROM tbl_category WHERE active = 'Yes'";
                                    // Execute the Query
                                    $res = mysqli_query($conn, $sql);
                                    // Count Rows
                                    $count = mysqli_num_rows($res);
                                    
                                    // Check whether the Category is Available or Not
                                    if($count > 0)
                                    {
                                        // Category Available
                                        while($row = mysqli_fetch_assoc($res))
                                        {
                                            $category_title = $row['title'];
                                            $category_id = $row['id'];
                                            
                                            ?>

                                            <option <?php if($current_category == $category_id) {echo "Selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>

                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        // Category Not Available
                                        echo "<option value='0'>Category Not Available</option>";
                                    }
                                ?>
                            </select>
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
                    <tr>
                        <td>
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        </td>
                    </tr>
                </table>

                <br>
                <input type="submit" name="submit" value="Update Food" class="btn-primary" id="submit">
            
            </form>

            <?php 
            
                if(isset($_POST['submit']))
                {
                    // 1. Get All the Details from the Form
                    $id = $_POST['id'];
                    $title = $_POST['title'];
                    $description = $_POST['description'];
                    $price = $_POST['price'];
                    $current_image = $_POST['current_image'];
                    $category = $_POST['category'];
                    $featured = $_POST['featured'];
                    $active = $_POST['active'];

                    // 2. Upload the Image if Selected
                    // Check whether the Upload Button is Clicked or Not
                    if(isset($_FILES['image']['name']))
                    {
                        // Upload Button Clicked
                        $image_name = $_FILES['image']['name'];

                        // Check whether the File is Available or Not
                        if($image_name != "")
                        {
                            // Image is Available
                            // A. Uploading New Image
                            // Get the Extension
                            $ext = end(explode('.', $image_name));
                            
                            // Rename the Image
                            $image_name = "Food-Name-".rand(0000, 9999).'.'.$ext;

                            // Get the Source and Destination Paths
                            $src_path = $_FILES['image']['tmp_name'];
                            $dest_path = "../images/food/".$image_name;

                            // Upload the Image
                            $upload = move_uploaded_file($src_path, $dest_path);

                            // Check whether the Image is Uploaded or Not
                            if($upload == FALSE)
                            {
                                // Failed to Upload
                                $_SESSION['upload'] = "<div class='error'>Failed to Upload New Image</div>";
                                // Redirect to Manage Food Page
                                header('location:'.SITEURL.'admin/manage-food.php');
                                // Stop the Process
                                die();
                            }

                            // 3. Remove the Image if New Image is Uploaded and Current Image Exists
                            // B. Remove Current Image if Available
                            if($current_image != "")
                            {
                                // Current Image is Available
                                // Remove the Image
                                $remove_path = "../images/food/".$current_image;

                                $remove = unlink($remove_path);

                                // Check whether the Image is Removed or Not
                                if($remove == FALSE)
                                {
                                    // Failed to Remove Current Image
                                    $_SESSION['remove-failed'] = "<div class='error'>Failed to Remove Current Image</div>";
                                    // Redirect to Manage Food Page
                                    header('location:'.SITEURL.'admin/manage-food.php');
                                    // Stop the Process
                                    die();
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

                    // 4. Update the Food Database
                    $sql3 = "UPDATE tbl_food SET
                        title = '$title',
                        description = '$description',
                        price = $price,
                        image_name = '$image_name',
                        category_id = '$category',
                        featured = '$featured',
                        active = '$active'
                        WHERE id = $id
                    ";

                    // Execute the Query
                    $res3 = mysqli_query($conn, $sql3);

                    // Check whether the Query is Executed or Not
                    if($res == TRUE)
                    {
                        // Query Executed and Food Updated
                        $_SESSION['update'] = "<div class='success'>Food Updated Successfully</div>";
                        header('location:'.SITEURL.'admin/manage-food.php');
                    }
                    else
                    {
                        // Failed to Update Food
                        $_SESSION['update'] = "<div class='error'>Failed to Update Food</div>";
                        header('location:'.SITEURL.'admin/manage-food.php');
                    }
                }
            
            ?>

        </div>
    </div>

<?php include('partials/footer.php'); ?>