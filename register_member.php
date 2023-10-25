<?php

require_once 'config.php';
require_once 'fpdf/fpdf.php';

if($_SERVER['REQUEST_METHOD'] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $training_plan_id = $_POST['training_plan_id'];
    $trainer_id = 0;
    $photo_path = $_POST['photo_path'];
    $access_card_pdf = " ";

    $sql = "INSERT INTO members (fist_name, last_name, email, phone_number, photo_path, training_plan_id, trainer_id, access_card_pdf_path)
    VALUES(?, ?, ?, ?, ?, ?, ?, ?)";

    $run = $conn->prepare($sql);
    $run->bind_param("sssssiis", $first_name, $last_name, $email, $phone_number, $photo_path, $training_plan_id, $trainer_id, $access_card_pdf);
    $run->execute();

    $member_id = $conn->insert_id;
    # pdf file using FPDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    # where is going to be 
    $pdf->Cell(40, 10, 'Access Card');
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Member ID: ' . $member_id);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Name: ' . $first_name . " " . $last_name);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Email: ' . $email);
    $pdf->Ln();

    $filename = 'access_cards/access_card_' . $member_id . '.pdf';
    $pdf->Output('F', $filename);
    # inserting into the base
    $sql = "UPDATE members SET access_card_pdf_path = '$filename' WHERE member_id = $member_id";
    $conn->query($sql);
    $conn->close();
    # setting session
    $_SESSION['success_message'] = 'Clan teretane uspesno dodat';
    header('location: admin_dashboard.php');
    exit();
}




?>