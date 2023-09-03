<header class="d-flex  align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
    <a href="../index.php" class="d-flex align-items-center col-md-0  mb-md-0 text-dark text-decoration-none">
        <img style="width: 130px; height: auto;" src="../img/logo.png" alt="">
    </a>

    <form class="col-12 col-lg-7 mb-lg-0 ">
        <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
    </form>


    <?php
    if (!isset($_SESSION['user'])) : ?>

        <div class="text-end">
            <a class="btn btn-outline-success me-2" href="../public/account/login.php" role="button">Login</a>
            <a class="btn btn-success" href="../public/account/register.php" role="button">Sign-up</a>
        </div>

    <?php endif ?>

    <?php
    if (isset($_SESSION['user'])) : ?>

    
    <a class="btn btn-outline-success me-2 dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 160px;">
        <?php
        echo $_SESSION['user']['name']
        ?>
    </a>
    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
        <li><a class="dropdown-item text-center" href="../public/account/logout.php">Thoát</a></li>
    </ul>
    <?php endif ?>



    <a href="">
        <button type="button" class="btn btn-success"><span class="bi bi-cart"></span></button>
    </a>

</header>