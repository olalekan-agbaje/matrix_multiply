<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Rules\OnlyIntValuesArray;
use App\Rules\ArrayCountIsExactlyTwo;
use App\Rules\ArrayColInAEqualsRowsInB;
use App\Matrix\MatrixMultiplier;

class MatirxMultiplyController extends Controller
{
    /**
     * retrieve the request content
     * validate the request
     * return any errors as json
     * @return array
     */
    public function index(): array
    {
        $rawArray = request()->all();
        
        $validated = request()->validate([            
            'data' => ['required','present','filled',new ArrayCountIsExactlyTwo,new ArrayColInAEqualsRowsInB],
            'data.*' => ['required','array', new OnlyIntValuesArray]
        ]);

        if (!$validated) {
            return response()->json(['errors' => $validated], 422);
        } 
         
        /**
         * if there are no errors load the data and process the arrays
         * get the column and row counts for each array
         * return the multiplied array
         */
        
        $matrix = new MatrixMultiplier($rawArray['data']);

        return $matrix->multiplyArrays();
    }
    
}
