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
        return $this->view->render($res, 'articles/liste.twig', ['titre' => 'Géographie', 'section' => 'Récit']);
    }

    public function histoireEconomie(Request $req, Response $res)
    {
        return $this->view->render($res, 'articles/liste.twig',
            ['titre' => 'Histoire et économie', 'section' => 'Récit']);
    }

    public function politiqueSociete(Request $req, Response $res)
    {
        return $this->view->render($res, 'articles/liste.twig',
            ['titre' => 'Politique et société', 'section' => 'Récit']);
    }

    public function religion(Request $req, Response $res)
    {
        return $this->view->render($res, 'articles/liste.twig', ['titre' => 'Religion', 'section' => 'Récit']);
    }

    public function technologieScience(Request $req, Response $res)
    {
        return $this->view->render($res, 'articles/liste.twig',
            ['titre' => 'Technologie et science', 'section' => 'Récit']);
    }
}
