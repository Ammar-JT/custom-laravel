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


/*
// to call the service provider variable 'medium-php-sdk': 
Route::get('/', function(){
  $medium = resolve('medium-php-sdk');
  dd($medium);
});



// 'Test' middleware for every requests in laravel: 
Route::get('/', function(){
  dd(session()->get('test'));
});



//this is the ordinary way that you always use, you can use it in the routes for controller also: 
    //Route::post('posts', [Controllers\PostsController::class, 'index'])->middleware('test')->name('post.index');
// and you can also use it in the contructor of any controller class
Route::middleware('test')->get('/', function(){
  dd(session()->get('test'));
});





Route::middleware('admin')->group(function(){
  Route::get('/', function(){
    return view('welcome');
  });
});

*/

Route::get('/', function(){
  return view('welcome');
});



//---------------------------------------
//              Exception Handling routes
//----------------------------------------
Route::get('/user/{id}', function($id){
  //return user model record, but if user doesn't exist no error will show up
  //return App\Models\User::find($id);

  //if there is no user, it will give you error 404:
  return App\Models\User::findOrFail($id);

});
//this page is not accessable if you're not authenticated
Route::get('/dashboard', function(){
  if(!auth()->check()){
    throw new \App\Exceptions\HackerAlertException();
  }else{
    return "you're good to go";
  }

});







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


//----------------------------------------------------------------
//                          routes 
//----------------------------------------------------------------
/*
- for route list
        php artisan route:list

- if you want to override some of Auth::routes();, just do 
        Route::get('/register', function(){}); 
  and laravel will understand that you want to override the register route.
  .. but make sure the override is after Auth::routes();


*/


//----------------------------------------------------------------
//                  customize authentication functions (login)
//----------------------------------------------------------------
/*

- Laravel use thing called: >>> Single Responsibility Trait <<< and it means,
  .. every trait has only one job! laravel has that alot
  This traits can be used in the controller so the controller can use the fuctions of this trait as if it exist on it
  .. example of Traits: RegistersUsers, AuthenticatesUsers


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



//----------------------------------------------------------------
//                  customize authentication functions (register)
//----------------------------------------------------------------
/*

- register is the same as login, in RegisterController you won't find the methods that you see in route:list
  .. to find it u must go to the RegistersUsers.php,, it has all the methods

- if you want to override i method just cut it from there and paste it in the RegisterController




*/




//----------------------------------------------------------------
//                  Event + Event Listiner
//----------------------------------------------------------------
/*

- Actually I donno what event means, but it looks like a class if it is called
  and it called like this: 
        event(new Registered(
                  $user = $this->create($request->all())
              ));
  Then the listeners classes will be triggered,
  .. the event and its listeners is registered in EventServiceProvider

- the listener is a class that will listen when the event called and will trigger its functions

- to make a listener for an existing event, register it in EventServiceProvider
  .. inside the $listen Array, so you put the  event and put the array of you want listen to: 
      'Illuminate\Auth\Events\Registered' => [ 
        'App\Listeners\SendWelcomeEmail'
      ]

- Oh!! i just notice 'Illuminate\Auth\Events\Registered' already exist in the EventServiceProvider
  but the SendWelcomeEmail doesn't exist so we will add it to the array!!!


- we don't have SendWelcomeEmail class yet, if you want to make it: 
      php artisan event:generate 
  and it will generate all the listeners exist in the provider

- now you can use the SendWelcomeEmail to send the email from it in the handle(): 
      Mail::to($event->user)->send(new WelcomeToOurSaas($event->user));

- make the WelcomeToOurSaas function: 
      php artisan make:mail WelcomeToOurSaas --markdown="emails.welcome"
  and make the content of your email

- take this map to not be confused: 
    RegisterController (controller) >> 
    RegisterUsers (trait used by controllers) >> 
    Registered (event, used by the trait RegisterUsers) >> 
    EventServiceProvider (to register events and its listeners) >>
    SendEmailVerificationNotification (event listener, laravel built-in)
    SendWelcomeEmail (event listener, I made it)


*/




//----------------------------------------------------------------
//                  Service Provider
//----------------------------------------------------------------
/*

- service provier: 
    Service providers are the central place of all Laravel application bootstrapping.
    .."bootstrapped"? In general, we mean registering things, including registering service
    .. container bindings, event listeners, middleware, and even routes. 
    ..Service providers are the central place to configure your application.
    (مكان تسجل فيه المكتبات والكلاسات وكل شيء يهيء تطبيقك للعمل)
  
- config/app.php: 
    Is where you register all the service providers

- AppServiceProvider: 
    Is a ready to use service provider, you can use it for any thing,
    .. and you can also make your own one instead.


- every service provider has boot() and register() method

- Service providers are registered in the config/app.php, 

- How the app.php register these service providers?? 
  ..by calling the register function in each one of them

- register() function only to put what you want to use inside it, so only for registering things literaly


- Laravel use register() functions for each service provider while it's booting,
  .. after booting it will call the boot() functions


------

- Now let's make a service provider, we want to communicate with medium api
      https://medium.com/
  To do that we will use library for php to deal with Medium's api: 
      https://github.com/jonathantorres/medium-sdk-php
  We can use it in a controller, but if we are calling it many times (in each function of the controller for example),
  .. then the best place is a service provider, you can use the ready to use AppServiceProvider..
  .. but to learn, I will make my own one.


- if medium-sdk-php doesn't work, downgrade the "guzzlehttp/guzzle" in you composer.json: 
      "guzzlehttp/guzzle": "^6.1", <<< instead of 7.@#$ 

- To make a service provider: 
      php artisan make:provider MediumServiceProvider

- use the medium-sdk-php inside the MediumServiceProvider same way in the documentation,
  .. but change it to be appropriate for the service provdier in the register(): 
      $this->app->bind('medium-php-sdk', function(){
        return new Medium($creds);
      });


- register the new provider 'MediumServiceProvider' in app.php

- after you bind 'medium-php-sdk' with the function in MediumServiceProvider call it here in web.php

*/



//----------------------------------------------------------------
//                  Middleware
//----------------------------------------------------------------
/*
- you already know it, just a نقطة تفتيش for the requests and you can customize it

- 1- there is middlewares laravel use them for every requests in: 
      Kernel.php/$middleware[]
  2- And there is middleware groups only used for particular set requests
      Kernel.php/$middlewareGroups[] 
  3- middlewares works only for a specific route: 
      ../ routeMiddleware []

- to make a middleware: 
      php artisan make:middleware Test
  go and see it

- and as i said in the second point here, if you want to the middleware to be used in every requests
  .. put it in Kernel.php/$middleware[],,, do that with Test middleware
  .. then go here in web.php and dd('test')

- now try to put it in the api Kernel.php/middlewareGroups[]
  .. then go to api.php and dd('test')


- do the same for routeMiddleware []: so the middleware will work for a specific route in the kernel
  .. then go here in web.php and dd('test') in any route or group of routes you want

- if you want to know the strucure of 'api' and 'web' group of routes that you saw in Kernel.php
  .. just go to the RouteServiceProvider,, there you can modify the prefix of api if you want
  .. (like when you publish a new version of you api you can make the prefix('api/v2')

------

- Let's make our own group of routes and register it with our own group of middlewares,
  .. i will make a middleware for that check if user exist in the list of administrators
  .. that stored in config/app.php ...... let's make the middleware
      php artisan make:middleware Administrator

- after that we will make a middleware group called 'admin' that contain our
  .. custom middleware + the whole middleware group 'web' in kernel.php

- after that we will use the middleware group in a group of routes here in web.php
      Route::middleware('admin')->prefix('admin')->group(function(){
          your routes
      })
  the prefix will be add uri 'admin' before of the routes uri like '/home' >>>> 'admin/home'

----
- Looks messy??? you can make a route group page like web.php in the RouteServiceProvider.php
  .. huge thing right? do this in RouteServiceProvider.php:
        Route::prefix('admin')
            ->middleware('admin') //this is group of middleware not just one middleware
            ->namespace($this->namespace . '\Administroators')
            ->group(base_path('routes/admin.php'));

- make a file in routes folder : routes/admin.php

- remove the messy thing from here: 
      Route::middleware('admin')->prefix('admin')->group(function(){
                your routes
            })
  and paste it in routes/admin.php: 
      Route::get('/', function(){
              your routes
      })

*/




//----------------------------------------------------------------
//                  Exception Handling
//----------------------------------------------------------------
/*
- go the the Exception Handling here in web.php and see 

- to make an exception, you can use artisan or do it manually, here we will do it manually

- we want to have page that is not accessable if you are not auth, which is /dashboard
  .. so make an exception handler that throw an exception when you visit the page with no auth

- make /Exceptions/HackerAlertException.php

- fill it with up with: 
      namespace
      use Log
      use excpetion
      class HackerAlertException extends Exception{} 
      report() 
      render() 

- in render you right the message you want
- in report you right the report you want, sending email or log or anything,
- this time i will use log, to have the log stored in storage/logs/laravel.log file,
  .. go to config/loggin.php and change the channel to single

- now use the this handler in web.php in the route /dashboard up there




*/

