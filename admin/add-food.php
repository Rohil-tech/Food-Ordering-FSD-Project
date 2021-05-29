<?php include('partials/menu.php') ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Add Food</h1>
            <br>

            <?php
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
                        <td><label for="description">Description:</label></td>
                        <td>
                            <textarea name="description" id="title" cols="30" rows="5" placeholder="Description of the Food" class="block-square"></textarea>
                        </td>
                    </tr>

                    <tr>
                        <td><label for="price">Price:</label></td>
                        <td>
                            <input type="number" name="price" id="price" placeholder="Price of the Item" class="block-square">
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
                                    // PHP Code to Display Categories from Database
                                    // 1. Create SQL to get all active Categories from Database
                                    $sql = "SELECT * FROM tbl_category
                                    WHERE active = 'Yes'";

                                    // Execute the Query
                                    $res = mysqli_query($conn, $sql);

                                    // Count Rows to Check whether we have Categories or Not
                                    $count = mysqli_num_rows($res);

                                    // If count is greater than zero, we have categories else we don't have categories
                                    if($count > 0)
                                    {
                                        // We have Categories
                                        while($row = mysqli_fetch_assoc($res))
                                        {
                                            // Get the Values of the Categories
                                            $id = $row['id'];
                                            $title = $row['title'];
                                            
                                            ?>

                                            <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                            
                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        // We do not have Categories
                                        ?>
                                        <option value="0">No Categories Found</option>
                                        <?php
                                    }

                                    // 2. Display on Dropdown

                                ?>
                            </select>
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
                <input type="submit" name="submit" value="Add Food" class="btn-primary" id="submit">
            
            </form>

            <?php
                // Check whether the Button is Clicked or not
                if(isset($_POST['submit']))
                {
                    // Add the food in the Database

                    // 1. Get the Data from the Form
                    $title = $_POST['title'];
                    $description = $_POST['description'];
                    $price = $_POST['price'];
                    $category = $_POST['category'];

                    // Check whether the Radio Button for Featured and Active is Checked or not
                    if(isset($_POST['featured']))
                    {
                        $featured = $_POST['featured'];
                    }
                    else
                    {
                        // Setting a Default Value
                        $featured = "No";
                    }

                    if(isset($_POST['active']))
                    {
                        $active = $_POST['active'];
                    }
                    else
                    {
                        // Setting a Default Value
                        $active = "No";
                    }

                    // 2. Upload Image if selected
                    // Check whether the Select Image is clicked or Not
                    if(isset($_FILES['image']['name']))
                    {
                        // Get the Details of the Image
                        $image_name = $_FILES['image']['name'];

                        // Upload the Image only if an Image is Selected
                        if($image_name != "")
                        {
                            // Image is selected
                            // A. Rename the Image
                            // Get the Extension of Selected Image
                            $ext = end(explode('.', $image_name));

                            // Create a New Name for the Image
                            $image_name = "Food-Name-".rand(0000,9999).".".$ext;

                            // B. Upload the Image
                            // Get the Source Path and the Destination Path
                            $src = $_FILES['image']['tmp_name'];

                            $dst = "../images/food/".$image_name;

                            // Finally Upload the Image
                            $upload = move_uploaded_file($src, $dst);

                            // Check whether the Image is Uploaded or Not
                            if($upload == FALSE)
                            {
                                // Failed to Upload the Image
                                // Redirect to Add Food Page with Error Message
                                $_SESSION['upload'] = "<div class='error'>Failed to Upload Image</div>";
                                header('location:'.SITEURL.'admin/add-food.php');
                                // Stop the Process
                                die();
                            }
                        }
                    }
                    else
                    {
                        // Setting Default Value as Blank
                        $image_name = "";
                    }

                    // 3. Insert into Database
                    // Create an SQL Query to Save or Add Food
                    $sql2 = "INSERT INTO tbl_food SET
                        title = '$title',
                        description = '$description',
                        price = $price,
                        image_name = '$image_name',
                        category_id = $category,
                        featured = '$featured',
                        active = '$active'
                    ";

                    // Execute the Query
                    $res2 = mysqli_query($conn, $sql2);

                    // 4. Redirect with Message to Manage Food page
                    // Check whether the data is inserted or not
                    if($res2 == TRUE)
                    {
                        // Data Inserted Successfully
                        $_SESSION['add'] = "<div class='success'>Food Added Successfully</div>";
                        header('location:'.SITEURL.'admin/manage-food.php');
                    }
                    else
                    {
                        // Failed to Insert Data
                        $_SESSION['add'] = "<div class='error'>Failed to Add Food</div>";
                        header('location:'.SITEURL.'admin/manage-food.php');
                    }
                }
            ?>

        </div>
    </div>

<?php include('partials/footer.php') ?>