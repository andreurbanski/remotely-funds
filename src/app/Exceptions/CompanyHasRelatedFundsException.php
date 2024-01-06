<?php

namespace App\Exceptions;

use Exception;

class CompanyHasRelatedFundsException extends Exception
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
        return response()->json(['message' => "This Company is related to one or more funds. You must remove those relations before proceed."], 412);
    }
}
