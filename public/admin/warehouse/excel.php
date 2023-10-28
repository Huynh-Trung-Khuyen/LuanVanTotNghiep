<?php
session_start();

require_once '../../../config.php';

if (isset($_POST["import"])) {
    $fileName = $_FILES["excel"]["name"];
    $fileExtension = explode('.', $fileName);
    $fileExtension = strtolower(end($fileExtension));
    $newFileName = date("Y.m.d") . " - " . date("h.i.sa") . "." . $fileExtension;

    $targetDirectory = "uploads/" . $newFileName;
    move_uploaded_file($_FILES['excel']['tmp_name'], $targetDirectory);

    error_reporting(0);
    ini_set('display_errors', 0);

    require 'excelReader/excel_reader2.php';
    require 'excelReader/SpreadsheetReader.php';

    $reader = new SpreadsheetReader($targetDirectory);
    $reader->next(); //Code này bỏ qua dòng tiêu đề

    foreach ($reader as $key => $row) {
        $imported_product_name = $row[1]; // Sử dụng chỉ mục cột 1 (cột "Tên SP") để lấy tên sản phẩm
        $quantity = $row[2];
        $purchase_price = $row[3];
        $input_day = $row[4];
        $expired_date = $row[5];
        $supplier_id = $row[6];
        $seri_number = $row[7];

        if (
            !empty($imported_product_name) &&
            !empty($quantity) &&
            strtotime($input_day) !== false && strtotime($expired_date) !== false &&
            !empty($supplier_id) &&
            !empty($seri_number)
        ) {
            $stmt = $conn->prepare("
                INSERT INTO warehouse 
                (imported_product_name, quantity, input_day, expired_date, supplier_id, seri_number, purchase_price)
                VALUES (:imported_product_name, :quantity, :input_day, :expired_date, :supplier_id, :seri_number, :purchase_price)
            ");

            $stmt->bindParam(':imported_product_name', $imported_product_name);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':input_day', $input_day);
            $stmt->bindParam(':expired_date', $expired_date);
            $stmt->bindParam(':supplier_id', $supplier_id);
            $stmt->bindParam(':seri_number', $seri_number);
            $stmt->bindParam(':purchase_price', $purchase_price);
            $stmt->execute();
        }
    }

    echo "
    <script>
    alert('Successfully Imported');
    document.location.href = 'excel.php';
    </script>
    ";
}
?> 

<!DOCTYPE html>
<html lang="en">
<?php
include("../include/head.php");
?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php
        include("../include/sidebar.php");
        ?>
        </aside>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Thêm Sản Phẩm Vào Kho Bằng File Excel</h1>
                        </div>
                    </div>
                </div>
            </div>
            <form class="" action="" method="post" enctype="multipart/form-data">
                <input type="file" name="excel" required>
                <button type="submit" name="import" class="btn btn-primary">Thêm Sản Phẩm</button>
            </form>
        </div>
    </div>
    <!-- ./wrapper -->
</body>
<?php
include("../include/footer.php");
?>

</html>
