<?php
//var_dump($_GET);
include_once 'helpers/functions.php';
if (removeImages($_GET['id'])) {
    unlink($_GET['image']);
}



header("Location: /task_15.php");
