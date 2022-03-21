<?php
include('../cfpt_facebook/PDO/functions.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
  </style>
</head>
<body>
<?php
  if(isset($_SESSION["messagePost"])){
    function_alert($_SESSION["messagePost"]);
  }
?>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Home</a></li>
        <li><a href="#postModal" role="button" data-toggle="modal"><i class="glyphicon glyphicon-plus"></i> Post</a></li>
      </ul>
      
      </ul>
    </div>
  </div>
</nav>
  
<div class="container text-center">    
  <div class="row">
    <div class="col-sm-3 well">
      <div class="well">
        <p><a href="#">My Profile</a></p>
        <img src="./images/logo-cfpt-site.png" class="img-circle" height="65" width="65" alt="Avatar">
      </div>
      <div class="well">
        <p><a href="#">Interests</a></p>
        <p>
          <span class="label label-default">News</span>
          <span class="label label-primary">W3Schools</span>
          <span class="label label-success">Labels</span>
          <span class="label label-info">Football</span>
          <span class="label label-warning">Gaming</span>
          <span class="label label-danger">Friends</span>
        </p>
      </div>
      <div class="alert alert-success fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <p><strong>Ey!</strong></p>
        People are looking at your profile. Find out who.
      </div>
      <p><a href="#">Link</a></p>
      <p><a href="#">Link</a></p>
      <p><a href="#">Link</a></p>
    </div>
    <div class="col-sm-7">
    
      <div class="row">
        <div class="col-sm-12">
          <div class="panel panel-default text-left">
            <div class="panel-body">
              <p contenteditable="true">Status: Feeling Blue</p>
              <button type="button" class="btn btn-default btn-sm">
                <span class="glyphicon glyphicon-thumbs-up"></span> Like
              </button>     
            </div>
          </div>
        </div>
      </div>
      <?php
        if(isset($_POST["textPost"]) && isset($_FILES["file"])){
          $uploadDirectory = "images/".$_FILES['file']["name"];
          move_uploaded_file($_FILES['file']['tmp_name'], $uploadDirectory);
          echo addPost($_FILES['file']['name'],$_FILES['file']['type'],base64_encode(file_get_contents($_FILES['file']['tmp_name'].[$_FILES['file']['name']])),$_POST["textPost"]);
          //echo addPost($_FILES['file']['name'],$_FILES['file']['type'],$imgContent,$_POST['textPost']); 
          /*echo "<div class='row'>";
          echo "<div class='col-sm-12'>";
          echo "<div class='panel panel-default text-left'>";
          echo "<div class='panel-body'>";
          echo "<p contenteditable='true'>Status: ".$_POST["textPost"]."</p>";
          echo "<img src='./images/".  $_FILES["file"]["name"] ."'>";
             
          echo "</div>";
          echo "<button type='button' class='btn btn-default btn-sm'>";
          echo "<span class='glyphicon glyphicon-thumbs-up'></span> Like";
          echo "</button>"; 
          echo "</div>";
          echo "</div>";
          echo "</div>";
          
        */}else{
          echo "echec";
                }
      ?>
      <div class="row">
        <div class="col-sm-3">
          <div class="well">
           <p>CFPT</p>
           <img src="./images/logo-cfpt-site.png" class="img-circle" height="55" width="55" alt="Avatar">
          </div>
        </div>
        <div class="col-sm-9">
          <div class="well">
            <p>Welcome !</p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-3">
          <div class="well">
            <p>CFPT</p>
            <img src="./images/logo-cfpt-site.png" class="img-circle" height="55" width="55" alt="Avatar">
          </div>
        </div>
        <div class="col-sm-9">
          <div class="well">
            <p>Just Forgot that I had to mention something about someone to someone about how I forgot something, but now I forgot it. Ahh, forget it! Or wait. I remember.... no I don't.</p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-3">
          <div class="well">
            <p>CFPT</p>
            <img src="./images/logo-cfpt-site.png" class="img-circle" height="55" width="55" alt="Avatar">
          </div>
        </div>
        <div class="col-sm-9">
          <div class="well">
            <p>Just Forgot that I had to mention something about someone to someone about how I forgot something, but now I forgot it. Ahh, forget it! Or wait. I remember.... no I don't.</p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-3">
          <div class="well">
            <p>CFPT</p>
            <img src="./images/logo-cfpt-site.png" class="img-circle" height="55" width="55" alt="Avatar">
          </div>
        </div>
        <div class="col-sm-9">
          <div class="well">
            <p>Just Forgot that I had to mention something about someone to someone about how I forgot something, but now I forgot it. Ahh, forget it! Or wait. I remember.... no I don't.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-2 well">
      <div class="thumbnail">
        <p>Upcoming Events:</p>
        <img src="./images/ciel.jfif" alt="Paris" width="400" height="300">
        <p><strong>Paris</strong></p>
        <p>Fri. 27 November 2015</p>
        <button class="btn btn-primary">Info</button>
      </div>      
      <div class="well">
        <p>ADS</p>
      </div>
      <div class="well">
        <p>ADS</p>
      </div>
    </div>
  </div>
</div>

<!--post modal-->
<form action="#" id="post" method="POST" class="form center-block" enctype="multipart/form-data">
<div id="postModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			Update Status
      </div>
      <div class="modal-body">
          
            <div class="form-group">
              <input type="text" id="textPost" name="textPost" class="form-control input-lg" autofocus="" placeholder="What do you want to share?" >
            </div>
            <div class="modal-footer">
              <div>
              <input type="hidden" name="MAX_FILE_SIZE" value="4000000">
                <ul class="pull-left list-inline"><li><i class="glyphicon glyphicon-camera"><input type="file" name="file" id="file" accept=".jpg,.png,.pdf"/></i></li></ul>
                <input class="btn btn-primary btn-sm"  type="submit" id="post" name="post" value="Post">
          </div>	
          </div>
      </div>
  </div>
  </div>
</div>
</form>

<footer class="container-fluid text-center">
  <p>Footer Text</p>
</footer>
</body>
</html>
