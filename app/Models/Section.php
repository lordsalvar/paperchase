<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Section extends Model
{
    use HasUlids;

    protected $fillable = ['name', 'office_id', 'head_name', 'designation'];

    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class);
    }
}
