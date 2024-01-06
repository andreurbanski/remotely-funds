<?php

namespace App\Exceptions;

use Exception;

class ManagerHasRelatedFundsException extends Exception
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
        return response()->json(['message' => "This manager has active funds related. You must assign those funds to another manager before proceed."], 412);
    }
}
