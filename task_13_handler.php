<?php


session_start();

function setCounter($key, $count) {
    $_SESSION[$key] = $_SESSION[$key] ? $_SESSION[$key] + $count : 0 + $count;
}

if (isset($_POST["counter"]) && !empty($_POST["counter"])) {
    setCounter("counter", $_POST["counter"]);
}

header("Location: /task_13.php");
