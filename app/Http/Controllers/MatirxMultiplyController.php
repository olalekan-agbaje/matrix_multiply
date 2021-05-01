<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class MatirxMultiplyController extends Controller
{
    public int $arrayCount;
    public array $array1;
    public array $array2;
    public int $array1ColCount;
    public int $array1RowCount;
    public int $array2ColCount;
    public int $array2RowCount;

    public function index()
    {
        $rawArray = request()->all();
        
        $this->arrayCount = $this->countArray($rawArray);

        $this->arrayCountIsValid();

        $this->array1 = $rawArray[0];
        $this->array2 = $rawArray[1];

        $this->Array1ColumnsEqualArray2Rows();

        return ($this->multiplyArrays());
        
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

        return $output;
        
    }

    private function countArray(array $rawArray): int
    {
        return count($rawArray);
    }

    private function arrayCountIsValid() : bool
    {
        if($this->arrayCount != 2)
        {
            throw new Exception("Array count is invalid. Array count must be equal to 2", 500);             
        }

        return true;
    }

    private function Array1ColumnsEqualArray2Rows(): bool
    {
        if(count($this->array1[0]) != count($this->array2))
        {
            throw new Exception("Number of columns in the 1st Matirx Must be equal to number of rows in the 2nd Matrix.", 500);             
        }

        $this->array1ColCount = count($this->array1[0]);
        $this->array1RowCount = count($this->array1);
        $this->array2ColCount = count($this->array2[0]);
        $this->array2RowCount = count($this->array2);

        return true;
    }
}
