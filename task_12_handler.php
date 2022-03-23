<?php

session_start();

function setFlashMessage($name, $message) {
    $_SESSION[$name] = $message;
}

if (isset($_POST["text"]) && !empty($_POST["text"])) {
    setFlashMessage("text", $_POST["text"]);
}

header("Location: /task_12.php");
