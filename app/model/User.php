<?php
/**
 * Created by PhpStorm.
 * User: Quentin Gangler
 * Date: 14/06/2016
 * Time: 16:04
 */
namespace App\Model;


use \Illuminate\Database\Eloquent\Model as Model;

class User extends Model{
    protected $table = 'user';
    public $timestamps = false;

    public function isPlayer(){
        return $this->role == "player" || $this->isJournalist();
    }

    public function isJournalist(){
        return $this->role == "journalist" || $this->isGuard();
    }

    public function isGuard(){
        return $this->role == "guard" || $this->isAuthor();
    }

    public function isAuthor(){
        return $this->role == "author" || $this->isAdmin();
    }

    public function isAdmin(){
        return $this->role == "admin";
    }
}