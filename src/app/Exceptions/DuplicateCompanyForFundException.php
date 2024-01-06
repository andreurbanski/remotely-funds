<?php

namespace App\Exceptions;

use Exception;

class DuplicateCompanyForFundException extends Exception
{
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
        //
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @return String
     */
    public function render()
    {
        return response()->json(['message' => "This company is alread listed in this Fund"], 409);
    }
}
