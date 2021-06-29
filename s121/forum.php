<!DOCTYPE html>
<?php


if(isset($_GET['add'])){
    $renderArray = array_merge($renderArray, array('add' => $_GET['add']
    ));
}
if(isset($_GET['edit'])){
    $renderArray = array_merge($renderArray, array('edit' => $_GET['edit']
    ));
}



if(isset($_POST['tytul']) AND isset($_POST['tresc']) AND mb_strlen($_POST['tresc'])>0){
    $stmt = $dbh->prepare("INSERT INTO forum (user_id,user, title, content, created) VALUES (:user_id,:user, :title, :content, NOW())");
    //$ip = $_SERVER['REMOTE_ADDR']; hmm dlaczego ja to miałem na stronce labowej? xd
    $stmt->execute([':user_id'=> $_SESSION['id'],':user'=> $_SESSION['username'], ':title'=>$_POST['tytul'],':content'=>$_POST['tresc']]);
    //print '<p style="font-weight: bold; color: green;">Post został zapisany</p>';

}


if(isset($_GET['edit']) && intval($_GET['edit']) > 0) {
    $id = intval($_GET['edit']);
    $stmt = $dbh->prepare("SELECT * FROM forum WHERE id = :id");

    $stmt->execute([':id'=> $id]);

    if($stmt->rowCount()==1){
        $post = $stmt->fetch();
        $renderArray = array_merge($renderArray, array('editpost' => $post));
    }else{
        print'Nie istnieje';
    }

}



if (isset($_POST['title']) && isset($_POST['content']) && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $stmt = $dbh->prepare("UPDATE forum SET title = :title, content = :content, updated = NOW() WHERE id = :id AND user_id = :user_id");
    $stmt->execute([':title' => $_POST['title'], ':content' => $_POST['content'], ':id' => $id, ':user_id' => (isset($_SESSION['id']) ? $_SESSION['id'] : 0)]);
    //print'<p style="font-weight: bold; color: green;">Artykuł został zmieniony</p>';
}


if (isset($_GET['delete']) && intval($_GET['delete']) > 0) {

    $id = intval($_GET['delete']);
    $stmt = $dbh->prepare("DELETE FROM forum WHERE id = :id AND user_id = :user_id");
    $stmt->execute([':id' => $id, ':user_id' => (isset($_SESSION['id']) ? $_SESSION['id'] : 0)]);
}


if(!isset($_GET['add']) AND !isset($_GET['edit'])){
    $stmt = $dbh->prepare("SELECT * FROM forum ORDER BY id DESC");
    $stmt->execute();
    $renderArray = array_merge($renderArray, array('forum' => $stmt));
}

echo $twig->render('forum.twig', $renderArray);