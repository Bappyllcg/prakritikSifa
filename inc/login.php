<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        # Sender Data
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);
		
        if (empty($username)) {
            # Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Username Requered!";
            exit;
        }elseif (empty($password)) {
            # Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Password Requered!";
            exit;
        }else {
            //-----
            require_once('./db.php');
            $sql = "SELECT * FROM users WHERE username='$username'";
            $query = $conn->query($sql);
            $data = mysqli_fetch_assoc($query);

            if(mysqli_num_rows($query) == 0){
                # Set a 400 (bad request) response code and exit.
                http_response_code(400);
                echo "Username Wrong!";
                exit;
            }else {
                $data_pass = $data['password'];
                $now_pass = md5($password);

                if($now_pass == $data_pass ){
                    session_start();
                    $_SESSION['login'] = $data['id'];
                    # Set a 200 response code and exit.
                    http_response_code(200);
                    header('Content-Type: application/json');
                    echo json_encode(['location'=>'dashboard.php', 'quote'=>'Login Success!']);
                }else {
                    # Set a 400 (bad request) response code and exit.
                    http_response_code(400);
                    echo "Wrong Password!";
                    exit;
                }
            }
            //--------------
        }

    } else {
        # Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "There was a problem with your submission, please try again.";
    }
?>