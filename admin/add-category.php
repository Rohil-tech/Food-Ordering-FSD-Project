<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        
        <br>

        <?php 
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <br>
        
        <form action="" method="POST" enctype="multipart/form-data">
            
            <table class="tbl-30">
                
                <tr>
                    <td><label for="title">Title:</label></td>
                    <td>
                        <input type="text" name="title" id="title" placeholder="Category Title" class="block-square">
                    </td>
                </tr>

                <tr>
                    <td><label for="image">Select Image:</label></td>
                    <td>
                        <input type="file" name="image" id="image">
                    </td>
                </tr>
                
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" id="yes1" value="Yes">
                        <label for="yes1" class="radio-btn-label">Yes</label>
                        <input type="radio" name="featured" id="no1" value="No">
                        <label for="no1" class="radio-btn-label">No</label>
                    </td>
                </tr>
                
                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" id="yes2" value="Yes">
                        <label for="yes2" class="radio-btn-label">Yes</label>
                        <input type="radio" name="active" id="no2" value="No">
                        <label for="no2" class="radio-btn-label">No</label>
                    </td>
                </tr>
            </table>

            <br>
            <input type="submit" name="submit" value="Add Category" class="btn-primary" id="submit">
        
        </form>

        <?php 
            // Check whether the Submit button is clicked or not
            if(isset($_POST['submit']))
            {
                // Button is clicked
                
                // 1. Get the value from the Form
                $title = $_POST['title'];

                // For Radio input type we need to check whether the Button is Selected or not
                if(isset($_POST['featured']))
                {
                    // Get the Value from the Form
                    $featured = $_POST['featured'];
                }
                else
                {
                    // Set the Default Value
                    $featured = "No";
                }
                
                if(isset($_POST['active']))
                {
                    // Get the Value from the Form
                    $active = $_POST['active'];
                }
                else
                {
                    // Set the Default Value
                    $active = "No";
                }

                // Check whether the image is selected or not and set the value for image name accordingly
                
                // print_r($_FILES['image']);

                // die(); // Break the Code Here
                if(isset($_FILES['image']['name']))
                {
                    // Upload the Image
                    // To upload the Image we Need Image Name, Source Path and Destination Path
                    $image_name = $_FILES['image']['name'];
                    
                    // Upload Image only if Image is Selected
                    if($image_name != "")
                    {
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
                            header('location:'.SITEURL.'admin/add-category.php');
                            // Stop the process
                            die();
                        }
                    }
                }
                else
                {
                    // Don't upload Image and Set the Image Name value as blank
                    $image_name = "";
                }
                
                // 2. Create SQL Query to insert Category into the Database
                $sql = "INSERT INTO tbl_category SET
                    title = '$title',
                    image_name = '$image_name',
                    featured = '$featured',
                    active = '$active'
                ";

                // 3. Execute the Query and Save in the Database
                $res = mysqli_query($conn, $sql);

                // 4. Check whether the Query executed or not and Data added to the Database or not
                if($res == TRUE)
                {
                    // Query Executed and Category Added
                    $_SESSION['add'] = "<div class='success'>Category Added Successfully</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else
                {
                    // Failed to Add Category
                    $_SESSION['add'] = "<div class='error'>Failed to Add Category</div>";
                    header('location:'.SITEURL.'admin/add-category.php');
                }
            }
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>