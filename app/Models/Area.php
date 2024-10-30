<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use SoftDeletes;
    public $table = 'areas';
    protected $fillable = [
        'name',     
    ];

    public function anchor():HasMany { return $this->hasMany(Anchor_pc::class,'areas_id','id'); }
}
