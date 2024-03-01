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

//pmc test
$router->get('/pmctest/generatetokensegurity', 'PmcTestController@GenerarTokenSeguridad');
$router->get('/pmctest/recordslists', 'PmcTestController@CasesRecordsLists');
$router->get('/pmctest/casewithrecordid', 'PmcTestController@GetCaseWithRecordId');
$router->get('/pmctest/probandotabla', 'PmcTestController@ProbandoTabla');