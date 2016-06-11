<?php
/**
 * Created by PhpStorm.
 * User: Quentin Gangler
 * Date: 08/06/2016
 * Time: 21:47
 */
namespace API\V1\Action;

use \Interop\Container\ContainerInterface;
use Zend\Authentication\Result;

class UserAction{
    /* @var $ci ContainerInterface */
    protected $coi;

    public function __construct(ContainerInterface $coi) {
        $this->coi = $coi;
    }

    public function connexion(\Slim\Http\Request $request, \Slim\Http\Response $response){
        $authenticator = $this->coi->get('authenticator');
        $view = $this->coi->get('view');
        if(!$authenticator->hasIdentity()) {
            if ($request->isPost()) {
                $params = $request->getParsedBody();
                $login = $params['login'];
                $password = $params['password'];
                /* @var $result Result*/
                $result = $authenticator->authenticate($login, $password);

                if ($result->isValid()) {
                    return $response->withRedirect('/');
                }

                return $view->render($response, "utilisateur/connexion.twig", ['error' => 'Identifiants incorrects']);
            }

            return $view->render($response, "utilisateur/connexion.twig");
        }

        return $response->withRedirect('/');
    }

    public function deconnexion(\Slim\Http\Request $request, \Slim\Http\Response $response){
        $this->coi->get('authenticator')->logout();
        return $response->withRedirect('/');
    }

    public function profil(\Slim\Http\Request $request, \Slim\Http\Response $response){
        return $this->coi->get('view')->render($response, "utilisateur/profil.twig");
    }

    public function inscription(\Slim\Http\Request $request, \Slim\Http\Response $response){
        return $this->coi->get('view')->render($response, "utilisateur/inscription.twig");
    }
}