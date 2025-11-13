<?php

namespace App\Repositories;

use App\Models\FormSubmission;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class SubmissionRepository
{
    public function findById(int $id): ?FormSubmission
    {
        return FormSubmission::with(['fieldValues.formField', 'form'])->find($id);
    }

    public function getSubmissionsByFormId(int $formId, int $perPage = 15): LengthAwarePaginator
    {
        return FormSubmission::with(['fieldValues.formField'])
            ->where('form_id', $formId)
            ->orderBy('submission_date', 'desc')
            ->paginate($perPage);
    }

    public function create(array $data): FormSubmission
    {
        return FormSubmission::create($data);
    }

    public function delete(FormSubmission $submission): bool
    {
        return $submission->delete();
    }

    public function queryByFieldValue(int $formId, int $fieldId, string $value): Collection
    {
        return FormSubmission::whereHas('fieldValues', function ($query) use ($fieldId, $value) {
            $query->where('form_field_id', $fieldId)
                ->where('value', 'LIKE', "%{$value}%");
        })
            ->where('form_id', $formId)
            ->with(['fieldValues.formField'])
            ->get();
    }

    public function queryByMultipleFieldValues(int $formId, array $filters): Collection
    {
        return FormSubmission::where('form_id', $formId)
            ->whereHas('fieldValues', function ($query) use ($filters) {
                foreach ($filters as $filter) {
                    $query->where(function ($q) use ($filter) {
                        $q->where('form_field_id', $filter['field_id'])
                            ->where('value', $filter['operator'] ?? 'LIKE', $filter['value']);
                    });
                }
            })
            ->with(['fieldValues.formField'])
            ->get();
    }
}
