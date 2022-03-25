<?php
session_start();
define('HOST', 'http://' . $_SERVER['HTTP_HOST']);

const DB_HOST = 'localhost';
const DB_NAME = 'users';
const DB_USER = 'root';
const DB_PASS = 'root';

function dbConnect() {

    $pdoOptions = [
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];

    static $connect = null;

    if ($connect === null) {

        try {
            $connect = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS, $pdoOptions);
        } catch (PDOException $e) {
            die($e->getMessage());

        }
    }

    return $connect;
}

function dbQuery($sql, $params = [], $exec = false) {
    if (empty($sql)) return false;

    $query = dbConnect()->prepare($sql);
    $query->execute($params);
    if ($exec) {
        return true;
    }
    return $query;
}

function setFlashMessage($name, $message) {
    $_SESSION[$name] = $message;
}

function displayFlashMessage($name) {
    if (isset($_SESSION[$name]) && !empty($_SESSION[$name])) {
        echo $_SESSION[$name];
        unset($_SESSION[$name]);
        return true;
    }

    return false;
}

function getUserInfo($name) {
    $params = ['email' => $name];
    $sql = "SELECT * FROM `users_bd` WHERE `email` = :email";
    return dbQuery($sql, $params)->fetch();
}

function addUser($email, $pass) {
    $params = [
        'email' => $email,
        'pass' => password_hash($pass, PASSWORD_DEFAULT),
    ];
    $sql = "INSERT INTO `users_bd` (`email`, `password`) VALUES (:email, :pass);";
    return dbQuery($sql, $params, true);
}

function registerUser($authData) {
    if (empty($authData) ||
        !isset($authData['email']) || empty(trim($authData['email'])) ||
        !isset($authData['pass']) || empty(trim($authData['pass']))) return false;


    $user = getUserInfo($authData['email']);
    if (!empty($user)) {
        setFlashMessage("errorRegister", "Пользователь " . $authData['email'] . " уже существует");
        header('Location: /task_11.php');
        return false;
    }

    addUser($authData['email'], $authData['pass']);
    setFlashMessage("successRegister", "Пользователь " . $authData['email'] . " успешно зарегистрирован");
    return "Пользователь успешно добавлен";
}

function login($authData) {

    if (empty($authData) || !isset($authData['login']) || empty(trim($authData['login'])) || !isset($authData['pass']) || empty(trim($authData['pass']))) {
        setFlashMessage("errorLogin", "заполните все поля");
        return false;
    }

    $user = getUserInfo($authData['login']);

    if (empty($user) || !password_verify($authData['pass'], $user['password'])) {
        setFlashMessage("errorLogin", "Не верный логин или пароль");
        return false;
    }

    $_SESSION['login'] = $user['email'];
    return true;
}

function logged_in() {
    return isset($_SESSION['login']) && !empty($_SESSION['login']);
}