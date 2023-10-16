<?php
session_start();

require_once '../../../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $user_id = $_POST['user_id'];
    $city_address = $_POST['city_address'];
    $district_address = $_POST['district_address'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email_address = $_POST['email_address'];
    $tax_code = $_POST['tax_code']; 

    $sql = "INSERT INTO business (user_id, city_address, district_address, address, phone, email_address, tax_code) 
            VALUES (:user_id, :city_address, :district_address, :address, :phone, :email_address, :tax_code)"; 
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':city_address', $city_address);
    $stmt->bindParam(':district_address', $district_address);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':email_address', $email_address);
    $stmt->bindParam(':tax_code', $tax_code); 

    $stmt->execute();
    header('Location: ./index_business.php');
    exit();

} else {
    echo "Trang này chỉ có thể truy cập qua biểu mẫu.";
}
?>
