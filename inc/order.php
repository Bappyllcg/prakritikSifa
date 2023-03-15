<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        # Sender Data
        $name = trim($_POST["name"]);
        $address = trim($_POST["address"]);
        $phone = trim($_POST["phone"]);
		
        if (empty($name)) {
            # Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Name Requered!";
            exit;
        }elseif (empty($address)) {
            # Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Address Requered!";
            exit;
        }elseif (empty($phone)) {
            # Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Phone Requered!";
            exit;
        }else {
            //-----
            require_once('./db.php');
            $today = date('d-m-Y');
            $sql = "INSERT INTO `orders` (`id`, `name`, `address`, `mobile`, `status`, `date`) VALUES (NULL, '$name', '$address', '$phone', 'Pending', '$today');";
            $query = $conn->query($sql);

            if($query){
                # Set a 200 response code and exit.
                http_response_code(200);
                header('Content-Type: application/json');
                echo json_encode(['quote'=>'Order Placed!', 'order'=> 'done']);
                
            }else {
                # Set a 400 (bad request) response code and exit.
                http_response_code(400);
                echo "Something Went Wrong!";
                exit;
            }
            //--------------
        }

    } else {
        # Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "There was a problem with your submission, please try again.";
    }
?>