<?php  

?>
<!DOCTYPE html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="<?php echo asset('css/app.css')?>" type="text/css"> 
   <div id="div1">
       <h1 id="title"><em>Kazino Počkaj</em></h1>
          <nav>
              <div class="wrapper">
                <ul>
                   <li></li>
                </ul>
              </div>
          </nav>
   </div>
</head>
<body>
<?php  
echo ('<iframe src="'.$game.'" height="500" width="700" title="description"></iframe>');
?>
</body>
</html>
</html>
