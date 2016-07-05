<?php
/**
 * Created by PhpStorm.
 * User: Quentin Gangler
 * Date: 05/07/2016
 * Time: 13:41
 */

namespace Courrierx\Controller;

use \Interop\Container\ContainerInterface;
use \Slim\Http\Request;
use \Slim\Http\Response;

class RecitController extends BaseController
{
    public function __construct(ContainerInterface $coi)
    {
        parent::__construct($coi);
    }

    public function romans(Request $req, Response $res)
    {
        return $this->view->render($res, 'articles/liste.twig', ['titre' => 'Romans', 'section' => 'Récit']);
    }

    public function nouvelles(Request $req, Response $res)
    {
        return $this->view->render($res, 'articles/liste.twig', ['titre' => 'Nouvelles', 'section' => 'Récit']);
    }

    public function images(Request $req, Response $res)
    {
        return $this->view->render($res, 'articles/liste.twig', ['titre' => 'Images', 'section' => 'Récit']);
    }

    public function videos(Request $req, Response $res)
    {
        return $this->view->render($res, 'articles/liste.twig', ['titre' => 'Videos', 'section' => 'Récit']);
    }

    public function audios(Request $req, Response $res)
    {
        return $this->view->render($res, 'articles/liste.twig', ['titre' => 'Audios', 'section' => 'Récit']);
    }
}
