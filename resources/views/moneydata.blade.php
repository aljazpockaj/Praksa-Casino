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
           <br><br> <input id="button" type="submit" name="balance"></input>
        </form>
    </div>
    <div>
    <p>Current poker balance: {{$poker}} EUR</p>     
    <p>Current casino balance: {{$casino}} EUR</p>     
    </div>
  
    <br>
        <div id="box">
        <form action="money" method="POST">
            <br><br> <input id="text" type="text" placeholder="amount" name="giveamount"></input>
           <br><br> <input id="button" type="submit" value="Transfer to casino"></input>
        </form>
    </div>