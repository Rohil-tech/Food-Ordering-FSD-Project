<?php include('partials-front/menu.php'); ?>

<?php
    // Check whether the ID is Passed or Not
    if(isset($_GET['category_id']))
    {
        // Category ID is Set and Get the ID
        $category_id = $_GET['category_id'];
        // Get Other Details of the Category Based on its ID
        $sql = "SELECT title FROM tbl_category WHERE id = $category_id";

        // Execute the Query
        $res = mysqli_query($conn, $sql);

        // Get the Value from the Database
        $row = mysqli_fetch_assoc($res);

        // Get the title
        $category_title = $row['title'];
    }
    else
    {
        // Category not Passed
        // Redirect to Home Page
        header('location:'.SITEURL);
    }
?>

    <!-- Food Search Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">

            <h2>Foods on <a href="#" class="text-white">"<?php echo $category_title; ?>"</a></h2>

        </div>
    </section>
    <!-- Food Search Section Ends Here -->

    <!-- Food Menu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php

                // Create SQL Query to get Food Based on Selected Query
                $sql2 = "SELECT * FROM tbl_food WHERE category_id = $category_id";

                // Execute the Query
                $res2 = mysqli_query($conn, $sql2);

                // Get the Value from the Database
                $count2 = mysqli_num_rows($res2);

                // Check whether Food is Available or Not
                if($count2 > 0)
                {
                    // Food is Available
                    while($row2 = mysqli_fetch_assoc($res2))
                    {
                        $id = $row2['id'];
                        $title = $row2['title'];
                        $price = $row2['price'];
                        $description = $row2['description'];
                        $image_name = $row2['image_name'];
                        
                        ?>

                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php
                                    // Check whether the Image is Available or Not
                                    if($image_name == "")
                                    {
                                        // Image Not Available
                                        echo "<div class='error'>Image Not Available</div>";
                                    }
                                    else
                                    {
                                        // Image Available
                                        ?>

                                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" class="img-responsive img-curve">

                                        <?php
                                    }
                                ?>

                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $title; ?></h4>
                                <p class="food-price">Rs. <?php echo $price; ?></p>
                                <p class="food-detail"><?php echo $description; ?></p>
                                <br>

                                <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                            </div>
                        </div>

                        <?php
                    }
                }
                else
                {
                    // Food is Not Available
                    echo "<div class='error'>Food Not Available</div>";
                }

            ?>            

            <div class="clearfix"></div>

        </div>

    </section>
    <!-- Food Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>