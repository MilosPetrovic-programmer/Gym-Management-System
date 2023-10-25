<?php
#connection to base
require_once 'config.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $member_id = $_POST['member'];
    $trainer_id = $_POST['trainer'];

    $sql = "UPDATE members SET trainer_id = ? WHERE member_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $trainer_id, $member_id);

    $stmt->execute();

    # Set a session variable with a success message
    $_SESSION['success_message'] = 'Trainer is succesfuly assigned';

    # Redirect to the admin_dasboard page
    header("Location: admin_dashboard.php");
    exit();
}
?>