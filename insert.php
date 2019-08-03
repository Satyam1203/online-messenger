<?php
    if(isset($_REQUEST['user'])){
        $sender = $_REQUEST['user'];
        $msg = $_REQUEST['msg'];
        $receiver = $_REQUEST['receiver'];

        $dsn = 'mysql:host=localhost;dbname=chat_app';
        $pdo = new PDO($dsn,'root','');
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);

        $sql = "INSERT into chats values(?,?,?,?)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([NULL,$msg,$sender,$receiver]);

        $n = $stmt->rowCount();
        if($n){
            echo "200";
        }else{
            echo "404";
        }
    }else if(isset($_REQUEST['k'])){
        $user = $_REQUEST['u'];

        $dsn = 'mysql:host=localhost;dbname=chat_app';
        $pdo = new PDO($dsn,'root','');
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);

        $sql = "SELECT * from online where user != ?";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user]);

        if($row = $stmt->fetchAll()){
            foreach($row as $r){
                echo "<p class='personal'>$r->user</p>";
            }
        }
    }
    else if($_REQUEST['p']){
        $person = $_REQUEST['p'];
        $receiver = $_REQUEST['r'];

        $dsn = 'mysql:host=localhost;dbname=chat_app';
        $pdo = new PDO($dsn,'root','');
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);

        if($receiver == 'Group'){
            $sql = "SELECT * from chats where receiver=?";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([$receiver]);
        }
        else{
            $sql = "SELECT * from chats where (receiver=? and sender=?) or (sender=? and receiver=?)";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([$person,$receiver,$person,$receiver]);
        }

        $row = $stmt->fetchAll();

        foreach($row as $r){
            if($person == $r->sender){
                echo "<div class='s'><div class='message sent'><div class='arrow'></div><p>$r->msg</p></div></div>";
            }else{
                echo "<div class='r'><div class='message received'><div class='arrow2'></div><span>$r->sender</span><p>$r->msg</p></div></div>";
            }
        }
    }
?>