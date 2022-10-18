<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Exception;
class SeamlessGameController extends Controller
{
    public function index(){
        $salt = "Hv82Jpa091";
        $data = $_GET; 
        $key = $data['key']; 
        unset($data['key']); 
        $hash = sha1($salt.http_build_query($data)); 
        $user = $_GET['username'];
        //če je action ($_GET['action']) balance, poiščeš balance v bazo in ga returnaš
        //če je action debit, mu odstraniš balance iz baze toliko kolikor je v amount
        //če credit mu dodaš
        if(isset($_GET['action'])&& $key == $hash){
        if($_GET['action']=='rollback'){
            $transactionId = $_GET['transaction_id'];
            DB::select('SELECT * FROM transaction WHERE transactions = "'.$transactionId.'"');
        }    
        else if($_GET['action']=='balance'){
            $balance = DB::select('SELECT balance FROM logins WHERE username="'.$user.'"');
            die('{"status":"200","balance":'.$balance[0]->balance.'}');         
             }
        else if($_GET['action']=='debit'){
            $amount = $_GET['amount'];
            $transactionId = $_GET['transaction_id'];
            $balanceDB = DB::select('SELECT balance FROM logins WHERE username="'.$user.'"');
            $balance = $balanceDB[0]->balance;
            if($balance>$amount){
            $amount = $balance - $amount;
            DB::update('update logins set balance = "'.$amount.'" WHERE username="'.$user.'"');
            DB::insert("INSERT into transaction (amount, transactions) VALUES ('$amount','$transactionId');");   
            $balanceDB = DB::select('SELECT balance FROM logins WHERE username="'.$user.'"');
            die('{"status":"200","balance":'.$balanceDB[0]->balance.'}');
             }
         } 
         else if($_GET['action']=='credit'){
            $amount = $_GET['amount'];
            $transactionId = $_GET['transaction_id'];
            $balanceDB = DB::select('SELECT balance FROM logins WHERE username="'.$user.'"');
            $balance = $balanceDB[0]->balance;
            $amount = $balance + $amount;
            DB::update('update logins set balance = "'.$amount.'" WHERE username="'.$user.'"');  
            DB::insert("INSERT INTO transaction (amount,transactions) VALUES ('$amount','');"); 
            $balanceDB = DB::select('SELECT balance FROM logins WHERE username="'.$user.'"');
            die('{"status":"200","balance":'.$balanceDB[0]->balance.'}');
            }
        }else{
            return 'Action is not set or salt key is invalid';
        }        
    }
}



