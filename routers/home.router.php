<?php
/**
 * Created by PhpStorm.
 * User: Quentin Gangler
 * Date: 08/06/2016
 * Time: 20:00
 */

$app->get('/', function ($request, $response) {
    return $this->view->render($response, 'index.twig');
})->setName('home');
