<!DOCTYPE html>
<?php

if(isset($_SESSION['id'])){

    $stmt = $dbh->prepare("SELECT id, exp, level, weapon, shield, money, low_potion, high_potion, chapter  FROM users WHERE id = :id");
    $stmt->execute([':id' => $_SESSION['id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);


    //print( $user);

    //print_r ( $user);
    //$user['avatar'] = base64_encode(stripslashes($user['avatar']));
    //echo  json_encode($user);
    $userJson = json_encode($user);
    //echo  $userJson;

    $renderArray = array_merge($renderArray, array('user' => $userJson, 'level' => $user['level']));
}



echo $twig->render('game.twig', $renderArray);
?>

<!--
<div id="dom-target" style="display: none;">
    <?php
/*
        $output = $user['level']; // Again, do some operation, get the output.
        echo htmlspecialchars($output); /* You have to escape because the result
                                           will not be valid HTML otherwise. */
    ?>
</div>

-->