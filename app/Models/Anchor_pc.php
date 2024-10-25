<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'description',
        'mac',
        'anclaje',
        'comentario',
        'rp',
        'direccionip',
        'vlan',
        'areas_id',
    ];

    public function areas():BelongsTo { return $this->belongsTo(Area::class,'areas_id','id'); }

}
