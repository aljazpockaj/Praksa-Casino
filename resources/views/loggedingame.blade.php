<?php  
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="<?php echo asset('css/app.css')?>" type="text/css"> 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
   <div id="div1">
       <h1 id="title"><em>Kazino Počkaj</em></h1>
       <p id="balance">Logged in as {{$name}}</p>
        <p id='balance'>Your balance: {{$balance}} EUR</p>
          <nav>
              <div class="wrapper">
                <ul>
                   <li><a href="money" style="color: red">Transfer Money</li> 
                   <li><a href="/" style="color: red">Logout</li> 
                </ul>
              </div>
          </nav>
   </div>
</head>
<body style="background-color: #a6a6a6">
<br>
<br>
<div class="container">
<div class="row">
  <?php
  foreach ($gameList as $game){
    echo('<div style="padding: 30px;" class="col" ><a href="opengame?gameId='.$game->gameid.'"><img onerror="this.onerror=null; this.src=\'img/nedela.jpg\'" src="'.$game->image_filled.'" title="'.$game->name.'"></a></div>
    ');
  }
  ?>
</div>
</div>
</body>
</html>

