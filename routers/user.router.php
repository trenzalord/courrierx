<?php
/**
 * Created by PhpStorm.
 * User: Quentin Gangler
 * Date: 08/06/2016
 * Time: 21:16
 */

$app->group('/utilisateur', function (){
    $this->map(['GET', 'POST'], '/connexion', '\API\V1\Action\UserAction:connexion')->setName('login');
    $this->get('/deconnexion', '\API\V1\Action\UserAction:deconnexion');
    $this->get('/profil', '\API\V1\Action\UserAction:profil');
    $this->map(['GET', 'POST'], '/inscription', '\API\V1\Action\UserAction:inscription');
});