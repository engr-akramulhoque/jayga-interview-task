<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttributeRequest;
use App\Http\Requests\UpdateAttributeRequest;
use App\Http\Resources\AttributeResource;
use App\Models\Attribute;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'status' => true,
            'data' => AttributeResource::collection(Attribute::latest()->get())
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAttributeRequest $request)
    {
        $attribute = Attribute::create($request->validated());

        return response()->json([
            'status' => true,
            'data' => new AttributeResource($attribute)
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Attribute $attribute)
    {
        return response()->json([
            'status' => true,
            'data' => new AttributeResource($attribute)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAttributeRequest $request, Attribute $attribute)
    {
        $attribute->update($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Attribute updated successfully',
            'data' => new AttributeResource($attribute)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attribute $attribute)
    {
        $attribute->delete();

        return response()->json([
            'status' => true,
            'message' => 'Attribute deleted successfully'
        ], 200);
    }
}
