<?php
/**
 * Created by PhpStorm.
 * User: Quentin Gangler
 * Date: 07/06/2016
 * Time: 17:20
 */

/* AUTOLOADER */
require('../vendor/autoload.php');
/* Loader des classes de l'API */
function api_autoloader($class)
{
    if(explode("\\", $class)[0] == "API") {
        $filename = '../' . str_replace('\\', '/', $class) . '.php';
        require $filename;
    }
}
spl_autoload_register('api_autoloader');

/* Database configuration TO MOVE ? */
\API\V1\Repository\StaticRepo::setConfig(['dbHost' => 'localhost', 'dbName' => 'courrierx', 'dbUser' => 'root', 'dbPass' => '']);

$configuration = [
    'settings' => [
        'determineRouteBeforeAppMiddleware' => true,
        'displayErrorDetails' => true
    ],
];

session_start();

$c = new \Slim\Container($configuration);

$c['view'] = function ($c) {
    $view = new \Slim\Views\Twig('../templates');
    $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new \Slim\Views\TwigExtension(
        $c['router'],
        $basePath
    ));

    return $view;
};

$c['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        return $c['response']->withStatus(404)->withRedirect('/404');
    };
};

$c['authAdapter'] = function ($c) {
    $db = \API\V1\Repository\StaticRepo::getConnexion();
    $adapter = new \JeremyKendall\Slim\Auth\Adapter\Db\PdoAdapter(
        $db,
        "user",
        "login",
        "pass",
        new \JeremyKendall\Password\PasswordValidator()
    );

    return $adapter;
};

$c['csrf'] = function ($c) {
    $guard = new \Slim\Csrf\Guard();
    $guard->setFailureCallable(function ($request, $response, $next) {
        $request = $request->withAttribute("csrf_status", false);
        return $next($request, $response);
    });
    return $guard;
};

$c['errorHandler'] = function ($c) {
    return function ($request, $response, $exception) use ($c) {
        $code = 0;
        if(is_a($exception, 'JeremyKendall\Slim\Auth\Exception\HttpUnauthorizedException') || is_a($exception, 'JeremyKendall\Slim\Auth\Exception\HttpForbiddenException')){
            $code = $exception->getStatusCode();
        }
        switch($code){
            case 401:
                return $c['response']->withStatus(401)->withredirect('/401');
            case 403:
                return $c['response']->withStatus(403)->withRedirect('/403');
            default:
                return $c['response']->withstatus(500)
                    ->withHeader('Content-Type', 'text/html')
                    ->write('Something went wrong!<br>')
                    ->write($exception);
        }
    };
};

$c['acl'] = function ($c) {
    return new \API\V1\Security\CourrierxAcl();
};

$c->register(new \JeremyKendall\Slim\Auth\ServiceProvider\SlimAuthProvider());

$app = new \Slim\App($c);

$app->add($app->getContainer()->get('slimAuthThrowHttpExceptionMiddleware'));

$app->add($app->getContainer()->get('csrf'));

//Ajout de la variable gloable user dans toutes les vues si on a une identité
if($app->getContainer()->get('authenticator')->hasIdentity()){
    $app->getContainer()->get('view')->getEnvironment()->addGlobal('user', new \API\V1\Model\User($app->getContainer()->get('authenticator')->getIdentity()));
}

/* Chargement des routes */
$routes = glob('../routers/*.router.php');
foreach ($routes as $route){
    require $route;
}

$app->run();
