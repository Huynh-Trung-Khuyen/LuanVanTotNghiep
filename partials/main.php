   <div class="bg-image border p-3 mb-3">
       <div class="row">
       <?php foreach ($products as $row)  : ?>
           <div class="col-sm-3 mb-3">
               <div class="card">
                   <div class="card-body">
                   <a href="product_detail/product_detail.php?id=<?php echo $row['product_id']?>">
                        <img src="../public/uploads/<?php echo $row['image'] ?>" width="230px" height="230px">
                        </a>
                    </div>
                    <div class="card-body">
                        <a href="../" class="text-reset text-decoration-none">
                            <h4 class="card-title mb-3"><?php echo $row['product_name'] ?></h4>
                        </a>
                        <h6 class="mb-3"><?php echo $row['price'] ?>.000vnđ</h6>
                   </div>
               </div>
           </div>
           <?php endforeach ?> 
       </div>
   </div>