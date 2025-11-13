<?php

namespace App\Services;

use App\Models\Form;
use App\Repositories\FormRepository;
use App\Repositories\FieldRepository;
use App\Repositories\FieldOptionRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class FormService
{
    public function __construct(
        private FormRepository $formRepository,
        private FieldRepository $fieldRepository,
        private FieldOptionRepository $fieldOptionRepository
    ) {}

    public function getAllForms(): Collection
    {
        return $this->formRepository->all();
    }

    public function getActiveForms(): Collection
    {
        return $this->formRepository->getActiveForms();
    }

    public function getFormById(int $id): ?Form
    {
        return $this->formRepository->findById($id);
    }

    public function getActiveFormById(int $id): ?Form
    {
        return $this->formRepository->findActiveById($id);
    }

    public function createForm(array $data): Form
    {
        return DB::transaction(function () use ($data) {
            $formData = [
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'version' => $data['version'] ?? 1,
                'is_active' => $data['is_active'] ?? true,
            ];

            $form = $this->formRepository->create($formData);

            if (isset($data['fields']) && is_array($data['fields'])) {
                $this->createFormFields($form->id, $data['fields']);
            }

            return $this->formRepository->findById($form->id);
        });
    }

    public function updateForm(int $id, array $data): ?Form
    {
        return DB::transaction(function () use ($id, $data) {
            $form = $this->formRepository->findById($id);
            
            if (!$form) {
                return null;
            }

            $formData = array_filter([
                'name' => $data['name'] ?? null,
                'description' => $data['description'] ?? null,
                'version' => $data['version'] ?? null,
                'is_active' => $data['is_active'] ?? null,
            ], fn($value) => $value !== null);

            $this->formRepository->update($form, $formData);

            if (isset($data['fields']) && is_array($data['fields'])) {
                // Delete existing fields and recreate
                foreach ($form->fields as $field) {
                    $this->fieldRepository->delete($field);
                }
                $this->createFormFields($form->id, $data['fields']);
            }

            return $this->formRepository->findById($id);
        });
    }

    public function deleteForm(int $id): bool
    {
        $form = $this->formRepository->findById($id);
        
        if (!$form) {
            return false;
        }

        return $this->formRepository->delete($form);
    }

    private function createFormFields(int $formId, array $fields): void
    {
        foreach ($fields as $index => $fieldData) {
            $field = $this->fieldRepository->create([
                'form_id' => $formId,
                'label' => $fieldData['label'],
                'field_type_id' => $fieldData['field_type_id'],
                'validation_rules' => $fieldData['validation_rules'] ?? null,
                'order' => $fieldData['order'] ?? $index,
                'is_required' => $fieldData['is_required'] ?? false,
            ]);

            if (isset($fieldData['options']) && is_array($fieldData['options'])) {
                foreach ($fieldData['options'] as $optionIndex => $option) {
                    $this->fieldOptionRepository->create([
                        'form_field_id' => $field->id,
                        'value' => $option['value'],
                        'label' => $option['label'],
                        'order' => $option['order'] ?? $optionIndex,
                    ]);
                }
            }
        }
    }

    public function duplicateForm(int $id, ?int $newVersion = null): ?Form
    {
        return DB::transaction(function () use ($id, $newVersion) {
            $originalForm = $this->formRepository->findById($id);
            
            if (!$originalForm) {
                return null;
            }

            $newFormData = [
                'name' => $originalForm->name . ' (Copy)',
                'description' => $originalForm->description,
                'version' => $newVersion ?? ($originalForm->version + 1),
                'is_active' => false,
            ];

            $newForm = $this->formRepository->create($newFormData);

            foreach ($originalForm->fields as $field) {
                $newField = $this->fieldRepository->create([
                    'form_id' => $newForm->id,
                    'label' => $field->label,
                    'field_type_id' => $field->field_type_id,
                    'validation_rules' => $field->validation_rules,
                    'order' => $field->order,
                    'is_required' => $field->is_required,
                ]);

                foreach ($field->options as $option) {
                    $this->fieldOptionRepository->create([
                        'form_field_id' => $newField->id,
                        'value' => $option->value,
                        'label' => $option->label,
                        'order' => $option->order,
                    ]);
                }
            }

            return $this->formRepository->findById($newForm->id);
        });
    }
}
