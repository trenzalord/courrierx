<?php
/**
 * Created by PhpStorm.
 * User: Quentin Gangler
 * Date: 05/07/2016
 * Time: 16:20
 */

$app->group('/univers', function () {
    $this->get('/geographie', '\Courrierx\Controller\UniversController:geographie')->setName('geographie');
    $this->get('/histoire-economie', '\Courrierx\Controller\UniversController:histoireEconomie')
        ->setName('histoire-economie');
    $this->get('/politique-societe', '\Courrierx\Controller\UniversController:politiqueSociete')
        ->setname('politique-societe');
    $this->get('/religion', '\Courrierx\Controller\UniversController:religion')->setName('religion');
    $this->get('/technologie-science', '\Courrierx\Controller\UniversController:technologieScience')
        ->setName('technologie-science');
});
