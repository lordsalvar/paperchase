<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Document extends Model
{
    use HasUlids;

    protected $fillable = [
        'code',
        'title',
        'user_id',
        'office_id',
        'section_id',
        'source_id',
        'digtal',
        'directive',
    ];

    public function classifications(): BelongsTo
    {
        return $this->belongsTo(Classification::class);
    }

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function offices(): BelongsTo
    {
        return $this->belongsTo(Office::class);
    }

    public function sections(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function sources(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }

    // transmittal
    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function transmittals(): HasMany
    {
        return $this->hasMany(Transmittal::class);
    }
}
