<?php

include_once 'helpers/functions.php';

$uploadDir = 'uploads/gallery/';

function fileRename($name) {
    return basename(uniqid() . $name);
}

function uplodFile($fileTmpName, $uploadDir, $fileName) {
    $name = fileRename($fileName);
    if(move_uploaded_file($fileTmpName, $uploadDir . $name)) {
        uploadImg($uploadDir . $name);
        return true;
    }

    return  false;
}

for ($i = 0; $i < count($_FILES['images']['error']); $i++) {
    $tmpName = $_FILES['images']['tmp_name'][$i];
    $nameFile = $_FILES['images']['name'][$i];
    uplodFile($tmpName, $uploadDir, $nameFile);
}

header("Location: /task_15.php");
