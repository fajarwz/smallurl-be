<?php

function apiResponse($data = null, $message = null, $code = 404, $status = 'error') {
    return [
        'meta' => [
            'code' => $code,
            'status' => $status,
            'message' => $message,
        ],
        'data' => $data,
    ];
}

function successResponse($data = null, $message = null)
{
    return response()->json(
        apiResponse($data, $message, 200, 'success'), 200
    );
}

function errorResponse($data = null, $message = null, $code = 400)
{
    return response()->json(
        apiResponse($data, $message, $code), $code
    );
}