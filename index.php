<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<link rel="stylesheet" href="css/style.css">
</head>
<body>

<h2>Live Chat PopUp</h2>
<p>Click on the button at the bottom of this page to open chat request form.</p>
<p>Note that the button and the form is fixed - they will always be positioned to the bottom of the browser window.</p>

<a href="admin_page.php">  
  <button class="btn btn-primary">Admin Panel</button>
 </a>

<button class="btn btn-primary" 
        style="position: fixed;
               bottom: 23px;
               right: 28px;"
        onclick="openForm()">Chat</button>

<div class="chat-popup w-400 p-5 shadow rounded" id="myForm">
  <form method="post" target="_blank" 
              action="app/http/request.php">
            <div class = "d-flex
                          justify-content-center
                          align-items-center
                          flex-column">
                <h3 class="display-4 fs-1 text-center">
                    Request Chat Session
                </h3>
            </div>

        <div class="mb-3">
            <label class="form-label">Student ID</label>
            <input type="text"
                   name="id"
                   class="form-control"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Student Name</label>
            <input type="text"
                   name="name"
                   class="form-control"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Problem</label>
            <input type="text"
                   name="message"
                   class="form-control"
                   required>
        </div>
        <button type="submit"
                class="btn btn-primary">Submit</button>
        </form>
</div>

<script>
function openForm() {
  document.getElementById("myForm").style.display = "block";
}

function closeForm() {
  document.getElementById("myForm").style.display = "none";
}
</script>

</body>
</html>
