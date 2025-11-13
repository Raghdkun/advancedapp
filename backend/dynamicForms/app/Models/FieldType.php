<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FieldType extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function formFields(): HasMany
    {
        return $this->hasMany(FormField::class);
    }
}
