<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Rules\OnlyIntValuesArray;
use App\Rules\ArrayCountIsExactlyTwo;
use App\Rules\ArrayColInAEqualsRowsInB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Traits\NumberToAlphabetsTrait;

class MatirxMultiplyController extends Controller
{
    use NumberToAlphabetsTrait;

    private array $array1;
    private array $array2;
    private int $array1ColCount;
    private int $array1RowCount;
    private int $array2ColCount;
    private int $array2RowCount;

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
            return response()->json(['errors' => $rawArray->message()], 422);
        } 
         
        /**
         * if there are no errors load the data and process the arrays
         * get the column and row counts for each array
         * return the multiplied array
         */
        $rawArray = $rawArray['data'];
        $this->array1 = $rawArray[0];
        $this->array2 = $rawArray[1];

        $this->array1ColCount = count($this->array1[0]);
        $this->array1RowCount = count($this->array1);
        $this->array2ColCount = count($this->array2[0]);
        $this->array2RowCount = count($this->array2);

        return $this->multiplyArrays();
    }

    /**
     * perform array multiplication
     * @return array
     */
    private function multiplyArrays(): array
    {
        // initialise the row and columns of the arrays
        $r = $this->array1RowCount;
        $c = $this->array2ColCount;
        $r2 = $this->array2RowCount;

        // initialize an output array to hold the numeric result of the multiplication
        $output = [];

        /*loop through the rows of the first array
        * loop through the columns of the second array
        * initialize the current cell
        * loop through each of the rows of the second array
        * perform the multiplicatoin of cell in array 1 and array 2 
        * while adding the result to get the total value for the current cell
        * convert the array using the NumberToAlphabetsTrait
        */
        for ($i = 0; $i < $r; $i++) {

            for ($j = 0; $j < $c; $j++) {

                $output[$i][$j] = 0;

                for ($k = 0; $k < $r2; $k++) {

                    $output[$i][$j] += $this->array1[$i][$k] * $this->array2[$k][$j];
                }
            }
        }

        return $this->arrayNumToAlpha($output);
    }
    
}
