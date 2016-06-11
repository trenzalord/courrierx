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

class UserAction{
    /* @var $ci ContainerInterface */
    protected $coi;

    /* @var $view \Slim\Views\Twig*/
    protected $view;

    /* @var $auth \JeremyKendall\Slim\Auth\Authenticator */
    protected $auth;

    /* @var $csrf \Slim\Csrf\Guard */
    protected $csrf;

    /* @var $user \API\V1\Model\User */
    protected $user;

    public function __construct(ContainerInterface $coi) {
        $this->coi = $coi;
        $this->view = $this->coi->get('view');
        $this->auth = $this->coi->get('authenticator');
        $this->csrf = $this->coi->get('csrf');
        if($this->auth->hasIdentity()){
            $this->user = new User($this->auth->getIdentity());
        }else{
            $this->user = null;
        }
    }

    public function connexion(Request $req, Response $res){
        if(!isset($this->user)) {
            if ($req->isPost()) {
                $params = $req->getParsedBody();
                $login = $params['login'];
                $password = $params['password'];
                /* @var $result Result*/
                $result = $this->auth->authenticate($login, $password);

                if ($result->isValid()) {
                    return $res->withRedirect('/');
                }

                return $this->view->render($res, "utilisateur/connexion.twig", ['error' => 'Identifiants incorrects']);
            }

            return $this->view->render($res, "utilisateur/connexion.twig");
        }

        return $res->withRedirect('/');
    }

    public function deconnexion(Request $req, Response $res){
        $this->auth->logout();
        return $res->withRedirect('/');
    }

    public function profil(Request $req, Response $res){
        return $this->view->render($res, "utilisateur/profil.twig");
    }

    public function inscription(Request $req, Response $res){
        if($req->isPost() && false !== $req->getAttribute('csrf_status')){
            $params = $req->getParsedBody();
            unset($params[$this->csrf->getTokenNameKey()]);
            unset($params[$this->csrf->getTokenValueKey()]);
            if(!(!empty($params['role']) && isset($this->user) && $this->user->isAdmin())){
                $params['role'] = 'player';
            }
            $newUser = new User($params);
            if($params['pass'] == $params['pass2'] && $newUser->isValid()){
                if(UserRepo::insertUser($newUser, $params['pass'])){
                    return $res->withRedirect('/');
                }else{
                    $variables['error'] = "Insertion de l'utilisateur impossible :(";
                }
            }else{
                $variables['error'] = "Les données de l'utilisateur sont incorrectes";
            }
        }

        if(false === $req->getAttribute('csrf_status')){
            $error = "Token de sécurité invalide ! Veuillez réessayer !";
            $variables['error'] = $error;
        }

        $variables['csrfNameKey'] = $this->csrf->getTokenNameKey();
        $variables['csrfValueKey'] = $this->csrf->getTokenValueKey();
        $variables['csrfName'] = $req->getAttribute($variables['csrfNameKey']);
        $variables['csrfValue'] = $req->getAttribute($variables['csrfValueKey']);

        return $this->view->render($res, "utilisateur/inscription.twig", $variables);
    }

    public function checkLogin(Request $req, Response $res){
        if($req->isXhr()) {
            $login = $req->getParsedBody()['login'];
            $exist = UserRepo::checkExistingLogin($login);
            return $res->withJson(json_encode(["login" => $login, "exist" => $exist]));
        }
        return $res->withRedirect('/');
    }
}