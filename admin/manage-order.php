<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Order</h1>

        <br>
        
        <?php
            if(isset($_SESSION['update']))
            {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
        ?>
        
        <br>

        <table class="tbl-full">
            <tr>
                <th>S.No.</th>
                <th>Food</th>
                <th>Price</th>
                <th>Qty.</th>
                <th>Total</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Customer Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>

            <?php 
                // Get all the Orders from Database
                $sql = "SELECT * FROM tbl_order ORDER BY id DESC";
                // Display Latest Order at the Top

                // Execute the Query
                $res = mysqli_query($conn, $sql);

                // Count the Rows
                $count = mysqli_num_rows($res);

                // Create Serial Number And set its Value as 1
                $sn = 1;

                if($count > 0)
                {
                    // Order Available
                    while($row = mysqli_fetch_assoc($res))
                    {
                        // Get All the Order Details
                        $id = $row['id'];
                        $food = $row['food'];
                        $price = $row['price'];
                        $qty = $row['qty'];
                        $total = $row['total'];
                        $order_date = $row['order_date'];
                        $status = $row['status'];
                        $customer_name = $row['customer_name'];
                        $customer_contact = $row['customer_contact'];
                        $customer_email = $row['customer_email'];
                        $customer_address = $row['customer_address'];

                        ?>

                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $food; ?></td>
                            <td><?php echo $price; ?></td>
                            <td><?php echo $qty; ?></td>
                            <td><?php echo $total; ?></td>
                            <td><?php echo $order_date; ?></td>

                            <td>
                                <?php
                                    // Ordered, On Delivery, Delivered, Cancelled
                                    if($status == "Ordered")
                                    { echo "<label>$status</label>"; }
                                    else if($status == "On Delivery")
                                    { echo "<label style='color: #1e90ff;'>$status</label>"; }
                                    else if($status == "Delivered")
                                    { echo "<label style='color: #2ed573;'>$status</label>"; }
                                    else if($status == "Cancelled")
                                    { echo "<label style='color: #ff4757;'>$status</label>"; }
                                    
                                ?>
                            </td>
                            
                            <td><?php echo $customer_name; ?></td>
                            <td><?php echo $customer_contact; ?></td>
                            <td><?php echo $customer_email; ?></td>
                            <td><?php echo $customer_address; ?></td>
                            <td>
                                <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id; ?>" class="btn-sec">Update</a>
                            </td>
                        </tr>

                        <?php
                    }
                }
                else
                {
                    // Order Not Available
                    echo "<tr><td colspan='12' class='error'>Orders Not Available</td></tr>";
                }
            ?>

        </table>

    </div>
</div>

<?php include('partials/footer.php'); ?>