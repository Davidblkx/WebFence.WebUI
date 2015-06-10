<?php
session_start();
include('hostsinterop.php');

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

if($action == 'updatehosts'){

    $id = $_POST['id'];
    $name = $_POST['name'];
    $hosts = $_POST['hosts'];

    if(empty($name) || empty($hosts)){
        header('Location: hosts.php?error="error0x01"');
        exit();
    }

    $db = new dbHosts();
    $db->Init();

    $elem = $db->getById($id);

    if(empty($elem))
        $elem = new itemHost();

    $elem->Name = $name;
    $elem->Hosts = explode("\n", $hosts);

    print_r($elem);

    $state = $db->updateItem($elem);

    echo $state;

    header('Location: hosts.php?state=success0x01"');
    exit();
}

if($action == 'removehosts'){

    $id = $_POST['id'];
    if(empty($id)){
        header('Location: hosts.php?error="error1x01"');
        exit();
    }

    $db = new dbHosts();
    $db->Init();
    $db->removeItem($id);

    header('Location: hosts.php?state=success1x01"');
    exit();
}

echo 'invalid method: '.$action;