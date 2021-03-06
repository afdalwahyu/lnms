<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Arp extends Model {

    /*
     * arp belongs to node
     */
    public function node()
    {
        return $this->belongsTo('\App\Node');
    }

    /*
     * arp belongs to port
     */
    public function port()
    {
        return $this->belongsTo('\App\Port');
    }
}
