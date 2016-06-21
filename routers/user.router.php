<?php
/**
 * Created by PhpStorm.
 * User: Quentin Gangler
 * Date: 08/06/2016
 * Time: 21:16
 */

$app->group('/utilisateur', function () {
    $this->map(['GET', 'POST'], '/connexion', '\Courrierx\Controller\UserController:connexion')->setName('login');
    $this->get('/deconnexion', '\Courrierx\Controller\UserController:deconnexion')->setName('logout');
    $this->get('/profil', '\Courrierx\Controller\UserController:profil')->setName('profile');
    $this->post('/inscription', '\Courrierx\Controller\UserController:postInscription');
    $this->get('/inscription', '\Courrierx\Controller\UserController:getInscription')->setName('register');
    $this->post('/checkLogin', '\Courrierx\Controller\UserController:checkLogin')->setName('checkLogin');
});
