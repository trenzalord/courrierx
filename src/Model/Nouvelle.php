<?php
/**
 * Created by PhpStorm.
 * User: Quentin Gangler
 * Date: 23/06/2016
 * Time: 23:11
 */

namespace Courrierx\Model;

use \Illuminate\Database\Eloquent\Model as Model;

class Nouvelle extends Model
{
    protected $table = 'note';

    /**
     * Retourne l'auteur de la nouvelle
     */
    public function auteur()
    {
        return $this->belongsTo('Courrierx\Model\User', 'auteur_id');
    }
}
