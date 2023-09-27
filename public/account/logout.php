<?php
session_start();

session_destroy();

header('location:../index/index.php');

