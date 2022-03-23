<?php
include_once 'helpers/functions.php';

if (isset($_POST) && !empty($_POST)) {
    registerUser($_POST);
}

header("Location: /task_11.php");
