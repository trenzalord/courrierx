<?php
/**
 * Created by PhpStorm.
 * User: Quentin Gangler
 * Date: 08/06/2016
 * Time: 21:16
 */

$app->group('/utilisateur', function (){
    $this->map(['GET', 'POST'], '/connexion', '\API\V1\Action\UserAction:connexion')->setName('login');
    $this->get('/deconnexion', '\API\V1\Action\UserAction:deconnexion')->setName('logout');
    $this->get('/profil', '\API\V1\Action\UserAction:profil')->setName('profile');
    $this->post('/inscription', '\API\V1\Action\UserAction:postInscription');
    $this->get('/inscription', '\API\V1\Action\UserAction:getInscription')->setName('register');
    $this->post('/checkLogin', '\API\V1\Action\UserAction:checkLogin')->setName('checkLogin');
});