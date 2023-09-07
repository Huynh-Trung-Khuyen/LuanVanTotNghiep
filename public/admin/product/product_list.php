<?php

$itemsPerPage = 10;


$totalItems = count($products);


$totalPages = ceil($totalItems / $itemsPerPage);


$currentpage = isset($_GET['page']) ? $_GET['page'] : 1;


$start = ($currentpage - 1) * $itemsPerPage;
$end = $start + $itemsPerPage;


echo '<table class="table">';
echo '<thead>';
echo '<tr>';
echo '<th style="width: 100px">ID</th>';
echo '<th style="width: 200px">Tên Sản Phẩm</th>';
echo '<th style="width: 200px">Ảnh</th>';
echo '<th style="width: 200px">Giá</th>';
echo '<th>Nội Dung</th>';
echo '<th style="width: 100px">&nbsp;</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

for ($i = $start; $i < $end && $i < $totalItems; $i++) {
    $row = $products[$i];
    echo '<tr>';
    echo '<td>' . $row['product_id'] . '</td>';
    echo '<td>' . $row['product_name'] . '</td>';
    echo '<td><a href="" target="_blank"><img src="../../uploads/' . $row['image'] . '" height="100px" width="100px"></a></td>';
    echo '<td>' . $row['price'] . '.000vnđ/Kg</td>';
    echo '<td>' . $row['content'] . '</td>';
    echo '<td>';
    echo '<a class="btn btn-primary btn-sm" href="../../admin/product/edit.php?id=' . $row['product_id'] . '"><i class="fas fa-edit"></i></a>';
    echo '<a class="btn btn-danger btn-sm" href="../../admin/product/delete.php?id=' . $row['product_id'] . '"><i class="fas fa-trash"></i></a>';
    echo '</td>';
    echo '</tr>';
}

echo '</tbody>';
echo '</table>';

echo '<ul class="pagination">';
for ($page = 1; $page <= $totalPages; $page++) {
    echo '<li class="page-item' . ($page == $currentpage ? ' active' : '') . '">';
    echo '<a class="page-link" href="?page=' . $page . '">' . $page . '</a>';
    echo '</li>';
}
echo '</ul>';
?>
