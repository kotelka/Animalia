<!DOCTYPE html>
<?php

$stmt = $dbh->prepare("SELECT description FROM users WHERE id = :id");
$stmt->execute([':id' => $_SESSION['id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$renderArray = array_merge($renderArray, array('description' => $user['description']));

echo $twig->render('settings.twig', $renderArray);