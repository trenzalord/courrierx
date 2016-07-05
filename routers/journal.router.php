<?php
/**
 * Created by PhpStorm.
 * User: Quentin Gangler
 * Date: 05/07/2016
 * Time: 16:49
 */

$app->get('/journal', function ($request, $response) {
    return $this->view->render($response, 'journal/index.twig');
})->setName('journal');
