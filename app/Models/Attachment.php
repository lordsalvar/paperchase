<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Attachment extends Model
{
    use HasUlids;

    protected $fillable = [
        'remarks',
        'files',
        'paths',
        'attachable',
    ];

    public function attachable(): MorphTo
    {
        return $this->morphTo();
    }
}
