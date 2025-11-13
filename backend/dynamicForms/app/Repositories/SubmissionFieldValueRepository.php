<?php

namespace App\Repositories;

use App\Models\SubmissionFieldValue;
use Illuminate\Database\Eloquent\Collection;

class SubmissionFieldValueRepository
{
    public function findById(int $id): ?SubmissionFieldValue
    {
        return SubmissionFieldValue::with(['formField', 'submission'])->find($id);
    }

    public function getValuesBySubmissionId(int $submissionId): Collection
    {
        return SubmissionFieldValue::with('formField')
            ->where('form_submission_id', $submissionId)
            ->get();
    }

    public function create(array $data): SubmissionFieldValue
    {
        return SubmissionFieldValue::create($data);
    }

    public function bulkCreate(array $values): bool
    {
        return SubmissionFieldValue::insert($values);
    }

    public function update(SubmissionFieldValue $value, array $data): bool
    {
        return $value->update($data);
    }

    public function delete(SubmissionFieldValue $value): bool
    {
        return $value->delete();
    }
}
