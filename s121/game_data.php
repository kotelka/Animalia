<?php

include("vendor/config.inc.php");

if (isset($config) && is_array($config)) {

    try {
        $dbh = new PDO('mysql:host=' . $config['db_host'] . ';dbname=' . $config['db_name'] . ';charset=utf8mb4', $config['db_user'], $config['db_password']);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        print "Nie mozna polaczyc sie z baza danych: " . $e->getMessage();
        exit();
    }

} else {
    exit("Nie znaleziono konfiguracji bazy danych.");
}

if(isset($_POST['exp'])) {
    $stmt = $dbh->prepare("UPDATE users SET exp = :exp + exp, money = :money + money WHERE id = :id");

    $stmt->execute([':exp' => $_POST['exp'], ':money' => $_POST['money'], ':id' => $_POST['id']]);


}

if(isset($_POST['level'])) {
    $stmt = $dbh->prepare("UPDATE users SET level = :level + level, exp = 0 WHERE id = :id");

    $stmt->execute([':level' => $_POST['level'], ':id' => $_POST['id']]);


}

if(isset($_POST['low_potion_use'])) {
    $stmt = $dbh->prepare("UPDATE users SET low_potion = low_potion - :low_potion   WHERE id = :id");

    $stmt->execute([':id' => $_POST['id'], ':low_potion' => $_POST['low_potion_use']]);


}

if(isset($_POST['high_potion_use'])) {
    $stmt = $dbh->prepare("UPDATE users SET high_potion = high_potion - :high_potion   WHERE id = :id");

    $stmt->execute([':id' => $_POST['id'], ':high_potion' => $_POST['high_potion_use']]);


}

if(isset($_POST['low_potion'])) {
    $stmt = $dbh->prepare("UPDATE users SET low_potion = low_potion + :low_potion, money = money - 100   WHERE id = :id");

    $stmt->execute([':id' => $_POST['id'], ':low_potion' => $_POST['low_potion']]);


}

if(isset($_POST['high_potion'])) {
    $stmt = $dbh->prepare("UPDATE users SET high_potion = high_potion + :high_potion, money = money - 400   WHERE id = :id");

    $stmt->execute([':id' => $_POST['id'], ':high_potion' => $_POST['high_potion']]);


}

if(isset($_POST['weapon1'])) {
    $stmt = $dbh->prepare("UPDATE users SET weapon = 2, money = money - 2000   WHERE id = :id");

    $stmt->execute([':id' => $_POST['id']]);


}

if(isset($_POST['weapon2'])) {
    $stmt = $dbh->prepare("UPDATE users SET weapon = 3, money = money - 4000   WHERE id = :id");

    $stmt->execute([':id' => $_POST['id']]);


}

if(isset($_POST['shield1'])) {
    $stmt = $dbh->prepare("UPDATE users SET shield = 2, money = money - 3000   WHERE id = :id");

    $stmt->execute([':id' => $_POST['id']]);


}

if(isset($_POST['shield2'])) {
    $stmt = $dbh->prepare("UPDATE users SET shield = 3, money = money - 8000   WHERE id = :id");

    $stmt->execute([':id' => $_POST['id']]);


}

if(isset($_POST['chapter'])) {
    $stmt = $dbh->prepare("UPDATE users SET exp = :exp + exp, money = :money + money, chapter = chapter + 1 WHERE id = :id");

    $stmt->execute([':exp' => $_POST['exp'], ':money' => $_POST['money'], ':id' => $_POST['id']]);


}

if(isset($_POST['id']) AND isset($_POST['dej'])){

    $stmt = $dbh->prepare("SELECT exp, level, weapon, shield, money, low_potion, high_potion, chapter  FROM users WHERE id = :id");
    $stmt->execute([':id' => $_POST['id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    //echo $user;
    $userJson = json_encode($user);
    echo  $userJson;
}
