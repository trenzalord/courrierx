<?php
/**
 * Created by PhpStorm.
 * User: Quentin Gangler
 * Date: 12/06/2016
 * Time: 19:14
 */

namespace API\V1\Action;

use API\V1\Model\User;
use \Interop\Container\ContainerInterface;


class BaseAction{
    /* @var $ci ContainerInterface */
    protected $coi;

    /* @var $view \Slim\Views\Twig*/
    protected $view;

    /* @var $auth \JeremyKendall\Slim\Auth\Authenticator */
    protected $auth;

    /* @var $csrf \Slim\Csrf\Guard */
    protected $csrf;

    /* @var $flash \Slim\Flash\Messages */
    protected $flash;

    /* @var $user \API\V1\Model\User */
    protected $user;

    /* @var $router \Slim\Router */
    protected $router;

    public function __construct(ContainerInterface $coi) {
        $this->coi = $coi;
        $this->view = $this->coi->get('view');
        $this->auth = $this->coi->get('authenticator');
        $this->csrf = $this->coi->get('csrf');
        $this->flash = $this->coi->get('flash');
        $this->router = $this->coi->get('router');
        $this->user = null;
        if($this->auth->hasIdentity()){
            $this->user = new User($this->auth->getIdentity());
        }
    }
}