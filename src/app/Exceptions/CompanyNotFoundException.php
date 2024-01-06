<?php

namespace App\Exceptions;

use Exception;

class CompanyNotFoundException extends Exception
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
        return response()->json(['message' => "Company not found"], 404);
    }
}
