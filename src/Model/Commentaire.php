<?php
/**
 * Created by PhpStorm.
 * User: Quentin Gangler
 * Date: 23/06/2016
 * Time: 23:04
 */

namespace Courrierx\Model;

use \Illuminate\Database\Eloquent\Model as Model;

class Commentaire extends Model
{
    protected $table = 'article';

    /**
     * Retourne l'auteur du commentaire
     */
    public function auteur()
    {
        return $this->belongsTo('Courrierx\Model\User', 'auteur_id');
    }

    /**
     * Retourne l'article du commentaire
     */
    public function article()
    {
        return $this->belongsTo('Courrierx\Model\Article');
    }

    /**
     * Retourne les réponses du commentaire
     */
    public function reponses()
    {
        return $this->hasMany('Courriex\Model\Commentaire', 'rep_commentaire_id');
    }

    /**
     * Retourne le commentaire original de la réponse
     */
    public function commentaireOriginal()
    {
        return $this->belongsTo('Courriex\Model\Commentaire', 'rep_commentaire_id');
    }
}
