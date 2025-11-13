<?php

namespace App\Repositories;

use App\Models\FieldType;
use Illuminate\Database\Eloquent\Collection;

class FieldTypeRepository
{
    public function findById(int $id): ?FieldType
    {
        return FieldType::find($id);
    }

    public function findByName(string $name): ?FieldType
    {
        return FieldType::where('name', $name)->first();
    }

    public function all(): Collection
    {
        return FieldType::all();
    }
}
