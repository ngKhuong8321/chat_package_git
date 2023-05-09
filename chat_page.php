<?php
    session_start();

    include 'app/db_conn.php';
    include 'app/http/chat.php';

    $chats = getChats($_GET["room_id"], $conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat Window</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="shadow p-4 rounded" style = "min-height: 100vh; width = 90%;" id="chatWindow">
        <a href="index.php"
           class="fs-4 link-dark">&#8592;</a>

        <div class="d-flex align-items-center">
            <img src="img/user-default.png"
                 class = "w-15 rounded-circle">
            <h2 style = "display: inline-block;"><?php echo "Room ID: ".$_GET["room_id"]?></h2>
        </div>

        <div class = "shadow p-4 rounded
                      d-flex flex-column
                      mt-2 h-50 chat-box" id="chatBox" style ="min-height: 65vh;">

            <?php foreach($chats as $chat){
                     	if($chat['from_id'] == $_GET["user_id"])
                     	{ ?>
						<p class="rtext align-self-end
						        border rounded p-2 mb-1">
						    <?=$chat['msg']?> 
						    <small class="d-block">
						    	<?=$chat['created_at']?>
						    </small>      	
						</p>
                    <?php }else{ ?>
					<p class="ltext border 
					         rounded p-2 mb-1">
					    <?=$chat['msg']?> 
					    <small class="d-block">
					    	<?=$chat['created_at']?>
					    </small>      	
					</p>
                    <?php } 
                     }?>
        </div>
        <div class = "input-group mb-3" style ="min-height: 10vh;">
            <textarea cols="3"
                      id = "message"
                      class="form-control"></textarea>
            <button class ="btn btn-primary"
                    id = "sendBtn">
                <i class="fa fa-paper-plane">SEND</i>
            </button>
        </div>
    </div>

    <script>

        var scrollDown = function(){
            let chatBox = document.getElementById('chatBox');
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        scrollDown();

        // Send message with ENTER
        var shift = false;
        $(document).keypress(function (e) {
            if(e.keyCode == 13 && !shift) {
                e.preventDefault();
                $('#sendBtn').click();
            }
        });

        $(document).keydown(function (e) {
            if(e.keyCode == 16) shift = true;
        });

        $(document).keyup(function (e) {
            if(e.keyCode == 16) shift = false;
        });


        $(document).ready(function(){

            $("#sendBtn").on('click', function(){
                message = $("#message").val();
                if(message =="") return;

                $.post("app/ajax/insert.php",
                {
                    message : message,
                    room_id : <?=$_GET["room_id"]?>,
                    from_id : <?=$_GET["user_id"]?>
                },
                function(data, status){
                    $("#message").val("");
                    $("#chatBox").append(data);
                    scrollDown();
                })
            });
        });

        // Cập nhật tin nhắn mới từ đối phương
        let fetchData = function() {
            $.post("app/ajax/getMessage.php",
                    {
                        room_id: <?=$_GET["room_id"]?>,
                        user_id: <?=$_GET["user_id"]?>
                    },
                    function(data, status){
                    $("#chatBox").append(data);
                    if (data != "") scrollDown();
                });
        }

        setInterval(() => {
            fetchData()
        }, 500);



    </script>
</body>
</html>