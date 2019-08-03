<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/fonts/glyphicons-halflings-regular.svg">
    <title>Chatbox - The Online Chat App</title>
</head>
<body>

    <header class="container">
        <h1><span class="glyphicon glyphicon-envelope"></span> &nbsp;Chatbox</h1>
        <a class="sign">SignUp</a>
        <a class="log">LogIn</a>
    </header>
    <?php
        session_start();
        if(isset($_SESSION['user'])){
            echo "<script>window.location = 'index.php'</script>";
        }
    ?>
    <div class="form">
        <div id="signup">
            <h2>SignUp</h2>
            <form action="" method="POST" onsubmit="return checkPass()">
                <input type="text" name="user" id="" placeholder="Select username" required><br><br>
                <input type="password" name="pwd" id="p1" placeholder="Select password" required><br><br>
                <input type="password" id="p2" placeholder="Confirm password" required><br><br>
                <input type="submit" value="Submit" class="btn btn-primary"><br><br>
            </form>
            <?php
                if(isset($_REQUEST['user'])){
                    $user = $_REQUEST['user'];
                    $pwd = md5($_REQUEST['pwd']);

                    $dsn = 'mysql:host=localhost;dbname=chat_app';
                    $pdo = new PDO($dsn,'root','');

                    $sql = "INSERT into login values(?,?)";

                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$user,$pwd]);

                    $n = $stmt->rowCount();
                    if($n){
                        echo "<script>document.getElementById('login').style.display = 'block';
                            document.getElementById('login').style.display = 'none';</script>";
                    }else{
                        echo "<script>alert('Username already taken');</script>";
                    }
                }
            ?>
        </div>
        <div id="login">
                <h2>LogIn</h2>
            <form action="" method="POST">
                <input type="text" name="user2" id="user" placeholder="username"><br><br>
                <input type="password" name="pwd2" id="pwd" placeholder="password"><br><br>
                <button type="submit" class="btn btn-success">Login</button><br><br>
            </form>
            <div>
                Not registered ? <a class="sign">SignUp</a>
            </div>
            <?php
                if(isset($_REQUEST['user2'])){
                    $user = $_REQUEST['user2'];
                    $pwd = md5($_REQUEST['pwd2']);


                    $dsn = 'mysql:host=localhost;dbname=chat_app';
                    $pdo = new PDO($dsn,'root','');
                    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);

                    $sql = "SELECT * from login where user=?";

                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$user]);

                    if($row = $stmt->fetch()){
                        if($row->pwd == $pwd){
                            session_start();
                            $_SESSION['user'] = $user;

                            $sql = "INSERT into online values(?,?)";

                            $stmt = $pdo->prepare($sql);
                            $stmt->execute([NULL,$user]);

                            if($stmt->rowCount()){
                                echo "<script>window.location = 'index.php'</script>";
                            }
                            // echo "<script>console.log('$user')</script>";
                        }else{
                            echo "Invalid Password";
                        }
                    }else{
                        echo "Invalid Username";
                    }
                }
            ?>
        </div>
    </div>
    <script>
        let checkPass = ()=>{
            p1 = document.getElementById('p1').value;
            p2 = document.getElementById('p2').value;
            if(p1 === p2){
                return true;
            }else{
                alert("Passwords don't match");
                return false;
            }
        };
        $(document).ready(()=>{
            $('.sign').click(()=>{
                $('#signup').show();
                $('#login').hide();
            });
            $('.log').click(()=>{
                $('#signup').hide();
                $('#login').show();
            });
        });
    </script>
</body>
</html>