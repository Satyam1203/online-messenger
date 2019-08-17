$(document).ready(()=>{
    
    $("body").on("click","#online p",function(){
        let a = $(this).text();
        $('#chat').text(a);
        $('.bgc').hide();
        $('.bgc').slideDown(500);
    });

    $("#send").click(()=>{
        let msg = $("#msg").val();
        let receiver = $("#chat").text();
        $.post('insert.php',{msg:msg,user:user,receiver:receiver},(data)=>{
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
            let receiver = $("#chat").text();
            $.post('insert.php',{p:user,r:receiver},(data)=>{
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
                    $("#people").html(d);
                },
            });
            $("#stop").click(()=>{clearInterval(online)});
        },500);
    
});
