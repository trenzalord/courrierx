<?php
/**
 * Created by PhpStorm.
 * User: Quentin Gangler
 * Date: 23/06/2016
 * Time: 22:53
 */
namespace Courrierx\Model;

use \Illuminate\Database\Eloquent\Model as Model;

class Article extends Model
{
    protected $table = 'article';

    /**
     * Retourne l'auteur de l'article
     */
    public function auteur()
    {
        return $this->belongsTo('Courrierx\Model\User', 'auteur_id');
    }

    /**
     * Retourne les notes de l'article
     */
    public function notes()
    {
        return $this->hasMany('Courrierx\Model\Note');
    }

    /**
     * Retourne les commentaires de l'article
     */
    public function commentaires()
    {
        return $this->hasMany('Courrierx\Model\Commentaire');
    }
}
