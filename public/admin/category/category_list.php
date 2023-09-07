<?php
$itemsPerPage = 10; 
$totalItems = count($categories); 
$totalPages = ceil($totalItems / $itemsPerPage); 

$currentpage = isset($_GET['page']) ? $_GET['page'] : 1;

$start = ($currentpage - 1) * $itemsPerPage; 
$end = $start + $itemsPerPage; 
if (!empty($categories)) {
    echo '<table class="table">';
    echo '<thead>';
    echo '<tr>';
    echo '<th style="width: 100px">ID</th>';
    echo '<th style="width: 200px">Tên Sản Phẩm</th>';
    echo '<th style="width: 100px">&nbsp;</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    for ($i = $start; $i < $end && $i < $totalItems; $i++) {
        $row = $categories[$i];
        echo '<tr>';
        echo '<td>' . $row['category_id']  .'</td>';
        echo '<td>' . $row['category_name']  .'</td>';
        echo '<td>';
        echo '<a class="btn btn-primary btn-sm" href="../../admin/category/edit.php?id=' . $row['category_id'] . '"><i class="fas fa-edit"></i></a>';
        echo '<a class="btn btn-danger btn-sm" href="../../admin/category/delete.php?id=' . $row['category_id'] . '"><i class="fas fa-trash"></i></a>';
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
}
?>
