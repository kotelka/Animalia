<!DOCTYPE html>


<?php



$result = array();
$message = isset($_POST['message']) ? $_POST['message'] : null;
$user= isset($_SESSION['username']) ? $_SESSION['username'] : null;

if(!empty($message) && !empty($user)){


        $stmt = $dbh->prepare(' INSERT INTO chat (
                                       id, message, user, created
                                       ) VALUES (
                                       null, :message, :user, NOW()
                                       )
                                       ');
        $stmt->execute([':message' => $message, ':user' => $user]);

}



$query = $dbh->prepare("SELECT * FROM chat");
$query ->execute();


$renderArray = array_merge($renderArray, array('chat' => $query));
/*
while($fetch = $query->fetch(PDO::FETCH_ASSOC)){
    $name = $fetch['user'];
    $message = $fetch['message'];
    $id = $fetch['id'];

    echo "<li id='$id' class='msg'><b>".ucwords($name).":</b> ".$message."</li>";
}
*/

echo $twig->render('chat.twig', $renderArray);



?>

