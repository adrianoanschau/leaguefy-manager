<?php

namespace Leaguefy\LeaguefyManager\Exceptions;

use Exception;
use Throwable;

class LeaguefyManagerApiException extends Exception
{
    private $codeMap = [
        '23503' => 409, //QueryException: Foreign key violation
    ];

    private $messageMap = [
        '23503' => 'Conflict',
    ];

    public function __construct(Throwable $e)
    {
        $message = $this->messageMap[$e->getCode()] ?? 'Internal Server Error';
        $code = $this->codeMap[$e->getCode()] ?? 500;

        parent::__construct($message, $code);
    }

    public function render()
    {
        $render = [
            'status' => $this->getCode() < 400,
            'message' => $this->getMessage(),
        ];

        if (env('APP_ENV') === 'local') {
            $render['trace'] = $this->getTrace();
        }

        return $render;
    }
}
