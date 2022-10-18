<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class LoginController extends Controller
{
    function data()
    {
        
        if(isset($_POST['user_name'])){
            $user = $_POST['user_name'];
            $passwordSalt = sha1($_POST['password']);
            $user = DB::select('SELECT username,`password`,seamless FROM logins WHERE username="'.$_POST['user_name'].'"');
            //če user ni najden - user does not exist
            
            if(isset($user[0])){
                if($user[0]->password == $passwordSalt){
                    //če je, loginaš player
                    session_start();
                    $_SESSION['logged_in'] = 1;
                    $_SESSION['username'] = $_POST['user_name'];
                    $_SESSION['password'] = $passwordSalt;
                }
                else{
                    //napacno geslo
                    echo('wrong pass ');
                    return view('login');
                }
                if($user[0]->seamless==0){
                    $_SESSION['seamless'] = 0;
                    return redirect('/game');
                }
                else{
                    $_SESSION['seamless'] = 1;
                    return redirect('/game');
                }
            }
            else{
                echo('user not found ');
                return view('login');
            }
            

        }
        else{
            return view('login');
        }
    }
}