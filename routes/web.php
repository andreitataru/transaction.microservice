<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});



$router->group(['middleware' => 'cors'], function () use ($router) {
    //All the routes you want to allow CORS for
  
    $router->options('/{any:.*}', function (Request $req) {
      return;
    });

    // API route group
    $router->group(['prefix' => 'api'], function () use ($router) {
  
      $router->post('addTransaction', 'TransactionController@addTransaction'); 
      $router->get('getAllTransactions', 'TransactionController@getAllTransactions');
      $router->get('getTransactionById/{id}', 'TransactionController@getTransactionById');
      $router->get('getTransactionByUserId/{id}', 'TransactionController@getTransactionByUserId');
      $router->post('getTransactionsByDate', 'TransactionController@getTransactionsByDate');
      
    });

});
