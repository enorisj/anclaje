<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Area extends Model
{
    use HasFactory;
    public $table = 'areas';
    protected $fillable = [
        'name',     
    ];

    public function anchor():HasMany { return $this->hasMany(Anchor_pc::class,'areas_id','id'); }
}
