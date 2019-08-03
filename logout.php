<?php
    session_start();
    $user = $_SESSION['user'];

    $dsn = 'mysql:host=localhost;dbname=chat_app';
    $pdo = new PDO($dsn,'root','');
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);

    $sql = "DELETE from online where user=?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user]);

    $n = $stmt->rowCount();

    if($n){
        $_SESSION['user']='';
        session_destroy();
        echo "<script>window.location = 'signup.php'</script>";
    }else{
        echo "<script>window.location = 'index.php'</script>";
    }
?>