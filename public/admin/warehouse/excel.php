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


    $reader->next(); 
    foreach ($reader as $key => $row) {
        $imported_product_name = $row[0];
        $quantity = $row[1];
        $input_day = $row[2];
        $expired_date = $row[3];
        $supplier_id = $row[4];
        $seri_number = $row[5];

        if (
            !empty($imported_product_name) &&
            !empty($quantity) &&
            strtotime($input_day) !== false && strtotime($expired_date) !== false &&
            !empty($supplier_id) &&
            !empty($seri_number)
        ) {
            $stmt = $conn->prepare("
                INSERT INTO warehouse 
                (imported_product_name, quantity, input_day, expired_date, supplier_id, seri_number)
                VALUES (:imported_product_name, :quantity, :input_day, :expired_date, :supplier_id, :seri_number)
            ");

            $stmt->bindParam(':imported_product_name', $imported_product_name);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':input_day', $input_day);
            $stmt->bindParam(':expired_date', $expired_date);
            $stmt->bindParam(':supplier_id', $supplier_id);
            $stmt->bindParam(':seri_number', $seri_number);
            $stmt->execute();
        }
    }

    echo "
    <script>
    alert('Succesfully Imported');
    document.location.href = '';
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