<?php
session_start();

$action = $_GET['method'];

if($action == 'login'){

    if($_SESSION['auth'] == 1 && isset($_SESSION['user'])){//if user is authenticated and set
        header('Location: index.php');
        exit();
    }
    else{

        $user = $_POST['user'];
        $pass = $_POST['pass'];

        if(empty($user) || empty($pass)){

            header('Location: login.php?errors=Set a Username and a Password');
            exit();

        }

        if($user != "admin"){

            header('Location: login.php?errors=Invalid Username');
            exit();

        }

        if($pass != "root"){

            header('Location: login.php?user=admin&errors=Invalid Password');
            exit();

        }

        if($pass == "root" && $user == "admin"){

            $_SESSION['auth'] = 1;
            $_SESSION['user'] = "Admin";
            header('Location: index.php');
            exit();
        }

    }
}

if($action == 'logout'){

    $_SESSION['auth'] = 0;
    $_SESSION['user'] = '';

    header('Location: index.php');
    exit();
}

echo 'invalid method: '.$action;