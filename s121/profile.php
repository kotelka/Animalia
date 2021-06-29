<!DOCTYPE html>
<?php
if(isset($_SESSION['id'])){

    if (isset($_FILES['avatar']) and $_FILES['avatar']) {
        $stmt = $dbh->prepare("UPDATE users SET avatar = :avatar WHERE id = :id");
        $image = addslashes(file_get_contents($_FILES['avatar']['tmp_name']));
        //$image = file_get_contents($_FILES['avatar']['tmp_name']);
        //print '<img src="data:image/png;base64, '.base64_encode(file_get_contents($_FILES['avatar']['tmp_name'])).'" alt="Red dot" />';
        //print '<img src="'.$_FILES['avatar']['tmp_name'].'" alt="Red dot" />';
        //$image = base64_encode(addslashes(file_get_contents($_FILES['avatar']['tmp_name'])));
        $stmt->execute([':avatar' => $image, ':id' => (isset($_SESSION['id']) ? $_SESSION['id'] : 0)]);

    }
    if (isset($_POST['description'])) {
        $stmt = $dbh->prepare("UPDATE users SET description = :description WHERE id = :id");
        $stmt->execute([':description' => $_POST['description'], ':id' => (isset($_SESSION['id']) ? $_SESSION['id'] : 0)]);

    }

    if(isset($_GET['profile'])){
        $stmt = $dbh->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([':id' => $_GET['profile']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        //print $user['avatar'];

        if(isset($user['username'])){
            $img = base64_encode(stripslashes($user['avatar']));
            $renderArray['username'] = $user['username'];

            $renderArray = array_merge($renderArray, array('avatar' => $img,
                'description' => $user['description'],
                'exp' => $user['exp'],
                'level' => $user['level']));
        }else{
            $img = "";
            $renderArray['username'] = "Kotfident";

            $renderArray = array_merge($renderArray, array('avatar' => $img,
                'description' => "A, wie pan, moim zdaniem to nie ma tak, że dobrze, albo że niedobrze. Gdybym miał powiedzieć, co cenię w życiu najbardziej, powiedziałbym, że ludzi. Ludzi, którzy podali mi pomocną dłoń, kiedy sobie nie radziłem, kiedy byłem sam, i co ciekawe, to właśnie przypadkowe spotkania wpływają na nasze życie. Chodzi o to, że kiedy wyznaje się pewne wartości, nawet pozornie uniwersalne, bywa, że nie znajduje się zrozumienia, które by tak rzec, które pomaga się nam rozwijać. Ja miałem szczęście, by tak rzec, ponieważ je znalazłem, i dziękuję życiu! Dziękuję mu; życie to śpiew, życie to taniec, życie to miłość! Wielu ludzi pyta mnie o to samo: ale jak ty to robisz, skąd czerpiesz tę radość? A ja odpowiadam, że to proste! To umiłowanie życia. To właśnie ono sprawia, że dzisiaj na przykład buduję maszyny, a jutro – kto wie? Dlaczego by nie – oddam się pracy społecznej i będę, ot, choćby, sadzić... doć— m-marchew...",
                'exp' => "-666",
                'level' => "69"));
        }
    }else{
        $stmt = $dbh->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([':id' => $_SESSION['id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        //print $user['avatar'];

        //$img = base64_encode($user['avatar']);
        $img = base64_encode(stripslashes($user['avatar']));

        //$img = $user['avatar'];

        $renderArray = array_merge($renderArray, array('avatar' => $img,
        'description' => $user['description'],
        'exp' => $user['exp'],
        'level' => $user['level']));
    }
}

echo $twig->render('profile.twig', $renderArray);
