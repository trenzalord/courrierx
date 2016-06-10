<?php
/**
 * Created by PhpStorm.
 * User: Quentin Gangler
 * Date: 08/06/2016
 * Time: 20:00
 */

// ERROR routes
$app->get('/404', function ($request, $response) {
    return $this->view->render($response, 'error/404.twig');
});

$app->get('/401', function ($request, $response) {
    return $this->view->render($response, 'error/401.twig');
});

$app->get('/403', function ($request, $response) {
    return $this->view->render($response, 'error/403.twig');
});

// HOME routes
$app->get('/', function ($request, $response) {
    return $this->view->render($response, 'index.twig');
})->setName('home');