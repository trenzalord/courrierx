<?php
/**
 * Created by PhpStorm.
 * User: Quentin Gangler
 * Date: 08/06/2016
 * Time: 21:16
 */

$app->group('/utilisateur', function (){
    $this->map(['GET', 'POST'], '/connexion', '\App\Controller\UserController:connexion')->setName('login');
    $this->get('/deconnexion', '\App\Controller\UserController:deconnexion')->setName('logout');
    $this->get('/profil', '\App\Controller\UserController:profil')->setName('profile');
    $this->post('/inscription', '\App\Controller\UserController:postInscription');
    $this->get('/inscription', '\App\Controller\UserController:getInscription')->setName('register');
    $this->post('/checkLogin', '\App\Controller\UserController:checkLogin')->setName('checkLogin');
});