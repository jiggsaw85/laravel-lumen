<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Position;
use App\Rules\ValidatePositionType;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;

class PositionController extends Controller
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
        return response()->json(Position::all(), Response::HTTP_OK);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return response()->json(Position::find($id), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request): JsonResponse
    {
        $this->validate($request, [
            'name' => ['required'],
            'type' => ['required',  new ValidatePositionType()]
        ]);

        $position = Position::create($request->all());

        return response()->json($position, Response::HTTP_CREATED);
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
            'type' => 'sometimes|required',
        ]);

        try {
            $position = Position::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            $this->logger->error($exception->getMessage());

            return response()->json('Position not found.', Response::HTTP_NOT_FOUND);
        }

        $position->update($request->all());

        return response()->json($position, Response::HTTP_OK);
    }

    /**
     * @param int $id
     * @return JsonResponse|\Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function delete(int $id)
    {
        try {
            $position = Position::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            $this->logger->error($exception->getMessage());

            return response()->json('Position not found.', Response::HTTP_NOT_FOUND);
        }

        $position->delete();

        return response('Position deleted successfully', Response::HTTP_OK);
    }
}
