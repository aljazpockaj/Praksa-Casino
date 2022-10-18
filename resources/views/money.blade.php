<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

?>
<div id="box">
    <h2>Give/Take money</h2>
        <form action="money" method="POST">
        @csrf
            <br><br> <input id="text" type="text" placeholder="amount" name="takeamount"></input>
           <br><br> <input id="button" type="submit" value="Transfer to poker"></input>
        </form>
    </div>
    <br>
    <div id="box">
        <form action="money" method="POST">
        @csrf
           <br><br> <input id="button" type="submit" name="balance" value="balance"></input>
        </form>
    </div>
    <p>Current poker balance:</p> 
    <p>Current casino balance:</p> 
    <br>
        <div id="box">
        <form action="money" method="POST">
             @csrf
            <br><br> <input id="text" type="text" placeholder="amount" name="giveamount"></input>
           <br><br> <input id="button" type="submit" value="Transfer to casino"></input>
        </form>
    </div>