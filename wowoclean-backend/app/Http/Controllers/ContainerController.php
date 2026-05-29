<?php

namespace App\Http\Controllers;

use App\Models\Container;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContainerController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $containers = Container::with('trackingLogs')->get();
        return $this->successResponse($containers, 'Containers retrieved successfully');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'container_id' => ['required', 'string', 'unique:containers,container_id', 'regex:/^[A-Za-z]{2}\d{5}$/'],
            'waste_type' => 'required|string',
            'weight_kg' => 'required|numeric|min:10|max:5000',
        ]);

        $validator->after(function ($validator) use ($request) {
            if (strtolower($request->waste_type) === 'chemical' && $request->weight_kg > 1000) {
                $validator->errors()->add('weight_kg', 'Chemical waste weight cannot exceed 1000 kg.');
            }
        });

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', 422, $validator->errors());
        }

        $container = Container::create([
            'container_id' => strtoupper($request->container_id),
            'waste_type' => $request->waste_type,
            'weight_kg' => $request->weight_kg,
            'status' => 'Active',
        ]);

        return $this->successResponse($container, 'Container created successfully', 201);
    }

    public function show($id)
    {
        $container = Container::with('trackingLogs')->find($id);

        if (!$container) {
            return $this->errorResponse('Container not found', 404);
        }

        return $this->successResponse($container, 'Container retrieved successfully');
    }

    public function updateStatus(Request $request, $id)
    {
        $container = Container::find($id);

        if (!$container) {
            return $this->errorResponse('Container not found', 404);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:Active,Archived',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', 422, $validator->errors());
        }

        $container->update([
            'status' => $request->status
        ]);

        return $this->successResponse($container, 'Container status updated successfully');
    }

    public function destroy($id)
    {
        $container = Container::find($id);

        if (!$container) {
            return $this->errorResponse('Container not found', 404);
        }

        $container->delete();

        return $this->successResponse(null, 'Container deleted successfully');
    }

    public function search(Request $request)
    {
        $query = Container::query();

        if ($request->has('type')) {
            $query->where('waste_type', $request->type);
        }

        if ($request->has('min_weight')) {
            $query->where('weight_kg', '>=', $request->min_weight);
        }

        $containers = $query->with('trackingLogs')->get();

        return $this->successResponse($containers, 'Search results retrieved successfully');
    }

    public function logs($id)
    {
        $container = Container::with('trackingLogs')->find($id);

        if (!$container) {
            return $this->errorResponse('Container not found', 404);
        }

        return $this->successResponse($container->trackingLogs, 'Tracking logs retrieved successfully');
    }
}