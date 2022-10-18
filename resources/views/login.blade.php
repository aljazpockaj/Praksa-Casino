<?php 
if(isset($_SESSION['logged_in'])){
    echo('player is logged in');
}else{
    echo('logged out');
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login page</title>
    </head>
    <body>
        <style type="text/css">
            #text{
                height: 25px;
                border-radius: 5px;
                border: solid thin #aaa;
                width: 100%;
            }
            #button{
                padding: 10px;
                width: 100px;
                color: white;
                background-color:  #5bd75b;
                border: none;    
            }
            #box{
                background-color: #ccffff;
                margin: auto;
                width: 300px;
                padding: 20px;
            }
        </style>
    <div id="box">
        <form action="login" method="POST">
        @csrf
            <input id="text" type="text" placeholder="username" name="user_name"></input>
            <br><br> <input id="text" type="password" placeholder="password" name="password"></input>
            <br><br> <input id="button" type="submit" value="login">
        </form>
    </div>
    </body>
</html>