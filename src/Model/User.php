<?php
/**
 * Created by PhpStorm.
 * User: Quentin Gangler
 * Date: 14/06/2016
 * Time: 16:04
 */
namespace Courrierx\Model;

use \Illuminate\Database\Eloquent\Model as Model;

class User extends Model
{
    protected $table = 'user';

    /**
     * Retourne les articles de l'utilisateur
     */
    public function articles()
    {
        return $this->hasMany('Courrierx\Model\Article', 'auteur_id');
    }

    /**
     * Retourne les notes données par l'utilisateur
     */
    public function notes()
    {
        return $this->hasMany('Courrierx\Model\Note', 'auteur_id');
    }

    /**
     * Retourne les commentaires écrits par l'utilisateur
     */
    public function commentaires()
    {
        return $this->hasMany('Courrierx\Model\Commentaire', 'auteur_id');
    }

    /**
     * Retourne les nouvelles écrites par l'utilisateur
     */
    public function nouvelles()
    {
        return $this->hasMany('Courrierx\Model\Nouvelle', 'auteur_id');
    }

    /**
     * Retourne les romans écrits par l'utilisateur
     */
    public function romans()
    {
        return $this->hasMany('Courrierx\Model\Roman', 'auteur_id');
    }

    public function isPlayer()
    {
        return $this->role == "player" || $this->isJournalist();
    }

    public function isJournalist()
    {
        return $this->role == "journalist" || $this->isGuard();
    }

    public function isGuard()
    {
        return $this->role == "guard" || $this->isAuthor();
    }

    public function isAuthor()
    {
        return $this->role == "author" || $this->isAdmin();
    }

    public function isAdmin()
    {
        return $this->role == "admin";
    }
}
