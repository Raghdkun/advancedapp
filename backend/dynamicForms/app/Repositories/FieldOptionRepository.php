<?php

namespace App\Repositories;

use App\Models\FieldOption;
use Illuminate\Database\Eloquent\Collection;

class FieldOptionRepository
{
    public function findById(int $id): ?FieldOption
    {
        return FieldOption::find($id);
    }

    public function getOptionsByFieldId(int $fieldId): Collection
    {
        return FieldOption::where('form_field_id', $fieldId)
            ->orderBy('order')
            ->get();
    }

    public function create(array $data): FieldOption
    {
        return FieldOption::create($data);
    }

    public function update(FieldOption $option, array $data): bool
    {
        return $option->update($data);
    }

    public function delete(FieldOption $option): bool
    {
        return $option->delete();
    }

    public function bulkCreate(array $options): bool
    {
        return FieldOption::insert($options);
    }

    public function deleteByFieldId(int $fieldId): void
    {
        FieldOption::where('form_field_id', $fieldId)->delete();
    }
}
