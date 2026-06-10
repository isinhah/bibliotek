<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{

    use softDeletes;

    protected $fillable = ['name'];

    public function books(): HasMany {
        return $this->hasMany(Book::class);
    }
}
