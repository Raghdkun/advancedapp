<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FormField extends Model
{
    protected $fillable = [
        'form_id',
        'label',
        'field_type_id',
        'validation_rules',
        'order',
        'is_required',
    ];

    protected $casts = [
        'validation_rules' => 'array',
        'is_required' => 'boolean',
        'order' => 'integer',
    ];

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function fieldType(): BelongsTo
    {
        return $this->belongsTo(FieldType::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(FieldOption::class)->orderBy('order');
    }

    public function submissionValues(): HasMany
    {
        return $this->hasMany(SubmissionFieldValue::class);
    }
}
