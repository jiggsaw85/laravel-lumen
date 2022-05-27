<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use App\Rules\ValidateSuperiorPosition;
use App\Services\EmployeeService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends Controller
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return JsonResponse
     */
    public function showAll(): JsonResponse
    {
        if (Auth::user()) {
            return response()->json(Employee::all(), Response::HTTP_OK);
        }
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return response()->json(Employee::find($id), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request): JsonResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'position_id' => 'required',
            'superior_id' => ['sometimes', 'required', new ValidateSuperiorPosition()],
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d|after:start_date'
        ]);

        $employee = Employee::create($request->all());

        return response()->json($employee, Response::HTTP_CREATED);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(int $id, Request $request): JsonResponse
    {
        $this->validate($request, [
            'name' => 'sometimes|required',
            'position_id' => 'sometimes|required',
            'superior_id' => ['sometimes', 'required', new ValidateSuperiorPosition()],
            'start_date' => 'sometimes|required|date_format:Y-m-d',
            'end_date' => 'sometimes|required|date_format:Y-m-d|after:start_date'
        ]);

        try {
            $employee = Employee::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            $this->logger->error($exception->getMessage());

            return response()->json('Employee not found.', Response::HTTP_NOT_FOUND);
        }

        $employee->update($request->all());

        return response()->json($employee, Response::HTTP_OK);
    }

    /**
     * @param int $id
     * @return JsonResponse|\Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function delete(int $id)
    {
        try {
            $employee = Employee::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            $this->logger->error($exception->getMessage());

            return response()->json('Employee not found.', Response::HTTP_NOT_FOUND);
        }

        $employee->delete();

        return response('Employee deleted successfully', Response::HTTP_OK);
    }

    public function showSuperiorEmployees($id)
    {
        $employee = Employee::findOrFail($id);

        return response()->json($employee->superiorEmployees, Response::HTTP_OK);
    }
}
