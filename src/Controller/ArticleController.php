<?php

/**
 * Created by PhpStorm.
 * User: Quentin Gangler
 * Date: 05/07/2016
 * Time: 17:36
 */
namespace Courrierx\Controller;

use Courrierx\Model\Article;
use \Interop\Container\ContainerInterface;
use \Slim\Http\Request;
use \Slim\Http\Response;

class ArticleController extends BaseController
{
    public function __construct(ContainerInterface $coi)
    {
        parent::__construct($coi);
    }

    public function getNew(Request $req, Response $res, $args)
    {
        if (!isset($args['categorie'])) {
            $args['categorie'] = null;
        }
        return $this->view->render($res, 'articles/edit.twig', ['edit' => false, 'categorie' => $args['categorie']]);
    }

    public function getEdit(Request $req, Response $res, $args)
    {
        $articleId =  $args['id'];
        $article = Article::find($articleId);
        return $this->view->render($res, 'articles/edit.twig', ['edit' => true, 'article' => $article]);
    }

    public function postArticle(Request $req, Response $res)
    {

    }

    public function patchArticle(Request $req, Response $res)
    {

    }

    public function detail(Request $req, Response $res)
    {

    }
}
