<?php
/**
 * Created by PhpStorm.
 * User: Quentin Gangler
 * Date: 23/06/2016
 * Time: 23:15
 */

namespace Courrierx\Model;

use \Illuminate\Database\Eloquent\Model as Model;

class Roman extends Model
{
    protected $table = 'roman';

    /**
     * Retourne l'auteur du roman
     */
    public function auteur()
    {
        return $this->belongsTo('Courrierx\Model\User', 'auteur_id');
    }

    /**
     * Retourne les chapitres du roman
     */
    public function romans()
    {
        return $this->hasMany('Courriex\Model\Chapitre');
    }
}
