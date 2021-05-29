<?php include('partials/menu.php'); ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Update Order</h1>
            
            <br><br>

            <?php
            
                // Check whether ID is Set or Not
                if(isset($_GET['id']))
                {
                    // Get the Order Details
                    $id = $_GET['id'];

                    // Get all Other Details based on this
                    // SQL Query to get Order Details
                    $sql = "SELECT * FROM tbl_order WHERE id = $id";

                    // Execute Query
                    $res = mysqli_query($conn, $sql);

                    // Count Rows
                    $count = mysqli_num_rows($res);

                    if($count == 1)
                    {
                        // Details Available
                        $row = mysqli_fetch_assoc($res);

                        $food = $row['food'];
                        $price = $row['price'];
                        $qty = $row['qty'];
                        $status = $row['status'];
                        $customer_name = $row['customer_name'];
                        $customer_contact = $row['customer_contact'];
                        $customer_email = $row['customer_email'];
                        $customer_address = $row['customer_address'];
                    }
                    else
                    {
                        // Details Not Available
                        // Redirect to Manage Order Page
                        header('location:'.SITEURL.'admin/manage-order.php');
                    }
                }
                else
                {
                    // Redirect to Manage Order Page with Error Message
                    header('location:'.SITEURL.'admin/manage-order.php');
                }

            ?>

            <form action="" method="POST">
                <table class="tbl-30">
                    <tr>
                        <td>Food Name:</td>
                        <td><b><?php echo $food; ?></b></td>
                    </tr>
                    
                    <tr>
                        <td>Price:</td>
                        <td><b>Rs. <?php echo $price; ?></b></td>
                    </tr>
                    
                    <tr>
                        <td><label for="qty">Qty:</label></td>
                        <td>
                            <input type="number" name="qty" id="qty" value="<?php echo $qty?>" class="block-square">
                        </td>
                    </tr>
                    
                    <tr>
                        <td><label for="status">Status:</label></td>
                        <td>
                            <select name="status" id="status" class="block-square">
                                <option <?php if($status == "Ordered") { echo "selected"; } ?> value="Ordered">Ordered</option>
                                <option <?php if($status == "On Delivery") { echo "selected"; } ?> value="On Delivery">On Delivery</option>
                                <option <?php if($status == "Delivered") { echo "selected"; } ?> value="Delivered" >Delivered</option>
                                <option <?php if($status == "Cancelled") { echo "selected"; } ?> value="Cancelled" >Cancelled</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td><label for="customer_name">Customer Name:</label></td>
                        <td>
                            <input type="text" name="customer_name" value="<?php echo $customer_name; ?>" class="block-square">
                        </td>
                    </tr>
                    
                    <tr>
                        <td><label for="customer_contact">Customer Contact:</label></td>
                        <td>
                            <input type="text" name="customer_contact" value="<?php echo $customer_contact; ?>" class="block-square">
                        </td>
                    </tr>
                    
                    <tr>
                        <td><label for="customer_email">Customer Email:</label></td>
                        <td>
                            <input type="text" name="customer_email" value="<?php echo $customer_email; ?>" class="block-square">
                        </td>
                    </tr>
                    
                    <tr>
                        <td><label for="customer_address">Customer Address:</label></td>
                        <td>
                            <textarea name="customer_address" id="customer_address" cols="30" rows="5" class="block-square"><?php echo $customer_address; ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="hidden" name="price" value="<?php echo $price; ?>">
                        </td>
                    </tr>
                </table>

                <br>
                <input type="submit" name="submit" value="Update Order" class="btn-primary" id="submit">

            </form>

            <?php
                // Check whether Update Button is Clicked or Not
                if(isset($_POST['submit']))
                {
                    // Get All the Values from the Form
                    $id = $_POST['id'];
                    $price = $_POST['price'];
                    $qty = $_POST['qty'];
                    $total = $price * $qty;
                    $status = $_POST['status'];
                    $customer_name = $_POST['customer_name'];
                    $customer_contact = $_POST['customer_contact'];
                    $customer_email = $_POST['customer_email'];
                    $customer_address = $_POST['customer_address'];

                    // Update the Values
                    $sql2 = "UPDATE tbl_order SET
                        qty = $qty,
                        total = $total,
                        status = '$status',
                        customer_name = '$customer_name',
                        customer_contact = '$customer_contact',
                        customer_email = '$customer_email',
                        customer_address = '$customer_address'
                        WHERE id = $id
                    ";

                    // Execute the Query
                    $res2 = mysqli_query($conn, $sql2);

                    // Check whether Values Updated Successfully or Not
                    // Redirect to Manage Order with Message
                    if($res2 == TRUE)
                    {
                        // Updated Successfuly
                        $_SESSION['update'] = "<div class='success'>Order Updated Successfully</div>";
                        header('location:'.SITEURL.'admin/manage-order.php');
                    }
                    else
                    {
                        // Failed to Update
                        $_SESSION['update'] = "<div class='error'>Failed to Update Order</div>";
                        header('location:'.SITEURL.'admin/manage-order.php');
                    }
                }
            ?>

        </div>
    </div>

<?php include('partials/footer.php'); ?>