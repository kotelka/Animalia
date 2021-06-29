<!DOCTYPE html>
<?php
require_once __DIR__.'/vendor/autoload.php';
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

$allowed_pages = ['main', 'about', 'forum', 'chat', 'account'];
if (isset($_GET['page']) && $_GET['page'] && in_array($_GET['page'], $allowed_pages)) {
	if (file_exists($_GET['page'] . '.php')) {
		include($_GET['page'] . '.php');
    } else {
        echo $twig->render('index.twig', array('page' => 'strona' . $_GET['page'] . 'nie istnieje'));
    }
} else {
    echo $twig->render('index.twig', array('name' => 's121'));
}
