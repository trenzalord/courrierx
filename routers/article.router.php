<?php
/**
 * Created by PhpStorm.
 * User: Quentin Gangler
 * Date: 05/07/2016
 * Time: 17:49
 */

$app->group('/articles', function () {
    $this->group('/{id:[0-9]+}', function () {
        $this->get('', '\Courrierx\Controller\ArticleController:detail');
        $this->get('/editer', '\Courrierx\Controller\ArticleController:getEdit');
        $this->post('/editer', '\Courrierx\Controller\ArticleController:patchArticle');
    });
    $this->get('/nouveau[/{categorie:[A-Z]{3}}]', '\Courrierx\Controller\ArticleController:getNew');
    $this->post('/nouveau[/{categorie:[A-Z]{3}}]', '\Courrierx\Controller\ArticleController:postArticle');
});
