<?php

namespace App\Services;

use App\Models\FormField;
use App\Repositories\FieldRepository;
use App\Repositories\FieldOptionRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class FieldService
{
    public function __construct(
        private FieldRepository $fieldRepository,
        private FieldOptionRepository $fieldOptionRepository
    ) {}

    public function getFieldById(int $id): ?FormField
    {
        return $this->fieldRepository->findById($id);
    }

    public function getFieldsByFormId(int $formId): Collection
    {
        return $this->fieldRepository->getFieldsByFormId($formId);
    }

    public function createField(array $data): FormField
    {
        return DB::transaction(function () use ($data) {
            $field = $this->fieldRepository->create([
                'form_id' => $data['form_id'],
                'label' => $data['label'],
                'field_type_id' => $data['field_type_id'],
                'validation_rules' => $data['validation_rules'] ?? null,
                'order' => $data['order'] ?? 0,
                'is_required' => $data['is_required'] ?? false,
            ]);

            if (isset($data['options']) && is_array($data['options'])) {
                foreach ($data['options'] as $index => $option) {
                    $this->fieldOptionRepository->create([
                        'form_field_id' => $field->id,
                        'value' => $option['value'],
                        'label' => $option['label'],
                        'order' => $option['order'] ?? $index,
                    ]);
                }
            }

            return $this->fieldRepository->findById($field->id);
        });
    }

    public function updateField(int $id, array $data): ?FormField
    {
        return DB::transaction(function () use ($id, $data) {
            $field = $this->fieldRepository->findById($id);
            
            if (!$field) {
                return null;
            }

            $fieldData = array_filter([
                'label' => $data['label'] ?? null,
                'field_type_id' => $data['field_type_id'] ?? null,
                'validation_rules' => $data['validation_rules'] ?? null,
                'order' => $data['order'] ?? null,
                'is_required' => $data['is_required'] ?? null,
            ], fn($value) => $value !== null);

            $this->fieldRepository->update($field, $fieldData);

            if (isset($data['options']) && is_array($data['options'])) {
                // Delete existing options and recreate
                $this->fieldOptionRepository->deleteByFieldId($field->id);
                
                foreach ($data['options'] as $index => $option) {
                    $this->fieldOptionRepository->create([
                        'form_field_id' => $field->id,
                        'value' => $option['value'],
                        'label' => $option['label'],
                        'order' => $option['order'] ?? $index,
                    ]);
                }
            }

            return $this->fieldRepository->findById($id);
        });
    }

    public function deleteField(int $id): bool
    {
        $field = $this->fieldRepository->findById($id);
        
        if (!$field) {
            return false;
        }

        return $this->fieldRepository->delete($field);
    }

    public function parseValidationRules(array $rules): array
    {
        return $rules;
    }
}
