<?php
include_once 'helpers/functions.php';

if (isset($_POST) && !empty($_POST)) {
    login($_POST);
}

if (logged_in()) {
    header("Location: /task_14_1.php");
}

header("Location: /task_14.php");
