<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Office extends Model
{
    use HasUlids, SoftDeletes;

    protected $fillable = [
        'acronym',
        'name',
        'head_name',
        'designation',
    ];

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
