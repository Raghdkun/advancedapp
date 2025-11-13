<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FieldOption extends Model
{
    protected $fillable = [
        'form_field_id',
        'value',
        'label',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    public function formField(): BelongsTo
    {
        return $this->belongsTo(FormField::class);
    }
}
