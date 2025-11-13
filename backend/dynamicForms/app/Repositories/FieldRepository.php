<?php

namespace App\Repositories;

use App\Models\FormField;
use Illuminate\Database\Eloquent\Collection;

class FieldRepository
{
    public function findById(int $id): ?FormField
    {
        return FormField::with(['fieldType', 'options'])->find($id);
    }

    public function getFieldsByFormId(int $formId): Collection
    {
        return FormField::with(['fieldType', 'options'])
            ->where('form_id', $formId)
            ->orderBy('order')
            ->get();
    }

    public function create(array $data): FormField
    {
        return FormField::create($data);
    }

    public function update(FormField $field, array $data): bool
    {
        return $field->update($data);
    }

    public function delete(FormField $field): bool
    {
        return $field->delete();
    }

    public function bulkCreate(array $fields): bool
    {
        return FormField::insert($fields);
    }
}
