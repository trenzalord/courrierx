<?php
/**
 * Created by PhpStorm.
 * User: Quentin Gangler
 * Date: 08/06/2016
 * Time: 21:47
 */
namespace API\V1\Action;

use API\V1\Model\User;
use API\V1\Repository\UserRepo;
use \Interop\Container\ContainerInterface;
use Zend\Authentication\Result;
use \Slim\Http\Request;
use \Slim\Http\Response;

class UserAction extends BaseAction{

    public function __construct(ContainerInterface $coi) {
        parent::__construct($coi);
    }

    public function connexion(Request $req, Response $res){
        if(!isset($this->user)) { //to remove in Acl ?

            if ($req->isPost()) {

                $params = $req->getParsedBody();
                $login = $params['login'];
                $password = $params['password'];
                /* @var $result Result*/
                $result = $this->auth->authenticate($login, $password);

                if ($result->isValid()) {
                    $this->flash->addMessage('success', "Connexion réussie !");
                    return $res->withRedirect($this->router->pathFor('home'));
                }

                $this->flash->addMessage('error', "Identifiants incorrects");
                return $res->withRedirect($this->router->pathFor('login'));
            }

            return $this->view->render($res, "utilisateur/connexion.twig");
        }

        return $res->withRedirect($this->router->pathFor('home'));
    }

    public function deconnexion(Request $req, Response $res){
        $this->auth->logout();
        return $res->withRedirect($this->router->pathFor('home'));
    }

    public function profil(Request $req, Response $res){
        return $this->view->render($res, "utilisateur/profil.twig");
    }

    public function getInscription(Request $req, Response $res){

        $variables['csrfNameKey'] = $this->csrf->getTokenNameKey();
        $variables['csrfValueKey'] = $this->csrf->getTokenValueKey();
        $variables['csrfName'] = $req->getAttribute($variables['csrfNameKey']);
        $variables['csrfValue'] = $req->getAttribute($variables['csrfValueKey']);

        return $this->view->render($res, "utilisateur/inscription.twig", $variables);
    }

    public function postInscription(Request $req, Response $res){
        if(false !== $req->getAttribute('csrf_status')){

            $params = $req->getParsedBody();
            unset($params[$this->csrf->getTokenNameKey()]);
            unset($params[$this->csrf->getTokenValueKey()]);

            if(!(!empty($params['role']) && isset($this->user) && $this->user->isAdmin())){
                $params['role'] = 'player';
            }

            $newUser = new User($params);

            if($params['pass'] == $params['pass2'] && $newUser->isValid()){

                if(UserRepo::insertUser($newUser, $params['pass'])){
                    $this->flash->addMessage('success', "Merci pour ton inscription " . $newUser->getPrenom() . " " . $newUser->getNom());
                    return $res->withRedirect($this->router->pathFor('home'));
                }

                $this->flash->addMessage('error', "Impossible d'inserer l'utilisateur :(");
                return $res->withRedirect($this->router->pathFor('register'));
            }

            $this->flash->addMessage('error', "Les données de l'utilisateur sont incorrectes");
            return $res->withRedirect($this->router->pathFor('register'));
        }

        $this->flash->addMessage('error', "Token de sécurité invalide. Veuillez réessayer.");
        return $res->withRedirect($this->router->pathFor('register'));
    }

    public function checkLogin(Request $req, Response $res){
        if($req->isXhr()) {
            $login = $req->getParsedBody()['login'];
            $exist = UserRepo::checkExistingLogin($login);
            return $res->withJson(json_encode(["login" => $login, "exist" => $exist]));
        }

        return $res->withRedirect($this->router->pathFor('home'));
    }
}