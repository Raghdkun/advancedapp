<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\FieldTypeRepository;
use Illuminate\Http\JsonResponse;

class FieldTypeController extends Controller
{
    public function __construct(
        private FieldTypeRepository $fieldTypeRepository
    ) {}

    /**
     * Display a listing of all field types
     */
    public function index(): JsonResponse
    {
        $fieldTypes = $this->fieldTypeRepository->all();

        return response()->json([
            'success' => true,
            'data' => $fieldTypes,
        ]);
    }

    /**
     * Display the specified field type
     */
    public function show(int $id): JsonResponse
    {
        $fieldType = $this->fieldTypeRepository->findById($id);

        if (!$fieldType) {
            return response()->json([
                'success' => false,
                'message' => 'Field type not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $fieldType,
        ]);
    }
}
