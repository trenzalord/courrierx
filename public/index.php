<?php
/**
 * Created by PhpStorm.
 * User: Quentin Gangler
 * Date: 07/06/2016
 * Time: 17:20
 */

/* AUTOLOADER */
require('../vendor/autoload.php');
/* Loader des classes de l'App */
function app_autoloader($class)
{
    if(explode("\\", $class)[0] == "App") {
        $folders = explode("\\", $class);
        $className = array_pop($folders);
        $filename = '../' . implode('/', array_map('strtolower', $folders)) . '/' . $className . '.php';
        require $filename;
    }
}
spl_autoload_register('app_autoloader');

$configuration = [
    'settings' => [
        'determineRouteBeforeAppMiddleware' => true,
        'displayErrorDetails' => true,
        'db' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'courrierx',
            'username' => 'root',
            'password' => '',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]
    ],
];

session_start();

$c = new \Slim\Container($configuration);

$c['db'] = function ($c) {
    $capsule = new \Illuminate\Database\Capsule\Manager;
    $capsule->addConnection($c['settings']['db']);

    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    return $capsule;
};

$c['view'] = function ($c) {
    $view = new \Slim\Views\Twig('../templates');
    $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new \Slim\Views\TwigExtension(
        $c['router'],
        $basePath
    ));

    return $view;
};

$c['flash'] = function ($c){
    return new \Slim\Flash\Messages();
};

$c['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        return $c['response']->withStatus(404)->withRedirect($c['router']->pathFor('404'));
    };
};

$c['notAllowedHandler'] = function ($c) {
    return function ($request, $response, $methods) use ($c) {
        return $c['response']->withStatus(404)->withRedirect($c['router']->pathFor('404'));
    };
};

$c['authAdapter'] = function ($c) {
    $db = $c['db']->getConnection('default')->getPdo();
    $adapter = new \JeremyKendall\Slim\Auth\Adapter\Db\PdoAdapter(
        $db,
        "user",
        "login",
        "pass",
        new \JeremyKendall\Password\PasswordValidator()
    );

    return $adapter;
};

$c['csrf'] = function () {
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
        if(is_a($exception, 'JeremyKendall\Slim\Auth\Exception\HttpUnauthorizedException')
            || is_a($exception, 'JeremyKendall\Slim\Auth\Exception\HttpForbiddenException')){
            $code = $exception->getStatusCode();
        }
        switch($code){
            case 401:
                return $c['response']->withStatus(401)->withredirect($c['router']->pathFor('401'));
            case 403:
                return $c['response']->withStatus(403)->withRedirect($c['router']->pathFor('403'));
            default:
                return $c['response']->withstatus(500)
                    ->withHeader('Content-Type', 'text/html')
                    ->write('Something went wrong!<br>')
                    ->write($exception);
        }
    };
};

$c['acl'] = function ($c) {
    return new \App\Security\CourrierxAcl();
};

$c->register(new \JeremyKendall\Slim\Auth\ServiceProvider\SlimAuthProvider());

$app = new \Slim\App($c);

//Middleware d'authentification
$app->add($app->getContainer()->get('slimAuthThrowHttpExceptionMiddleware'));

//Sécurité des fomulaires
$app->add($app->getContainer()->get('csrf'));

//Ajout des messages flash pour les templates
$app->add(function ($request, $response, $next) {
    $this->view->offsetSet("flash", $this->flash);
    return $next($request, $response);
});

//Ajout de la variable gloable user dans toutes les vues si on a une identité
if($app->getContainer()->get('authenticator')->hasIdentity()){
    $app->getContainer()->get('view')->getEnvironment()
        ->addGlobal('user', \App\Model\User::find($app->getContainer()->get('authenticator')->getIdentity()['id']));
}

// Chargement des routes
$routes = glob('../routers/*.router.php');
foreach ($routes as $route){
    require $route;
}

$app->run();
