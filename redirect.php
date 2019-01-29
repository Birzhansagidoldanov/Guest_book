<?php

 
require "DB.php";
if(($_GET['key'])){
    $stmt = $pdo->prepare("
    SELECT 
        * 
    FROM 
        `shortlink` 
    WHERE
        `shortkey` = :key
    ");
    $stmt->execute(['key' => '?key='.$_GET['key']]);
    $select = $stmt->fetchAll();
    header('Location:'.$select[0]['link']);
    var_dump($select);
    echo $_GET['key'];
}


?>