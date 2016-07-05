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

        $json = file_get_contents("../src/Security/permissions.json");
        $permissions = new \RecursiveIteratorIterator(
            new \RecursiveArrayIterator(json_decode($json, true)),
            \RecursiveIteratorIterator::SELF_FIRST);

        $this->setupRoutes($permissions);

        // This allows admin access to everything
        $this->allow('admin');
    }

    private function setupRoutes($array, $routeName = "")
    {
        foreach ($array as $key => $val) {
            if (is_array($val)) {
                switch ($key) {
                    case "routes":
                        foreach ($val as $routeNameExtremity => $array) {
                            if (substr($routeNameExtremity, -1) != "/") {
                                $this->addResource($routeName . $routeNameExtremity);
                            }
                            $this->setupRoutes($array, $routeName . $routeNameExtremity);
                        }
                        break;
                    case "allow":
                        $this->allow($val['role'], $routeName, $val['method']);
                        break;
                    case "deny":
                        $this->deny($val['role'], $routeName, $val['method']);
                        break;
                    case "method":
                    case "role":
                        break;
                    default:
                        $routeName = $key;
                        $this->addResource($routeName);
                }
                if ($key == "routes") {
                    break;
                }
            }
        }
    }
}
