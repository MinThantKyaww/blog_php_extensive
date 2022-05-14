<?php
    require 'config.php';
    $pdo_statement = $pdo->prepare("DELETE FROM post WHERE id=".$_GET['id']);
    $pdo_statement->execute();

    header('location: index.php');
?>