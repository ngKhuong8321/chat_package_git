<?php
    session_start();

    include 'app/db_conn.php';
    include 'app/http/chat.php';
    include 'app/helper/isAdmin.php';
    include 'app/helper/getUsername.php';
    include 'app/http/get_forms.php';

    $chats = getChats($_GET["room_id"], $conn);
    $is_admin = isAdmin($_GET["user_id"], $conn);
    $user_name = getName($_GET["user_id"], $conn);
    $forms = getForms($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat: <?php echo $user_name;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script> 
    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet" />

    <style>
    
    /* Style the header */
    
.header {
  overflow: hidden;
  background-color: #3289c8;
  padding: 10px 10px;
}

/* Style the header links */
.header a {
  float: left;
  color: white;
  text-align: center;
  padding: 12px;
  text-decoration: none;
  font-size: 18px;
  line-height: 20px;
  border-radius: 4px;
}

/* Style the logo link (notice that we set the same value of line-height and font-size to prevent the header to increase when the font gets bigger */
.header a.logo {
  font-size: 25px;
  font-weight: bold;
}

/* Change the background color on mouse-over */
.header a:hover {
  background-color: dodgerblue;
  color: white;
}

/* Float the link section to the right */
.header-right {
  float: right;
}

/* Add media queries for responsiveness - when the screen is 500px wide or less, stack the links on top of each other */
@media screen and (max-width: 500px) {
  .header a {
    float: none;
    display: block;
    text-align: left;
  }
  .header-right {
    float: none;
  }
}

.icon {
  font-family: 'Font Awesome 5 Free', 'Font Awesome 5 Regular', 'Font Awesome 5 Brands', 'Arial';
  font-size: 18px;
  font-weight: 900;
}


    /* The Modal (background) */
    .modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    }

    /* The Close Button */
    .close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    }

    .close:hover,
    .close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
    }

    /*Scrollable Dropup List Styling */
    .scrollable-menu {
        height: auto;
        max-height: 200px;
        overflow-x: hidden;
    }
    </style>
</head>
<body>

  <div class="header">
    <!-- is_admin == true -->
    <button id="solved" class="btn btn-danger icon">&#xf104; Thoát</button>
    <div class="header-right">
      <a href="#home">Home</a>
      <a target="_blank" href="https://mybk.hcmut.edu.vn/my/">MyBK</a>
      <a target="_blank" href="https://e-learning.hcmut.edu.vn/">E-learning</a>
    </div>
  </div>
    <div class="shadow p-4 rounded" style = "min-height: 100vh; width = 90%;" id="chatWindow">

        <div class="d-flex align-items-center">
            <img src="img/user-default.png"
                 class = "rounded-circle"
                 height = "75vh">
            <h2 style = "display: inline-block;"><?php echo "Room ID: ".$_GET["room_id"]?></h2>
        </div>

        <div class = "shadow p-4 rounded
                      d-flex flex-column
                      mt-2 h-50 chat-box" id="chatBox" style ="min-height: 65vh;">

                      <?php if(!empty($statusMsg))
                      {?>
                        <p><?php echo $statusMsg;}?></p>

            <?php foreach($chats as $chat){
                     	if($chat['from_id'] == $_GET["user_id"])
                     	{ 
                            if (!$chat['is_img']) {?>
						<p class="rtext align-self-end
						        border rounded p-2 mb-1" style="word-wrap:break-word;">
						    <?=$chat['msg']?> 
						    <small class="d-block">
						    	<?=$chat['created_at']?>
						    </small>      	
						</p>
                    <?php }else{
                        ?>
						<p class="rtext align-self-end
						        border rounded p-2 mb-1" style="word-wrap:break-word;">
						    <img style="padding: 10px 10px 10px 10px;" onclick="viewImage(this)" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($chat['img'])?>" width= "100%" object-fit = "contain"/>
						    <small class="d-block">
						    	<?=$chat['created_at']?>
						    </small>      	
						</p>
                    <?php
                    }}else{ if (!$chat['is_img']) {?>
					<p class="ltext border 
					         rounded p-2 mb-1" style="word-wrap:break-word;">
					    <?=$chat['msg']?> 
					    <small class="d-block">
					    	<?=$chat['created_at']?>
					    </small>      	
					</p>
                    <?php } else {
                        ?>
						<p class="ltext border 
					         rounded p-2 mb-1" style="word-wrap:break-word;">
						    <img style="padding: 10px 10px 10px 10px;" onclick="viewImage(this)" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($chat['img'])?>" width= "100%" object-fit = "contain"/>
						    <small class="d-block">
						    	<?=$chat['created_at']?>
						    </small>      	
						</p>
                    <?php
                    }}
                     }?>
        </div>
        <div class = "input-group mb-3" style ="min-height: 5vh;">
            <textarea cols="3"
                      id = "message"
                      class="form-control"></textarea>

            <!-- Send forms -->
            <!-- is_admin == true -->
            <div class="dropup scrollable">
                <button style="min-height: 7vh; min-width: 6vh;" class="btn btn-light icon" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                    &#xf46d;
                </button>
                <ul class="dropdown-menu scrollable-menu w-400" aria-labelledby="dropdownMenu2">
                    <input class="form-control" id="myInput" type="text" placeholder="Tên biểu mẫu..">
                    <?php foreach ($forms as $form) {
                        ?><li><button onclick="sendLink('<?php echo $form['link']; ?>')" class="dropdown-item" type="button"><?=$form["name"]?></button></li>
                        <?php 
                    };?>
                </ul>
            </div>
                      
            <button class ="btn btn-light icon" style ="min-width: 6vh;"
                    id = "myBtn">&#xf1c5;
            </button>

            <div id="myModal" class="modal">

            <!-- Upload Image Modal -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <div class="wrapper">
                    <form action="app/http/upload.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="image">Select Image File:</label>
                            <input type="file" name="image" class="form-control">
                            <input type="hidden" placeholder="<?php echo $_GET["room_id"]?>" value="<?php echo $_GET["room_id"]?>" name="room_id" />
                            <input type="hidden" placeholder="<?php echo $_GET["user_id"]?>" value="<?php echo $_GET["user_id"]?>" name="user_id" />
                        </div>
                        <input type="submit" name="submit" class="btn-primary" value="Upload">
                    </form>
                </div>
            </div>

            </div>

            <div id="imageViewer" class="modal">

            <!-- View Image Modal -->
            <div class="modal-content">
                <div class="wrapper">
                    <img id="img01" style="width:100%">
                </div>
            </div>

            </div>


            <button class ="btn btn-primary"
                    id = "sendBtn">
                <i class="fa fa-paper-plane" style ="min-width: 3vh;"></i>
            </button>
        </div>
    </div>

    <div id="solvedModal" class="modal">

            <!-- Problem Solved Modal -->
            <div class="modal-content">
                <div class="wrapper">
                    <h3 class="display-4 fs-1 text-center">
                        Vấn đề đã được giải đáp?
                    </h3>
                        <ul class="scrollable-menu" aria-labelledby="dropdownMenu2">
                            <input class="form-control" id="mySolution" type="text" placeholder="Tìm kiếm tên bài viết..">
                            <?php foreach ($forms as $form) {
                                ?><li><button onclick="sendName('<?php echo $form['name']; ?>')" class="dropdown-item" type="button"><?=$form["name"]?></button></li>
                                <?php 
                            };?>
                        </ul>
                    <button style="float:right;" id="solved" onclick="window.location='//localhost/dashboard/chat_package/admin_page.php'" class="btn btn-danger icon">&#xf104; Xác nhận</button>
                </div>
            </div>

    </div>

    <script>
        
        // Send article name upon selection
        function sendName(element){
            console.log(element);
            $.post("app/http/update_popular.php",
                {
                    name : element,
                },
                function(){})
            window.location.href = "//localhost/dashboard/chat_package/admin_page.php";
        }

        // Search solution article name
        $(document).ready(function(){
            $("#mySolution").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("li").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
            });

        // Search form name
        $(document).ready(function(){
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $(".dropdown-menu li").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
            });

        var scrollDown = function(){
            let chatBox = document.getElementById('chatBox');
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        scrollDown();

        // Send form upon selection
        function sendLink(element){
            console.log(element);
            $.post("app/ajax/insert.php",
                {
                    message : element,
                    room_id : <?=$_GET["room_id"]?>,
                    from_id : <?=$_GET["user_id"]?>,
                },
                function(data, status){
                    $("#message").val("");
                    $("#chatBox").append(data);
                    scrollDown();
                })
        }

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
                    from_id : <?=$_GET["user_id"]?>,
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
                });
        }

        setInterval(() => {
            fetchData()
        }, 500);

        // Pop up modal for image uploading

            // Get the modal
            var modal = document.getElementById("myModal");

            // Get the image viewer
            var viewer = document.getElementById("imageViewer");
            
            // Get the solved modal
            var solved = document.getElementById("solvedModal");

            // Get the solved button
            var solvedBtn = document.getElementById("solved");

            // Get the button that opens the modal
            var btn = document.getElementById("myBtn");

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks the button, open the modal 
            btn.onclick = function() {
            modal.style.display = "block";
            }

            // When the user clicks the button, open the solved modal 
            solvedBtn.onclick = function() {
            solved.style.display = "block";
            }

            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
            modal.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                } else if (event.target == viewer) {
                    viewer.style.display = "none";
                } else if (event.target == solved) {
                    solved.style.display = "none";
                } else;;
            }
        
        // Pop up modal for image viewer
        function viewImage(element) {
            document.getElementById("img01").src = element.src;
            document.getElementById("imageViewer").style.display = "block";
            }

    </script>
</body>
</html>