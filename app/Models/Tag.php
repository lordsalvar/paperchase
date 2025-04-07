<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasUlids;

    protected $fillable = ['tag'];

    public function documents()
    {
        return $this->belongsToMany(Document::class);
    }
}
