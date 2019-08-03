<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <title>Document</title>
    <style>
        .container h1{
            width:60%;
            float:left;
        }
        .container button{
            float:right;
            margin:2em;
        }
        .bgc{
            width:500px;
            margin:auto;
            background:#999;
            background: url(https://images.pexels.com/photos/317353/pexels-photo-317353.jpeg) no-repeat;
            background-size:cover;
        }
        #msgbox::-webkit-scrollbar{
            width:0.3em;
        }
        #msgbox::-webkit-scrollbar-thumb{
            background-color:#999;
        }
        #msgbox{
            position:relative;
            overflow-y:scroll;
            width:500px;
            height:600px;
            /* background-color:#aaa; */
        }
        #sender{
            width:500px;
            margin:auto;
            border-top:2px solid #fff;
            /* margin-top:0em; */
            padding:10px;
            /* background-color:#999;   */
            text-align:center;
        }
        #sender input{
            padding:5px;
            border-radius:5px;
            width:28em;
        }
        .message span{
            font-weight:600;
            color:#59e;
            padding:0px 1em;
        }
        .s,.r{
            width:100%;
            height:8rem;
        }
        .message{
            /* width:60%; */
            /* background-color:#467; */
            /* color:#FFF; */
            margin:5px;
            border-radius:10px;
        }
        .message p{
            margin:0.5em 1em;
        }
        .sent{
            float:right;
            background-color:lightgreen;
            color:#000;
        }
        .received{
            float:left;
            background-color:white;
            color:#000;
            padding-left:1em;
        }
        .arrow{
            box-sizing:border-box;
            padding:0px;
            float:right;
            margin-right:-0.3em;
            width:0px;
            height:0px;
            border-left:12px solid lightgreen;
            border-bottom:16px solid transparent;
        }
        .arrow2{
            box-sizing:border-box;
            padding:0px;
            margin-left:-1.3em;
            width:0px;
            height:0px;
            border-right:12px solid white;
            border-bottom:8px solid transparent;
        }
        #online{
            width:100%;
            height:100px;
            color:black;
        }
    </style>
</head>
<body>
    <?php 
        session_start();
        if(!(isset($_SESSION['user']))){
            echo "<script>window.location='login.php'</script>";
        }
        $user = $_SESSION['user'];  
        echo "<script>var user = '$user';</script>"; 
    ?>

    <header class="container">
        <h1>Chatbox</h1>
        <button><a href="logout.php">Logout</a></button>
    </header> 
    <div class="bgc">
        <div id="msgbox">


        </div>
        <div id="sender">
            <input type="text" name="msg" id="msg" placeholder="Enter your message here..">
            <button id="send" type="submit" class="btn btn-info">Send</button>
            <p id="status"></p>
        </div>
    </div>
    <div id="online">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia laboriosam non eius obcaecati modi illum vero dolorem quis consectetur in, consequatur repudiandae reprehenderit. Aliquam laborum reiciendis molestias, fugiat dolore saepe?
    </div>
    <div>
        <button id="stop">Stop</button>
    </div>
    <script>
        $(document).ready(()=>{
            
            $("#send").click(()=>{
                let msg = $("#msg").val();
                $.post('insert.php',{msg:msg,user:user},(data)=>{
                    if(data == 200){
                        $("#status").html("Message Sent");
                        $("#msg").val('');
                    }
                    else{
                        $("#status").html("Can't Send");
                    }
                });
            });
            var updateMsg = 
                setInterval(function(){
                    $.post('insert.php',{p:user},(data)=>{
                        // if()
                        console.log("Messages Updated");
                        $("#msgbox").html(data);
                    });
                    $("#stop").click(()=>{clearInterval(updateMsg)});
                },500);
            
            // $.post('insert.php',{k:1,u:user},(data)=>{
            //     $("#online").html(data);
            // });
            
            var online = 
                setInterval(function(){
                    $.ajax({
                        url:'insert.php',
                        type:'post',
                        data:{k:1,u:user},
                        success:(d)=>{
                            $("#online").html(d);
                        },
                    });
                    $("#stop").click(()=>{clearInterval(online)});
                },500);
            
        });
    </script>
</body>
</html>