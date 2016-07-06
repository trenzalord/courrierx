<?php

/**
 * Created by PhpStorm.
 * User: Quentin Gangler
 * Date: 05/07/2016
 * Time: 17:36
 */
namespace Courrierx\Controller;

use Courrierx\Model\Article;
use Illuminate\Database\QueryException;
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
        $args = $this->verifyCategorie($args);
        return $this->renderEdit($req, $res, false, $args['categorie']);
    }

    public function getEdit(Request $req, Response $res, $args)
    {
        $articleId =  $args['id'];
        $article = Article::find($articleId);
        return $this->renderEdit($req, $res, true, null, $article);
    }

    public function renderEdit(Request $req, Response $res, $edit, $categorie = null, $article = null)
    {
        $variables['csrfNameKey'] = $this->csrf->getTokenNameKey();
        $variables['csrfValueKey'] = $this->csrf->getTokenValueKey();
        $variables['csrfName'] = $req->getAttribute($variables['csrfNameKey']);
        $variables['csrfValue'] = $req->getAttribute($variables['csrfValueKey']);
        $variables['edit'] = $edit;
        if (isset($categorie)) {
            $variables['categorie'] = $categorie;
        }
        if (isset($article)) {
            $variables['article'] = $article;
        }
        return $this->view->render($res, 'articles/edit.twig', $variables);
    }

    public function postArticle(Request $req, Response $res, $args)
    {
        $args = $this->verifyCategorie($args);

        if (false !== $req->getAttribute('csrf_status')) {
            $params = $req->getParsedBody();

            $newArticle = new Article;
            $newArticle->titre = $params['titre'];
            $newArticle->dans_univers = $params['dans_univers'] == 'on'? 1 : 0;
            $newArticle->categorie = $params['categorie'];
            $newArticle->contenu = $params['contenu'];

            try {
                $this->user->articles()->save($newArticle);
                $this->flash->addMessage('success', "Article {$newArticle->titre} créé");
                return $res->withRedirect($this->router->pathFor('newArticle'));
            } catch (QueryException $e) {
                $this->flash->addMessage('error', "Erreur d'insertion");
                return $res->withRedirect($this->router->pathFor('newArticle'));
            }
        }

        $this->flash->addMessage('error', "Token de sécurité invalide. Veuillez réessayer.");
        return $res->withRedirect($this->router->pathFor('newArticle', ['categorie' => $args['categorie']]));
    }

    public function verifyCategorie($args)
    {
        if (!isset($args['categorie'])) {
            $args['categorie'] = null;
        }
        return $args;
    }

    public function patchArticle(Request $req, Response $res)
    {

    }

    public function detail(Request $req, Response $res)
    {

    }

    public function renderArticles(Request $req, Response $res, $args)
    {
        $categorie = isset($args['categorie'])? $args['categorie'] : "ALL";
        switch ($categorie) {
            case "ATR":
                $titre = "Autre";
                $section = "Récit";
                break;
            case "IMG":
                $titre = "Image";
                $section = "Récit";
                break;
            case "VID":
                $titre = "Vidéo";
                $section = "Récit";
                break;
            case "AUD":
                $titre = "Audio";
                $section = "Récit";
                break;
            case "GEO":
                $titre = "Géographie";
                $section = "Univers";
                break;
            case "HEE":
                $titre = "Histoire et économie";
                $section = "Univers";
                break;
            case "PES":
                $titre = "Politique et société";
                $section = "Univers";
                break;
            case "RLG":
                $titre = "Religion";
                $section = "Univers";
                break;
            case "TES":
                $titre = "Technologie et science";
                $section = "Univers";
                break;
            default:
                $titre = "Tous";
                $section = "Articles";
        }

        $this->view->render($res, 'articles/liste.twig', ['titre' => $titre, 'section' => $section]);
    }
}
