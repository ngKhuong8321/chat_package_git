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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet" />

<style>
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
  padding: 10px;
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

/* The sidebar menu */
.sidenav {
  height: 100%; /* Full-height: remove this if you want "auto" height */
  width: 160px; /* Set the width of the sidebar */
  position: fixed; /* Fixed Sidebar (stay in place on scroll) */
  z-index: 1; /* Stay on top */
  top: 0; /* Stay at the top */
  left: 0;
  background-color: #333; /* Black */
  overflow-x: hidden; /* Disable horizontal scroll */
  padding-top: 20px;
}

/* The navigation menu links */
.sidenav a {
  padding: 6px 8px 6px 16px;
  text-decoration: none;
  font-size: 15px;
  font-weight: bold;
  color: white;
  display: block;
}

/* When you mouse over the navigation links, change their color */
.sidenav a:hover {
  background-color: #f1f1f1;
  color: #333;
}

/* Style page content */
.main {
  margin-left: 160px; /* Same as the width of the sidebar */
  padding: 0px 0px;
}

/* On smaller screens, where height is less than 450px, change the style of the sidebar (less padding and a smaller font size) */
@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
</style>

</head>
<!-- Side navigation -->
<div class="sidenav">
    <a href="#">Available Room</a>
  </div>

<body class="main">
             <div class="header">
                <button onclick="history.back()" class="btn btn-secondary icon">&#xf104; Back</button>
                <div class="header-right">
                <a href="#home">Home</a>
                <a target="_blank" href="https://mybk.hcmut.edu.vn/my/">MyBK</a>
      <a target="_blank" href="https://e-learning.hcmut.edu.vn/">E-learning</a>
                </div>
            </div>
             <div style="max-height: 93vh;" class="p-5 shadow rounded list-group mvh-50 overflow-auto">
                <b>Available Rooms</b>
                <?php foreach($rooms as $room){ ?>
                    <div class = "w400 p-5 shadow rounded">
                    <form method="post" 
                        target="_blank" 
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