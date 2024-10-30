<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Anchor_pc extends Model
{
    use  SoftDeletes;
    public $table = 'anchor_pcs';
    protected $fillable = [
        'numero',
        'switch',
        'patch_panel',
        'puerto',
        'maquina',
        'descripcion',
        'mac',
        'anclaje',
        'comentario',
        'rp',
        'direccionip',
        'vlan',
        'areas_id',
    ];

    public function area() { return $this->hasOne(Area::class,'id','areas_id'); }

}
