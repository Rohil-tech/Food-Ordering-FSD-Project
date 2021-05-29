<?php include('partials-front/menu.php'); ?>

    <!-- Food Search Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food" required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>
        
        </div>
    </section>
    <!-- Food Search Section Ends Here -->

    <?php
        if(isset($_SESSION['order']))
        {
            echo $_SESSION['order'];
            unset($_SESSION['order']);
        }
    ?>

    <!-- Categories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>
            
            <?php
                // Create SQL Query to Display Categories from Database
                $sql = "SELECT * FROM tbl_category
                    WHERE active = 'Yes' AND featured = 'Yes'
                    LIMIT 3;
                ";
                // Execute the Query
                $res = mysqli_query($conn, $sql);

                // Count the Rows to Check whether the Category is Available or Not
                $count = mysqli_num_rows($res);

                if($count > 0)
                {
                    // Categories Available
                    while($row = mysqli_fetch_assoc($res))
                    {
                        // Get the Values from the Database
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        
                        ?>

                        <a href="<?php echo SITEURL?>category-foods.php?category_id=<?php echo $id; ?>">
                            <div class="box-3 float-container">
                                <?php
                                    // Check whether Image is Available or Not
                                    if($image_name == "")
                                    {
                                        // Display Message
                                        echo "<div class='error'>Image Not Available</div>";
                                    }
                                    else
                                    {
                                        // Image Available
                                        ?>

                                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" class="img-responsive img-curve">

                                        <?php
                                    }
                                ?>

                                <h3 class="float-text text-white"><?php echo $title; ?></h3>
                            </div>
                        </a>

                        <?php
                    
                    }
                }
                else
                {
                    // Categories Not Available
                    echo "<div class='error'>Category Not Added</div>";
                }
            ?>
            
            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

    <!-- Food Menu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php

                // Getting Food from the Database that are Active and Featured
                $sql2 = "SELECT * FROM tbl_food
                    WHERE active = 'Yes' AND featured = 'Yes' LIMIT 6
                ";

                // Execute the Query
                $res2 = mysqli_query($conn, $sql2);

                // Count Rows
                $count2 = mysqli_num_rows($res2);

                // Check whether the Food is Available or Not
                if($count2 > 0)
                {
                    // Food Available
                    while($row2 = mysqli_fetch_assoc($res2))
                    {
                        // Get all the Values
                        $id = $row2['id'];
                        $title = $row2['title'];
                        $description = $row2['description'];
                        $price = $row2['price'];
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

                                        <img src="<?php echo SITEURL; ?>/images/food/<?php echo $image_name; ?>" class="img-responsive img-curve">
                                        
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
                    // Food Not Available
                    echo "<div class='error'>Food Not Available</div>";
                }

            ?>
            
            <div class="clearfix"></div>
        </div>

        <p class="text-center">
            <a href="#">See All Foods</a>
        </p>
    </section>
    <!-- Food Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>