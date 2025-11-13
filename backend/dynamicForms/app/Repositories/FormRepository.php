<?php

namespace App\Repositories;

use App\Models\Form;
use Illuminate\Database\Eloquent\Collection;

class FormRepository
{
    public function findById(int $id): ?Form
    {
        return Form::with(['fields.fieldType', 'fields.options'])->find($id);
    }

    public function findActiveById(int $id): ?Form
    {
        return Form::with(['fields.fieldType', 'fields.options'])
            ->where('is_active', true)
            ->find($id);
    }

    public function all(): Collection
    {
        return Form::with(['fields.fieldType', 'fields.options'])->get();
    }

    public function getActiveForms(): Collection
    {
        return Form::with(['fields.fieldType', 'fields.options'])
            ->where('is_active', true)
            ->get();
    }

    public function create(array $data): Form
    {
        return Form::create($data);
    }

    public function update(Form $form, array $data): bool
    {
        return $form->update($data);
    }

    public function delete(Form $form): bool
    {
        return $form->delete();
    }

    public function getFormsByVersion(int $version): Collection
    {
        return Form::with(['fields.fieldType', 'fields.options'])
            ->where('version', $version)
            ->get();
    }
}
