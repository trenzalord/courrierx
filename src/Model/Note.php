<?php
/**
 * Created by PhpStorm.
 * User: Quentin Gangler
 * Date: 23/06/2016
 * Time: 22:59
 */

namespace Courrierx\Model;

use \Illuminate\Database\Eloquent\Model as Model;

class Note extends Model
{
    protected $table = 'note';
    public $timestamps = false;

    /**
     * Retourne l'article de la note
     */
    public function article()
    {
        return $this->belongsTo('Courrierx\Model\Article');
    }

    /**
     * Retourne l'auteur de la note
     */
    public function auteur()
    {
        return $this->belongsTo('Courrierx\Model\User', 'auteur_id');
    }
}
