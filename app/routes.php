<?php

declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

require_once(__DIR__ . '/../app/db.php');

foreach (glob(__DIR__ . '/../Controller/RouteController/*.php') as $filename) {
    require_once($filename);
}
foreach(glob(__DIR__ . "/../../Controller/*.php") as $filename) {
	require_once($filename);
}

session_start();

// TODO: Delete before pushing to production!
$_SESSION['user_id'] = 4;


return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', \RouteController::class . ':home');

    $app->get('/config',
        \ConfigRouteController::class . ':get_organisation_config'); //TESTED, verified for working
    $app->get('/config' . NUTS_0,
        \ConfigRouteController::class . ':get_organisation_config'); //TESTED, verified for working
    $app->get('/config' . NUTS_01,
        \ConfigRouteController::class . ':get_organisation_config'); //TESTED, verified for working
    $app->get('/config' . NUTS_012,
        \ConfigRouteController::class . ':get_organisation_config'); //TESTED, verified for working
    $app->get('/config' . NUTS_FULL,
        \ConfigRouteController::class . ':get_organisation_config'); //TESTED, verified for working
    $app->get('/config' . NUTS_FULL . ORG_TYPE,
        \ConfigRouteController::class . ':get_organisation_config'); //TESTED, verified for working
    $app->get('/config' . ORG_FULL_LINK,
        \ConfigRouteController::class . ':get_organisation_config'); //TESTED, verified for working
    $app->get('/config' . ORG_FULL_LINK . FIELD_NAME,
        \ConfigRouteController::class . ':get_org_full_link_field_name'); //TESTED, verified for working


    $app->post('/config' . ORG_FULL_LINK,
        \ConfigRouteController::class . ':post_org_full_link'); // TODO
    $app->post('/config' . ORG_FULL_LINK . FIELD_NAME,
        \ConfigRouteController::class . ':post_org_full_link_field_name'); // TODO

    $app->put('/config' . ORG_FULL_LINK,
        \ConfigRouteController::class . ':put_org_full_link');
    $app->put('/config' . ORG_FULL_LINK . FIELD_NAME,
        \ConfigRouteController::class . ':put_org_full_link_field_name');

    $app->delete('/config' . ORG_FULL_LINK,
        \ConfigRouteController::class . ':delete_org_full_link'); // TODO
    $app->delete('/config' . ORG_FULL_LINK . FIELD_NAME,
        \ConfigRouteController::class . ':delete_org_full_link_field_name'); // TODO



    $app->get('/data',
        \DataRouteController::class . ':home'); //TESTED, verified for working
    $app->get('/data/field',
        \DataRouteController::class . ':get_field'); // TODO: NOT WORKING
    $app->get('/data/field/{field_id:[0-9]+}',
        \DataRouteController::class . ':get_field_field_id'); // TODO: NOT WORKING
    $app->get('/data' . NUTS_0,
        \DataRouteController::class . ':get_organisation_data'); //TESTED, verified for working
    $app->get('/data' . NUTS_01,
        \DataRouteController::class . ':get_organisation_data'); //TESTED, verified for working
    $app->get('/data' . NUTS_012,
        \DataRouteController::class . ':get_organisation_data'); //TESTED, verified for working
    $app->get('/data' . NUTS_FULL,
        \DataRouteController::class . ':get_organisation_data'); //TESTED, verified for working
    $app->get('/data' . NUTS_FULL . ORG_TYPE,
        \DataRouteController::class . ':get_organisation_data'); //TESTED, verified for working
    $app->get('/data' . ORG_FULL_LINK,
        \DataRouteController::class . ':get_org_full_link'); //TESTED, TODO: add links for data/.../field_name
    $app->get('/data' . ORG_FULL_LINK . YEAR,
        \DataRouteController::class . ':get_org_full_link_year'); //TESTED, verified for working
    $app->get('/data' . ORG_FULL_LINK . YEAR . MONTH,
        \DataRouteController::class . ':get_org_full_link_year_month'); //TESTED, verified for working
    $app->get('/data' . ORG_FULL_LINK . DATE_FULL,
        \DataRouteController::class . ':get_org_full_link_date_full'); //TESTED, verified for working


    $app->get('/data' . ORG_FULL_LINK . FIELD_NAME,
        \DataRouteController::class . ':get_org_full_link_field_name'); //TESTED, verified for working
    $app->get('/data' . ORG_FULL_LINK . FIELD_NAME . YEAR,
        \DataRouteController::class . ':get_org_full_link_field_name_year'); //TESTED, verified for working
    $app->get('/data' . ORG_FULL_LINK . FIELD_NAME . YEAR . MONTH,
        \DataRouteController::class . ':get_org_full_link_field_name_year_month'); //TESTED, verified for working
    $app->get('/data' . ORG_FULL_LINK . FIELD_NAME . DATE_FULL,
        \DataRouteController::class . ':get_org_full_link_field_name_date_full'); //TESTED, verified for working


    $app->post('/data' . ORG_FULL_LINK . DATE_FULL,
        \DataRouteController::class . ':post_org_full_link');
    $app->post('/data' . ORG_FULL_LINK . FIELD_NAME . DATE_FULL,
        \DataRouteController::class . ':post_org_full_link_field_name');

    $app->put('/data' . ORG_FULL_LINK . DATE_FULL,
        \DataRouteController::class . ':put_org_full_link');
    $app->put('/data' . ORG_FULL_LINK . FIELD_NAME . DATE_FULL,
        \DataRouteController::class . ':put_org_full_link_field_name');

    $app->get('/user', \UserRouteController::class . '/get_home');
    $app->post('/user', \UserRouteController::class . '/post_home');

    $app->get('/user/{id:[0-9]+}', \UserRouteController::class . '/get_user_id');
    $app->post('/user/{id:[0-9]+}', \UserRouteController::class . '/post_user_id');
    $app->put('/user/{id:[0-9]+}', \UserRouteController::class . '/put_user_id');
    $app->delete('/user/{id:[0-9]+}', \UserRouteController::class . '/delete_user_id');

    $app->post('login', \LoginRouteController::class . ':login');
    $app->post('logout', \LoginRouteController::class . ':logout');

}
?>
