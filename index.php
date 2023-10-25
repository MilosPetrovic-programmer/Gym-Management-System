<?php

#connection to base
require_once 'config.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $username = $_POST['username'];
    $password = $_POST['password'];

    #take from base
    $sql = "SELECT admin_id, password FROM admins WHERE username = ?";
    
    #mysqli and pdo (can work with other databases) database management methods
    $run = $conn ->prepare($sql);
    $run->bind_param("s", $username);
    $run->execute();
    $results = $run->get_result();
    if($results->num_rows == 1){
        
        #associative array - label and value go instead of index
        $admin = $results->fetch_assoc();

        if(password_verify($password, $admin['password'])){
            $_SESSION['admin_id'] = $admin['admin_id'];
            $conn->close();
            header('location: admin_dashboard.php');
        } else {
            $_SESSION['error'] = "Netacan password!";
            $conn->close();
            exit;
            #redirection
            header('location: index.php');
        }

    } else {
        $_SESSION['error'] = "Netacan username!";
        $conn->close();
        header('location: index.php');
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>
<body>
    

    <?php
    
    # checking whether the session error is set and destroying it
    if(isset($_SESSION['error'])) {
        echo $_SESSION['error'] . "<br>";
        unset($_SESSION['error']);
    }

    ?>


    <form action="" method="POST">
        Username: <input type="text" name="username"><br>
        Password: <input type="password" name="password"><br>
        <input type="submit" value="login"><br>
    </form>

</body>
</html>