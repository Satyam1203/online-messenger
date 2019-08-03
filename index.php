<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" href="bootstrap/fonts/glyphicons-halflings-regular.svg">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Chatbox - The Online Chat App</title>
</head>
<body>
    <?php
        session_start();
        if(!(isset($_SESSION['user']))){
            echo "<script>window.location='signup.php'</script>";
        }
        $user = $_SESSION['user'];
        echo "<script>var user = '$user';</script>";
    ?>

    <header class="container">
        <h1><span class="glyphicon glyphicon-envelope"></span> &nbsp;Chatbox</h1>
        <a href="logout.php">Logout</a>
        <a id="stop">Stop refreshing</a>
    </header>
    <div class="row1">
        <div class="col-xs-1 col-md-2"></div>
        <div id="online" class="col-md-3 col-xs-10">
            <h2>Online</h2>
            <p class="grp">Group</p>
            <div id="people">
            </div>
        </div>
        <div class="col-md-1 col-xs-1"></div>

        <div class="bgc col-md-4 col-xs-11">
            <div id="sender">
                <p id="chat">Group</p>
            </div>
            <div id="msgbox">


            </div>
            <div id="msgtext">
                <input type="text" name="msg" id="msg" placeholder="Enter your message here..">
                <button id="send" type="submit" class="btn btn-info">Send</button>
                <p id="status"></p>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>