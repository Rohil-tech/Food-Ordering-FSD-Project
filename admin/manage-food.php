<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Food</h1>

        <br>
        
        <?php
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
            
            if(isset($_SESSION['delete']))
            {
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }
            
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
            
            if(isset($_SESSION['unauthorized']))
            {
                echo $_SESSION['unauthorized'];
                unset($_SESSION['unauthorized']);
            }

            if(isset($_SESSION['update']))
            {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
        ?>
        
        <br>
        
        <a href="<?php echo SITEURL; ?>admin/add-food.php" class="btn-primary">Add Food</a>
        <br><br><br>

        <table class="tbl-full">
            <tr>
                <th>S.No.</th>
                <th>Title</th>
                <th>Price</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php
                // Create SQL Query to Get all the Food
                $sql = "SELECT * FROM tbl_food";

                // Execute the Query
                $res = mysqli_query($conn, $sql);

                // Count Rows to Check whether we have Food or Not
                $count = mysqli_num_rows($res);

                // Create a Serial Number Variable and Set the Default Value as 1
                $sn = 1;

                if($count > 0)
                {
                    // We have Food in Database
                    // Get the Food from Database
                    while($row = mysqli_fetch_assoc($res))
                    {
                        // Get the Values from Individual Columns
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $image_name = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];

                        ?>

                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $title; ?></td>
                            <td>Rs. <?php echo $price; ?></td>
                            <td>
                                <?php
                                    // Check whether we have image or not
                                    if($image_name == "")
                                    {
                                        // We do not have Image, Display Error Message
                                        echo "<div class='error'>Image Not Added</div>";
                                    }
                                    else
                                    {
                                        // We have Image, Display Image
                                        ?>
                                        
                                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" width="100px">
                                        
                                        <?php
                                    }
                                ?>
                            </td>
                            <td><?php echo $featured; ?></td>
                            <td><?php echo $active; ?></td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id; ?>" class="btn-sec">Update</a>
                                <a href="<?php echo SITEURL; ?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete</a>
                            </td>
                        </tr>

                        <?php
                    }
                }
                else
                {
                    // Food not Added in Database
                    echo "<tr><td colspan='7' class='error'>Food Not Added Yet</td></tr>";
                }
            ?>
        </table>

    </div>
</div>

<?php include('partials/footer.php'); ?>