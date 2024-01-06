<?php

namespace App\Exceptions;

use Exception;

class FundHasRelatedCompaniesException extends Exception
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
        return response()->json(['message' => "This Fund has active companies related. You must remove those companies before proceed."], 412);
    }
}
