<?php

require_once "Database.php";

class User extends Database {

    public function login($request){
        $username = $request['username'];
        $password = $request['password'];

        $sql = "SELECT * FROM users WHERE `username` = '$username'";
        $result = $this->conn->query($sql);

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc(); // Fetch user data
            
            // Verify the hashed password
            if (password_verify($password, $user['password'])) {
                session_start();
                // Store user info in session
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                $sql = "UPDATE `users` SET `online` = 1 WHERE `user_id` = " . $user['user_id'];

                if($this->conn->query($sql)){

                    // Redirect based on role
                    if ($user['role'] == 'A') {
                        header('Location: ../../views/shared/dashboard.php');
                    } else if ($user['role'] == 'M'){
                        header('Location: ../../views/shared/dashboard.php'); // Adjust for other roles
                    } else{
                        header('Location: ../../views/employee/activity.php');
                    }
                    exit;
                }else{
                    die("Error setting user status to online. " . $this->conn->error);
                }
            } else {
                echo "Invalid password!";
            }
        } else {
            echo "User not found!";
        }
    }

    public function logout(){
        $user_id = $_SESSION['user_id'];
        $sql = "UPDATE `users` SET `online` = 1 WHERE `user_id` = $user_id";

        if($this->conn->query($sql)){

            session_unset();
            session_abort();
            session_destroy();
            
            header('Location: ../../views/employee/activity.php');
            exit;
        }else{
            die("Error setting user status to online. " . $this->conn->error);
        }
    }

   
}

?>