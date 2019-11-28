<?php

namespace App\Responders;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class JsonResponder
{

    public function __invoke(?array $data, int $statusCode = Response::HTTP_OK, array $addHeaders = [])
    {
        return new JsonResponse(
            $data,
            $statusCode,
            array_merge(
                [
                    'Content-Type' => 'application/json'
                ],
                $addHeaders
            )
        );
    }
}
