<?php

declare(strict_types=1);

namespace App\Traits;

use App\Domain\Client\Exceptions\CustomException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait ControllerTrait
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        if (!empty($this->repository)) {
            return response()->json([$this->repository->index($request->all())])
                ->setStatusCode(Response::HTTP_OK, Response::$statusTexts[Response::HTTP_OK]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validators);
        if ($validator->fails()) {
            return response()->json([ $validator->errors()])
                ->setStatusCode(Response::HTTP_BAD_REQUEST, Response::$statusTexts[Response::HTTP_BAD_REQUEST]);
        }

        try {
            if (!empty($this->repository)) {
                $returnInsert = $this->repository->store($request->all());
                return response()->json([$returnInsert])
                    ->setStatusCode(Response::HTTP_CREATED, Response::$statusTexts[Response::HTTP_CREATED]);
            }

        } catch (CustomException $exception) {
            return responseHTTP($exception->getCode(), $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id)
    {
        try {
            $returnShow = $this->repository->getById($id);

            return responseHTTP(200, 'success', $returnShow);
        } catch (\Exception $exception) {
            return responseHTTP(404, $exception->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     *
     * @return JsonResponse
     */
    public function update(Request $request, int $id)
    {
        try {
            if (isset($this->repository)) {
                $returnUpdate = $this->repository->update($request->all(), $id);
                return response()->json([$returnUpdate])
                    ->setStatusCode(Response::HTTP_NO_CONTENT, Response::$statusTexts[Response::HTTP_NO_CONTENT]);
            }
        } catch (\Exception $exception) {
            return responseHTTP(Response::HTTP_NOT_FOUND, $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        try {
            $returnDestroy = $this->repository->destroy($id);

            return response()->json([$returnDestroy])
                ->setStatusCode(Response::HTTP_NO_CONTENT, Response::$statusTexts[Response::HTTP_NO_CONTENT]);
        } catch (\Exception $exception) {
            return responseHTTP(500, $exception->getMessage());
        }
    }

    /**
     * Check if possible remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function checkDelete(int $id)
    {
        $count = $this->repository->checkDelete($id);

        return responseHTTP(
            200,
            false,
            [
                'count' => $count,
                'haveRelationship' => ! empty($count),
            ]
        );
    }

    /**
     * Inactive the specified resource from storage.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function inactive(int $id)
    {
        try {
            return responseHTTP(200, 'success', $this->repository->inactive($id));
        } catch (\Exception $exception) {
            return responseHTTP($exception->getCode(), $exception->getMessage());
        }
    }
}
