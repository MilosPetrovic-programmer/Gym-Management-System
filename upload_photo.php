<?php

$photo = $_FILES['photo'];

$photo_name = basename($photo['name']);

$photo_path = 'member_photos/' . $photo_name;

# checking extensions of pictures
$allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

$ext = pathinfo($photo_name, PATHINFO_EXTENSION);

if(in_array($ext, $allowed_ext) && $photo['size'] < 200000) {
    move_uploaded_file($photo['tmp_name'], $photo_path);
    # returning the message to js
    echo json_encode(['success' => true, 'photo_path' => $photo_path]);
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid file']);
}
 
?>