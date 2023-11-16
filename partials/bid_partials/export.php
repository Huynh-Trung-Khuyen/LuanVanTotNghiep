<?php
session_start();
require_once '../../config.php';
require_once '../../vendor/autoload.php';

if (!isset($_SESSION['user_id'])) {
    exit('Bạn cần đăng nhập để thực hiện hành động này.');
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT 
            pb.product_bid_id, 
            pb.product_bid_name, 
            pb.product_bid_description, 
            pb.current_price,
            u.fullname AS winner_fullname,
            b.city_address,
            b.district_address,
            b.address AS business_address,
            b.phone AS business_phone,
            b.email_address AS business_email
        FROM product_bid pb
        LEFT JOIN user u ON pb.winner_id = u.user_id
        LEFT JOIN business b ON u.user_id = b.user_id
        WHERE pb.winner_id = :user_id AND pb.is_active = 3";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$wonProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!empty($wonProducts)) {
    $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'Tên Phiên');
    $sheet->setCellValue('B1', 'Số Tiền Cần Thanh Toán');
    $sheet->setCellValue('C1', 'Trạng Thái');
    $sheet->setCellValue('D1', 'Người Thắng Phiên');
    $sheet->setCellValue('E1', 'Địa Chỉ Thành Phố');
    $sheet->setCellValue('F1', 'Địa Chỉ Quận');
    $sheet->setCellValue('G1', 'Địa Chỉ Doanh Nghiệp');
    $sheet->setCellValue('H1', 'Số Điện Thoại Doanh Nghiệp');
    $sheet->setCellValue('I1', 'Email Doanh Nghiệp');

    $row = 2;
    foreach ($wonProducts as $product) {
        $sheet->setCellValue('A' . $row, $product['product_bid_name']);
        $sheet->setCellValue('B' . $row, number_format($product['current_price'], 0, ',', '.') . ' vnđ');
        $sheet->setCellValue('C' . $row, 'Đã Giao Hàng');
        $sheet->setCellValue('D' . $row, $product['winner_fullname']);
        $sheet->setCellValue('E' . $row, $product['city_address']);
        $sheet->setCellValue('F' . $row, $product['district_address']);
        $sheet->setCellValue('G' . $row, $product['business_address']);
        $sheet->setCellValue('H' . $row, $product['business_phone']);
        $sheet->setCellValue('I' . $row, $product['business_email']);
        $row++;
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Hóa_Đơn.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $writer->save('php://output');
    exit();
} else {
    echo '<p>Bạn chưa thêm sản phẩm nào.</p>';
}
?>
