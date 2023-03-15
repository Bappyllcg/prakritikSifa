<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        # Sender Data
        $ststus = trim($_POST["ststus"]);
        $order_id = trim($_POST["order_id"]);
		
        if(empty($ststus) OR empty($order_id)) {
            header("location:./../dashboard.php");
        }else {
            //-----
            require_once('./db.php');
            $sql = "SELECT * FROM orders WHERE id='$order_id'";
            $query = $conn->query($sql);
            $data = mysqli_fetch_assoc($query);

            if(mysqli_num_rows($query) == 0){
                header("location:./../dashboard.php");
            }else {
                $update_sql = "UPDATE `orders` SET `status` = '$ststus' WHERE `orders`.`id` = '$order_id'";
                $update_query = $conn->query($update_sql);
                header("location:./../dashboard.php");
            }
            //--------------
        }

    } else {
        header("location:./../login.html");
    }
?>