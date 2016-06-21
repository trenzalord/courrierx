<?php
/**
 * Created by PhpStorm.
 * User: Quentin Gangler
 * Date: 10/06/2016
 * Time: 10:56
 */
namespace Courrierx\Security;

use Zend\Permissions\Acl\Acl as ZendAcl;

class CourrierxAcl extends ZendAcl
{
    public function __construct()
    {
        // APPLICATION ROLES
        $this->addRole('guest');
        // member role "extends" guest, meaning the member role will get all of
        // the guest role permissions by default
        $this->addRole('player', 'guest');
        $this->addRole('journalist', 'player');
        $this->addRole('guard', 'journalist');
        $this->addRole('author', 'guard');
        $this->addRole('admin', 'author');

        // APPLICATION RESOURCES
        // Application resources == Slim route patterns
        $this->addResource('/');
        $this->addResource('/404');
        $this->addResource('/401');
        $this->addResource('/403');
        $this->addResource('/utilisateur/connexion');
        $this->addResource('/utilisateur/deconnexion');
        $this->addResource('/utilisateur/profil');
        $this->addResource('/utilisateur/inscription');
        $this->addResource('/utilisateur/checkLogin');

        // APPLICATION PERMISSIONS
        // Now we allow or deny a role's access to resources. The third argument
        // is 'privilege'. We're using HTTP method as 'privilege'.
        $this->allow('guest', '/', 'GET');
        $this->allow('guest', '/404', 'GET');
        $this->allow('guest', '/403', 'GET');
        $this->allow('guest', '/401', 'GET');
        $this->allow('guest', '/utilisateur/connexion', ['GET', 'POST']);
        $this->allow('guest', '/utilisateur/deconnexion', 'GET');
        $this->allow('guest', '/utilisateur/inscription', ['GET', 'POST']);
        $this->allow('guest', '/utilisateur/checkLogin', 'POST');
        $this->deny('player', '/utilisateur/inscription');

        $this->allow('player', '/utilisateur/profil', 'GET');

        // This allows admin access to everything
        $this->allow('admin');
    }
}
