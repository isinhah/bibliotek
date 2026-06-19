<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'title',
        'isbn',
        'stock',
        'author_id',
        'category_id',
        'cover_id'
    ];

    public function author(): BelongsTo {
        return $this->belongsTo(Author::class);
    }

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class)->withTrashed();
    }

    public function loans(): HasMany {
        return $this->hasMany(Loan::class);
    }

    public function usersWhoSaved()
    {
        return $this->belongsToMany(User::class, 'book_user_reading_list')->withTimestamps();
    }
}
