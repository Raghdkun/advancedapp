<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuerySubmissionRequest;
use App\Http\Requests\SubmitFormRequest;
use App\Services\SubmissionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function __construct(
        private SubmissionService $submissionService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $formId = $request->input('form_id');
        $perPage = $request->input('per_page', 15);

        if (!$formId) {
            return response()->json([
                'success' => false,
                'message' => 'form_id parameter is required',
            ], 400);
        }

        $submissions = $this->submissionService->getSubmissionsByFormId($formId, $perPage);

        return response()->json([
            'success' => true,
            'data' => $submissions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubmitFormRequest $request, int $formId): JsonResponse
    {
        try {
            $submission = $this->submissionService->submitForm(
                $formId,
                $request->input('data'),
                $request->input('user_id')
            );

            return response()->json([
                'success' => true,
                'message' => 'Form submitted successfully',
                'data' => $submission,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $submission = $this->submissionService->getSubmissionById($id);

        if (!$submission) {
            return response()->json([
                'success' => false,
                'message' => 'Submission not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $submission,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->submissionService->deleteSubmission($id);

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Submission not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Submission deleted successfully',
        ]);
    }

    /**
     * Query submissions by field values
     */
    public function query(QuerySubmissionRequest $request, int $formId): JsonResponse
    {
        $validated = $request->validated();

        if (isset($validated['field_id']) && isset($validated['value'])) {
            $submissions = $this->submissionService->querySubmissionsByFieldValue(
                $formId,
                $validated['field_id'],
                $validated['value']
            );
        } elseif (isset($validated['filters'])) {
            $submissions = $this->submissionService->querySubmissionsByMultipleFields(
                $formId,
                $validated['filters']
            );
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Either field_id with value or filters array is required',
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => $submissions,
        ]);
    }

    /**
     * Get submission statistics for a form
     */
    public function statistics(int $formId): JsonResponse
    {
        $statistics = $this->submissionService->getSubmissionStatistics($formId);

        return response()->json([
            'success' => true,
            'data' => $statistics,
        ]);
    }
}
