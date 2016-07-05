<?php
/**
 * Created by PhpStorm.
 * User: Quentin Gangler
 * Date: 05/07/2016
 * Time: 11:23
 */

$app->group('/recit', function () {
    $this->get('/romans', '\Courrierx\Controller\RecitController:romans')->setName('romans');
    $this->get('/nouvelles', '\Courrierx\Controller\RecitController:nouvelles')->setName('nouvelles');
    $this->get('/images', '\Courrierx\Controller\RecitController:images')->setname('images');
    $this->get('/videos', '\Courrierx\Controller\RecitController:videos')->setName('videos');
    $this->get('/audios', '\Courrierx\Controller\RecitController:audios')->setName('audios');
});
