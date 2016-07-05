<?php
/**
 * Created by PhpStorm.
 * User: Quentin Gangler
 * Date: 05/07/2016
 * Time: 16:24
 */

namespace Courrierx\Controller;

use \Interop\Container\ContainerInterface;
use \Slim\Http\Request;
use \Slim\Http\Response;

class UniversController extends BaseController
{
    public function __construct(ContainerInterface $coi)
    {
        parent::__construct($coi);
    }

    public function geographie(Request $req, Response $res)
    {
        return $this->renderArticles($res, 'Géographie', 'Univers');
    }

    public function histoireEconomie(Request $req, Response $res)
    {
        return $this->renderArticles($res, 'Histoire et économie', 'Univers');
    }

    public function politiqueSociete(Request $req, Response $res)
    {
        return $this->renderArticles($res, 'Politique et société', 'Univers');
    }

    public function religion(Request $req, Response $res)
    {
        return $this->renderArticles($res, 'Religion', 'Univers');
    }

    public function technologieScience(Request $req, Response $res)
    {
        return $this->renderArticles($res, 'Technologie et science', 'Univers');
    }
}
