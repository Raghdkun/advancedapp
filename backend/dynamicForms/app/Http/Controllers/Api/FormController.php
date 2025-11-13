<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateFormRequest;
use App\Http\Requests\UpdateFormRequest;
use App\Services\FormService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function __construct(
        private FormService $formService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $forms = $request->has('active_only') && $request->active_only
            ? $this->formService->getActiveForms()
            : $this->formService->getAllForms();

        return response()->json([
            'success' => true,
            'data' => $forms,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateFormRequest $request): JsonResponse
    {
        $form = $this->formService->createForm($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Form created successfully',
            'data' => $form,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $form = $this->formService->getFormById($id);

        if (!$form) {
            return response()->json([
                'success' => false,
                'message' => 'Form not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $form,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFormRequest $request, int $id): JsonResponse
    {
        $form = $this->formService->updateForm($id, $request->validated());

        if (!$form) {
            return response()->json([
                'success' => false,
                'message' => 'Form not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Form updated successfully',
            'data' => $form,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->formService->deleteForm($id);

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Form not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Form deleted successfully',
        ]);
    }

    /**
     * Duplicate a form
     */
    public function duplicate(int $id, Request $request): JsonResponse
    {
        $newForm = $this->formService->duplicateForm($id, $request->input('version'));

        if (!$newForm) {
            return response()->json([
                'success' => false,
                'message' => 'Form not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Form duplicated successfully',
            'data' => $newForm,
        ], 201);
    }
}
