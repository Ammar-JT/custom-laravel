<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/developers', function(){
    dd(config('app.developers'));
});

Route::get('/admins', function(){
    dd(config('blog.admins'));
});

//not recommended, or never use it as frantz says: 
Route::get('/creator_booo', function(){
    dd(env('APP_CREATOR'));
});

//this is recommended: 
Route::get('/creator', function(){
    dd(config('blog.creator'));
});



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');







//------------------------------------------------------------------------
//          Custom configuration file, keys and env variables
//------------------------------------------------------------------------
/*
- custom config variables is the variable you put in config file in laravel 
- you can put value in config/app.php and then get it from route or anywhere with this: 
    config('app.yourVariable)

- with this logic, you can make another file in config folder and put what ever you want: 
  .. so, make config/blog.php and put your vars


--

- same with .env, you can get variables from anywhere in the app, using this: 
    env('APP_CREATOR')
  .. it's not recommended to use env() in route, but instead use it in custom config file
  .. like config/blog.php, and inside it use: 
    'creator' => env('APP_CREATOR')
  Why??? cuz using this way, laravel gonna catch the data.. so calling it will be faster.


*/

//-------------------------
//      Authentication
//-------------------------
/*
This is old.. but it included in the lessons, so.. i copied: 

YOU HAVE TO DO THIS IN CMD NOT IN IDE OR GIT BASH: 

Try to make auth from the begining before anything,
this will install the ui for auth and also vue.js:
        composer require laravel/ui --dev
        php artisan ui vue --auth
//BEEN ASKED TO npm run dev????? do this:
        run: npm install
        run: npm run dev
  it will ask you to run mix, but do the same again:
        run: npm run dev
*/


//-----------------------------------------
//                  routes
//-----------------------------------------
/*
- for route list
        php artisan route:list

- if you want to override some of Auth::routes();, just do 
        Route::get('/register', function(){}); 
  and laravel will understand that you want to override the register route.
  .. but make sure the override is after Auth::routes();

- Laravel use thing called: >>> Single Responsibility Trait <<< and it means,
  .. every trait has only one job! laravel has that alot!


- most of the user authentication function is in AuthenticatesUsers.php, in most cases we're
  .. gonna override a methods form this class, next point i will show you how to do that

- go to AuthenticatesUsers.php (which imported in LoginController.php) and cut showLoginForm()
  .. and paste it in LoginController to override the method,
  .. and that's how you override a user auth function in laravel


- using the same way, if you want your users to login using name instead of email
  .. just go to AuthenticatesUsers{} and cut username() function and paste in LoginController.php
  .. and override it there, by replacing: 
        return 'email';
  .. with: 
        return 'name';
  As you can see, in a seconds, we change our app login, form email to name as credintials!
  


*/


