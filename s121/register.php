<!DOCTYPE html>
<?php

if(isset($_POST['email']) AND isset($_POST['login']) AND isset($_POST['pw']) AND isset($_POST['pwr']) AND isset($_POST['g-recaptcha-response'])){
    $recaptcha = new \ReCaptcha\ReCaptcha($config['recaptcha_private']);
    $resp = $recaptcha->verify($_POST['g-recaptcha-response'],$_SERVER['REMOTE_ADDR']);
    if($resp->isSuccess()){
        $email = $_POST['email'];
        $psw = $_POST['pw'];
        $pswr = $_POST['pwr'];
        $username = $_POST['login'];
        if(preg_match('/^[a-zA-Z0-9\-\_\.]+\@[a-zA-Z0-9\-\_\.]+\.[a-zA-Z]{2,5}$/D', $email)){
            if($psw == $pswr) {//jak ktoś wie czy da się to zrobić w htmlu to można zmienić
                $pswHash = password_hash($psw, PASSWORD_DEFAULT);
                try {
                    $stmt = $dbh->prepare(' INSERT INTO users (
                                       id, username, email,  password, avatar, description, exp, level, weapon, shield, low_potion, high_potion, money, chapter, created
                                       ) VALUES (
                                       null, :login, :email, :password, null,"", 0, 0, 0,0, 0, 0, 0, 0, NOW()
                                       )
                                       ');
                    $stmt->execute([':login' => $username, ':email' => $email, ':password' => $pswHash]);
                    $renderArray = array_merge($renderArray, array(
                        'communicate' => '<span style="color: green;">Konto zostało założone.</span>',
                        'recaptcha_public' => $config['recaptcha_public']
                    ));
                    echo $twig->render('register.twig', $renderArray);
                } catch (PDOException $e) {
                    $renderArray = array_merge($renderArray, array('communicate' => '<span style="color: red;">Podany adres email lub login są już zajęte.</span>',
                        'recaptcha_public' => $config['recaptcha_public']
                    ));
                    echo $twig->render('register.twig', $renderArray );
                }
            }else{
                $renderArray = array_merge($renderArray, array('communicate' => '<p style="font-weight: bold; color: red;">Hasła sie nie pokrywają.</p>',
                    'recaptcha_public' => $config['recaptcha_public']
                ));
                echo $twig->render('register.twig', $renderArray);

            }
        }else{
            $renderArray = array_merge($renderArray, array('communicate' => '<p style="font-weight: bold; color: red;">Proszę wprowadzić poprawny email.</p>',
                'recaptcha_public' => $config['recaptcha_public']
            ));
            echo $twig->render('register.twig', $renderArray);

        }

    }else{
        $renderArray = array_merge($renderArray,  array('communicate' => '<p style="font-weight: bold; color: red;">Proszę wypełnić recaptche!</p>',
            'recaptcha_public' => $config['recaptcha_public']
        ));
        echo $twig->render('register.twig', $renderArray);
        $errors = $resp->getErrorCodes();
    }
}else{
    $renderArray = array_merge($renderArray, array('recaptcha_public' => $config['recaptcha_public']));
    echo $twig->render('register.twig', $renderArray);
    //print_r( $renderArray['recaptcha_public']);
    //echo implode ( " ", $renderArray );
}
//Register
/*
$username = $_POST['loginek'];
$email = $_POST['email'];
$password = $_POST['haselko'];
$password2 = $_POST['haselkopowt'];
$checkbox = $_POST['checkbox'];

$errors = array();

if (empty($username)) { array_push($errors, "Brak loginu"); }
if (empty($email)) { array_push($errors, "Brak maila"); }
if (empty($password)) { array_push($errors, "Brak hasłą"); }
if($password != $password2){ array_push($errors,"Różne hasła");}



    $stmt = $dbh->prepare('INSERT INTO users (id, username, email, password, created) VALUES (null, :username, :email, :password, NOW())');

    $stmt->execute([':email' => $email, ':password' => $password, ':username' => $username]);

*/