<?php

namespace App\Services;

use App\Models\FormSubmission;
use App\Repositories\FormRepository;
use App\Repositories\SubmissionRepository;
use App\Repositories\SubmissionFieldValueRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;

class SubmissionService
{
    public function __construct(
        private SubmissionRepository $submissionRepository,
        private SubmissionFieldValueRepository $fieldValueRepository,
        private FormRepository $formRepository
    ) {}

    public function getSubmissionById(int $id): ?FormSubmission
    {
        return $this->submissionRepository->findById($id);
    }

    public function getSubmissionsByFormId(int $formId, int $perPage = 15): LengthAwarePaginator
    {
        return $this->submissionRepository->getSubmissionsByFormId($formId, $perPage);
    }

    public function submitForm(int $formId, array $data, ?int $userId = null): FormSubmission
    {
        return DB::transaction(function () use ($formId, $data, $userId) {
            $form = $this->formRepository->findById($formId);
            
            if (!$form) {
                throw new \Exception('Form not found');
            }

            // Validate form submission
            $this->validateFormSubmission($form, $data);

            $submission = $this->submissionRepository->create([
                'form_id' => $formId,
                'submission_date' => now(),
                'user_id' => $userId,
            ]);

            foreach ($data as $fieldId => $value) {
                $this->fieldValueRepository->create([
                    'form_submission_id' => $submission->id,
                    'form_field_id' => $fieldId,
                    'value' => is_array($value) ? json_encode($value) : $value,
                ]);
            }

            return $this->submissionRepository->findById($submission->id);
        });
    }

    public function querySubmissionsByFieldValue(int $formId, int $fieldId, string $value): Collection
    {
        return $this->submissionRepository->queryByFieldValue($formId, $fieldId, $value);
    }

    public function querySubmissionsByMultipleFields(int $formId, array $filters): Collection
    {
        return $this->submissionRepository->queryByMultipleFieldValues($formId, $filters);
    }

    public function deleteSubmission(int $id): bool
    {
        $submission = $this->submissionRepository->findById($id);
        
        if (!$submission) {
            return false;
        }

        return $this->submissionRepository->delete($submission);
    }

    public function getSubmissionStatistics(int $formId): array
    {
        $submissions = $this->submissionRepository->getSubmissionsByFormId($formId, PHP_INT_MAX);
        
        return [
            'total_submissions' => $submissions->total(),
            'latest_submission' => $submissions->first()?->submission_date,
            'oldest_submission' => $submissions->last()?->submission_date,
        ];
    }

    private function validateFormSubmission($form, array $data): void
    {
        $rules = [];
        $messages = [];

        foreach ($form->fields as $field) {
            $fieldRules = [];

            if ($field->is_required) {
                $fieldRules[] = 'required';
            }

            if ($field->validation_rules) {
                if (is_array($field->validation_rules)) {
                    $fieldRules = array_merge($fieldRules, $field->validation_rules);
                }
            }

            if (!empty($fieldRules)) {
                $rules[$field->id] = $fieldRules;
                $messages[$field->id . '.required'] = "The {$field->label} field is required.";
            }
        }

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }
    }
}
