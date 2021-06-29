<!DOCTYPE html>
<?php
require_once __DIR__.'/vendor/autoload.php';
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

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

if(isset($_POST['loginl']) AND isset($_POST['psw'])){
    $stmt = $dbh->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute([':username' => $_POST['loginl']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        if (password_verify($_POST['psw'], $user['password'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['username'] = $user['username'];

        }
    }
}

if(isset($_POST['logout'])){
    unset ($_SESSION['id']);
    unset ($_SESSION['email']);
    unset ($_SESSION['username']);
}

//$renderArray = array("SESSION"=>$_SESSION);
$renderArray = $_SESSION;

if (isset($_SESSION['id'])){
    $stmt = $dbh->prepare("UPDATE users SET last_seen = NOW() WHERE id = :id");
    $stmt->execute([':id' => $_SESSION['id']]);
}

$stmt = $dbh->prepare("SELECT id, username, avatar FROM users WHERE last_seen IS NOT NULL AND (NOW() - last_seen) <= 300 ORDER BY last_seen DESC LIMIT 6");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($users as $key => $user) {
    $users[$key]['avatar'] = base64_encode(stripslashes($user['avatar']));
}


$renderArray = array_merge($renderArray, array('users' => $users));

$allowed_pages = ['main', 'about', 'forum', 'chat', 'account','login','register','profile','settings','game'];
if (isset($_GET['page']) && $_GET['page'] && in_array($_GET['page'], $allowed_pages)) {
	if (file_exists($_GET['page'] . '.php')) {
		include($_GET['page'] . '.php');
    } else {
	    $renderArray = array_merge($renderArray, array('page' => 'strona' . $_GET['page'] . 'nie istnieje'));
        echo $twig->render('index.twig', $renderArray);
    }
} else {
    $renderArray = array_merge($renderArray, array('name' => 's121'));
    include('main.php');
    //echo $twig->render('index.twig', $renderArray);
}



