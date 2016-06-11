<?php

namespace API\V1\Repository;

use API\V1\Model\User;

class UserRepo{
    public static function insertUser(User $user, $pass){
        $req = StaticRepo::getConnexion()->prepare("INSERT INTO user VALUES (NULL, :role, :nom, :prenom, :login, :pass, :email)");
        return $req->execute([
            'role' => $user->getRole(),
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'login' => $user->getLogin(),
            'pass' => password_hash($pass, PASSWORD_DEFAULT),
            'email' => $user->getEmail()
        ]);
    }
}