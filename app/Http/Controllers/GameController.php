<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

if (!isset($_SESSION)) {
    session_start();
}
class GameController extends Controller
{
    public function getGame()
    {
        return view('game');
    }

    public function getRequest()
    {
        $username = $_SESSION['username'];
        $pass = $_SESSION['password'];
        $seamless = $_SESSION['seamless'];

        if ($seamless == 0) {

            $api_username = "aljaz_mc_gp_mc_gp";
            $api_password = "qKPd6G7AnKkJrLjQnP";
            $client = new Client(['base_uri' => 'https://stage.game-program.com/soap/gameproviderrest']);
            $url = "/soap/gameproviderrest";
            $a = array(
                'api_login' => $api_username,
                'api_password' => $api_password,
                "user_username" =>$username,
                "user_password"=>$pass,
                "currency" => "EUR",
                'lang' => 'en',
            );    
            $c = array($a,$client,$url);
            } 

        else if ($seamless == 1) {
            $api_username_s = "aljaz_mc_s";
            $api_password_s = "MhnlAEnYfB6qGWUhjO";
            $url = "/api/seamless/provider";
            $client = new Client(['base_uri' => 'https://stage.game-program.com/api/seamless/provider']);
            $a = array(
                'api_login' => $api_username_s,
                'api_password' => $api_password_s,
                "user_username" =>$username,
                "user_password"=>$pass,
                "currency" => "EUR",
                'lang' => 'en',
            );
            $c = array($a,$client,$url);
        }

        return $c;

    }

    public function openGame()
    {   

        $gameid = $_GET['gameId'];
        $arrayApi = array(
            'method' => 'getGameDirect',
            "gameid" => $gameid,

        );
        $test = $this->getRequest();
        $arrayAPI = array_merge($arrayApi,$test[0]);
        $response = $test[1]->request('POST', $test[2], ['json' => $arrayAPI]);
        $array = json_decode($response->getBody(), true);
        var_dump($array);
        $string = $array['response']['url'];
        return view('playgame')->with('game', $string);

    }

    public function Game()
    {  
        if($_SESSION['seamless'] == 0)
        {
        $arrayApi = array(
            'method' => 'getPlayerBalance',
        );
        $test = $this->getRequest();
        $arrayAPI = array_merge($arrayApi,$test[0]);
        $response = $test[1]->request('POST', '/soap/gameproviderrest', ['json' => $arrayAPI]);
        $array = json_decode($response->getBody(), true);
        $balance = $array['response'];
        $currency = $array['currency'];
        $gameData =  DB::select('SELECT * FROM games limit 33');
        $username = $test[0]['user_username'];
        #var_dump($gameData);
        return view('loggedingame')
            ->with('name', $username)
            ->with('balance', $balance)
            ->with('currency', $currency)
            ->with('gameList', $gameData);                        
        }
            if($_SESSION['seamless'] == 1){
            $username = $_SESSION['username'];
            $gameData =  DB::select('SELECT * FROM games limit 33');
            $balance = DB::select('SELECT balance FROM logins WHERE username="'.$username.'"');
            return view('loggedingames')
            ->with('name', $username)
            ->with('balance',$balance[0]->balance)
            ->with('gameList', $gameData);
        }
    }

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



    //fill database
    /*
    public function getGameList()
    {
        $client = new Client(['base_uri' => 'https://stage.game-program.com']);
        $response = $client->request('POST', '/soap/gameproviderrest', ['json' => [
            'api_login' => 'aljaz_mc_gp_mc_gp',
            'api_password' => 'qKPd6G7AnKkJrLjQnP',
            'method' => 'getGameList',
            'lang' => 'en',
            'show_systems' => 0,
            'currency' => 'EUR',
        ]]);
        $array = json_decode($response->getBody(), true);
        var_dump($array);
        $arrayLength = sizeof($array['response']);
        
        for ($i = 0; $i < $arrayLength; $i++) {
            $name = $array['response'][$i]['name'];
            $gameid = $array['response'][$i]['id'];
            $system = $array['response'][$i]['system'];
            $category = $array['response'][$i]['category'];
            $id_hash = $array['response'][$i]['id_hash'];
            $freerounds = $array['response'][$i]['freerounds_supported'];
            $mobile = $array['response'][$i]['mobile'];
            $image = $array['response'][$i]['image'];
            $image_preview = $array['response'][$i]['image_preview'];
            $image_filled = $array['response'][$i]['image_filled'];
            $image_background = $array['response'][$i]['image_background'];
            $image_bw = $array['response'][$i]['image_bw'];
            $arrayLength = sizeof($array['response']);
            $data = array(
                'name' => $name, "gameid" => $gameid, "system" => $system, "category" => $category, "id_hash" => $id_hash,
                "freerounds_supported" => $freerounds, "mobile" => $mobile, "image" => $image, "image_preview" => $image_preview, "image_filled" => $image_filled,
                "image_background" => $image_background, "image_bw" => $image_bw
            );
            DB::table('games')->insert($data);
        }
       
    } */
}
