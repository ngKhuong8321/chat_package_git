<?php
    session_start();

    include 'app/db_conn.php';
    include 'app/http/room.php';

    $rooms = getRooms($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel Window</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="d-flex
             justify-content-center
             align-items-center
             vh-100">
             <div class="w-400 p-5 shadow rounded list-group mvh-50 overflow-auto" style = "max-height: 90%;">
                <b>Available Rooms</b>
                <?php foreach($rooms as $room){ ?>
                    <div class = "w400 p-5 shadow rounded">
                    <form method="post" 
                        action="app/http/join_room.php">
                            <div class="mb-3">
                                <label class="form-label">Room ID</label>
                                <input type="submit"
                                    name="id"
                                    value= "<?=$room['id']?>"
                                    class="form-control"
                                    required>
                            </div>
                    </div>
                    <?php } ?>
    	     </div>
</body>
</html>