<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateFieldRequest;
use App\Services\FieldService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    public function __construct(
        private FieldService $fieldService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $formId = $request->input('form_id');
        
        if (!$formId) {
            return response()->json([
                'success' => false,
                'message' => 'form_id parameter is required',
            ], 400);
        }

        $fields = $this->fieldService->getFieldsByFormId($formId);

        return response()->json([
            'success' => true,
            'data' => $fields,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateFieldRequest $request): JsonResponse
    {
        $field = $this->fieldService->createField($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Field created successfully',
            'data' => $field,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $field = $this->fieldService->getFieldById($id);

        if (!$field) {
            return response()->json([
                'success' => false,
                'message' => 'Field not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $field,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $field = $this->fieldService->updateField($id, $request->all());

        if (!$field) {
            return response()->json([
                'success' => false,
                'message' => 'Field not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Field updated successfully',
            'data' => $field,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->fieldService->deleteField($id);

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Field not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Field deleted successfully',
        ]);
    }
}
