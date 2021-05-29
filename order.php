<?php include('partials-front/menu.php'); ?>

    <?php
        // Check whether the Food ID is Set or Not
        if(isset($_GET['food_id']))
        {
            // Get the Food ID and Details of the Selected Food
            $food_id = $_GET['food_id'];

            // Get the Deatils of the Selected Food
            $sql = "SELECT * FROM tbl_food WHERE id = $food_id";

            // Execute the Query
            $res = mysqli_query($conn, $sql);

            // Count the Rows
            $count = mysqli_num_rows($res);
            
            // Check whether the Data is Available or Not
            if($count == 1)
            {
                // Food Available
                $row = mysqli_fetch_assoc($res);

                $title = $row['title'];
                $price = $row['price'];
                $image_name = $row['image_name'];

            }
            else
            {
                // Food Not Available
                // Redirect to Home Page
                header('location:'.SITEURL);
            }
        }
        else
        {
            // Redirect to Home Page
            header('location:'.SITEURL);
        }
    ?>

    <!-- Food Search Section Starts Here -->
    <section class="food-search">
        <div class="container">

            <h2 class="text-center text-white">Fill this form to confirm your order</h2>

            <form action="" class="order" method="POST">
                <fieldset>
                    <legend>Selected Food</legend>

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
                        <h3><?php echo $title; ?></h3>
                        <input type="hidden" name="food" value="<?php echo $title; ?>">

                        <p class="food-price">Rs. <?php echo $price; ?></p>
                        <input type="hidden" name="price" value="<?php echo $price; ?>">

                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>

                    </div>

                </fieldset>

                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="E.g. Rohit Mehra" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. 98xxxxxx98" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. someone@example.com" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>

            <?php

                // Check whether the Submit Button is Clicked or Not
                if(isset($_POST['submit']))
                {
                    // Get all the Details from the Form
                    $food = $_POST['food'];
                    $price = $_POST['price'];
                    $qty = $_POST['qty'];
                    
                    // Total = Price x Quantity
                    $total = $price * $qty;

                    // Order Date
                    $order_date = date("Y-m-d h:i:sa");

                    // Ordered, On Delivery, Delivered, Cancelled
                    $status = "Ordered";

                    $customer_name = $_POST['full-name'];
                    $customer_contact = $_POST['contact'];
                    $customer_email = $_POST['email'];
                    $customer_address = $_POST['address'];

                    // Set the Order in Database
                    // Create SQL to save the Data
                    $sql2 = "INSERT INTO tbl_order SET
                        food = '$food',
                        price = $price,
                        qty = $qty,
                        total = $total,
                        order_date = '$order_date',
                        status = '$status',
                        customer_name = '$customer_name',
                        customer_contact = '$customer_contact',
                        customer_email = '$customer_email',
                        customer_address = '$customer_address'
                    ";

                    // Execute the Query
                    $res2 = mysqli_query($conn, $sql2);

                    // Check whether Query Executed Successfully or Not
                    if($res2 == TRUE)
                    {
                        // Query Executed and Order Saved
                        $_SESSION['order'] = "<div class='success text-center'>Your Order is Placed</div>";
                        header('location:'.SITEURL);
                    }
                    else
                    {
                        // Failed to Save Order
                        $_SESSION['order'] = "<div class='error text-center'>Failed to Place the Order</div>";
                        header('location:'.SITEURL);
                    }
                }
            
            ?>

        </div>
    </section>
    <!-- Food Search Section Ends Here -->

<?php include('partials-front/footer.php'); ?>