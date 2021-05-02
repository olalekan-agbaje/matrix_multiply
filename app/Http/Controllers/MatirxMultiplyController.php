<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Exception;
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

    public function index()
    {
        $rawArray = request()->all();
        
        $validated = request()->validate([            
            'data' => ['required',function($attribute, $value, $fail){
                    if (count($value) != 2) {
                        $fail("Array count is invalid. Array count must be equal to 2");
                    }
                },
                function($attribute, $value, $fail){
                    if (count($value[0][1]) != count($value[1])) {
                        $fail("Number of columns in the 1st Matirx Must be equal to number of rows in the 2nd Matrix.");
                    }
                }
            ],
            'data.*' => ['required','array',function($attribute, $value, $fail) {
    
                array_walk_recursive($value, function ($v, $k, $fail) {

                    if ($v < 0) {
                        $fail("The array values are invalid. All values of both arrays must be zero or more.");
                    };

                }, $fail);    
            }]
        ]);

        if (!$validated) {
            return response()->json(['errors' => $rawArray->message()], 422);
        } 

        $rawArray = $rawArray['data'];
        $this->array1 = $rawArray[0];
        $this->array2 = $rawArray[1];

        $this->array1ColCount = count($this->array1[0]);
        $this->array1RowCount = count($this->array1);
        $this->array2ColCount = count($this->array2[0]);
        $this->array2RowCount = count($this->array2);

        return $this->multiplyArrays();
    }

    private function multiplyArrays(): array
    {
        /* we perfom the array multiplication here */
        $r = $this->array1RowCount;
        $c = $this->array2ColCount;
        $r2 = $this->array2RowCount;

        $output = [];

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

    private function arrayNumToAlpha(array $matrix)
    {
        $row = count($matrix);
        $col = count($matrix[0]);

        for ($i = 0; $i < $row; $i++) {

            for ($j = 0; $j < $col; $j++) {

                $matrix[$i][$j] = $this->numtoAlpha($matrix[$i][$j]);
            }
        }

        return $matrix;
    }    
}
