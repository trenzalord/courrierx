<?php
/**
 * Created by PhpStorm.
 * User: Quentin Gangler
 * Date: 23/06/2016
 * Time: 23:17
 */

namespace Courrierx\Model;

use \Illuminate\Database\Eloquent\Model as Model;

class Chapitre extends Model
{
    protected $table = 'chapitre';

    /**
     * Retourne le roman du chapitre
     */
    public function roman()
    {
        return $this->belongsTo('Courrierx\Model\Roman');
    }
}
