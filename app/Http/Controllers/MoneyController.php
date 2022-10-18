<?php
namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
class MoneyController extends Controller
{

        function takeMoney(){
        $username = $_SESSION['username'];
        $amount = $_POST['takeamount'];
        $pass = $_SESSION['password'];

        $client = new Client(['base_uri' => 'https://stage.game-program.com']);
        $response = $client->request('POST', '/soap/gameproviderrest', ['json' => [
        'api_login' => 'aljaz_mc_gp_mc_gp',
       'api_password' => 'qKPd6G7AnKkJrLjQnP',
        'lang' => 'en',
        'method' => 'getPlayerBalance',
        "user_username" =>$username,
        "user_password"=>$pass,
        'currency' => 'EUR',
        ]]);
        $array = json_decode($response->getBody(),true);
        if(!empty($amount)) {
        if($amount<0){
        echo "Please select amount bigger than 0";
        }

        if($amount<=$array['response']){
        $client = new Client(['base_uri' => 'https://stage.game-program.com']);
        $transactionID = DB::select('SELECT TransactionID FROM logins');
        $response = $client->request('POST', '/soap/gameproviderrest', ['json' => [
        'api_login' => 'aljaz_mc_gp_mc_gp',
        'api_password' => 'qKPd6G7AnKkJrLjQnP',
        'method' => 'takeMoney',
        "user_username" =>$username,
        "user_password"=>$pass,
        "amount"=>$amount,
        "transactionid"=>$transactionID,
        'currency' => 'EUR',
        ]]);
        $transID = $transactionID[0]->TransactionID;
          DB::update('update logins set TransactionID = '.$transID+1);
        echo $response->getBody();
            $amountDb = DB::select('SELECT balance FROM logins');
            $result = $amountDb[0]->balance + $amount;
            DB::update('update logins set balance = '.$result);         
             }
        else{
            echo "insufficient funds";
            }
        }
        else{
            echo "please enter the amount";
            }
        }


        function giveMoney()
        {
            $username = $_SESSION['username'];
            $amount = $_POST['giveamount'];
            $pass = $_SESSION['password'];
            $amountDb = DB::select('SELECT balance FROM logins');
            if(!empty($amount)) {
            if($amount<0)
            {
                echo "Please select amount bigger than 0";
            }
            if($amount<=$amountDb[0]->balance){
                $transactionID = DB::select('SELECT TransactionID FROM logins');
                $client = new Client(['base_uri' => 'https://stage.game-program.com']);
                $response = $client->request('POST', '/soap/gameproviderrest', ['json' => [
                'api_login' => 'aljaz_mc_gp_mc_gp',
                'api_password' => 'qKPd6G7AnKkJrLjQnP',
                'method' => 'giveMoney',
                "user_username" =>$username,
                "user_password"=>$pass,
                "amount"=>$amount,
                "transactionid"=> $transactionID,
                'currency' => 'EUR',
                ]]);
                $transID = $transactionID[0]->TransactionID;
                DB::update('update logins set TransactionID = '.$transID+1);
                echo $response->getBody();
                $result = $amountDb[0]->balance - $amount;
                DB::update('update logins set balance = '.$result);
             
            }             
            else{
                echo "insufficient funds";
            }  
        }
            else{
                echo "please enter the amount";
            }  
            
        }
 
        function money()
        {
            //če pritisnemo gumb balance, se izvede API klic, ki vrne poker in casino balance.
            if(isset($_POST['balance'])){
                $username = $_SESSION['username'];
                $pass = $_SESSION['password'];
                $client = new Client(['base_uri' => 'https://stage.game-program.com']);
                $response = $client->request('POST', '/soap/gameproviderrest', ['json' => [
                'api_login' => 'aljaz_mc_gp_mc_gp',
                'api_password' => 'qKPd6G7AnKkJrLjQnP',
                'lang' => 'en',
                'method' => 'getPlayerBalance',
                "user_username" =>$username,
                "user_password"=>$pass,
                'currency' => 'EUR',
                ]]);
                $array = json_decode($response->getBody(),true);
                $balanceDb = DB::select('SELECT balance FROM logins');
                $balanceDb=($balanceDb[0]->balance);
                return view('moneydata')->with('poker', $balanceDb)->with('casino', $array['response']);
             }
                 
            if(isset($_POST['takeamount']) )
            {
                $this->takeMoney();
            }
            else if((isset($_POST['giveamount'])))
            {
                $this->giveMoney();
            }
            return view('money');
        }
 

}