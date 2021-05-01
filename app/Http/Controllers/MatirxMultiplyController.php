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

    public function index()
    {        
        $rawArray = request()->all();
        
        $this->arrayCount = $this->countArray($rawArray);

        $this->arrayCountIsValid();

        $this->array1 = $rawArray[0];
        $this->array2 = $rawArray[1];

        $this->Array1ColumnsEqualArray2Rows();
        

        dd($this->arrayCount);
        
    }

    private function countArray(array $rawArray)
    {
        return count($rawArray);
    }

    private function arrayCountIsValid()
    {
        if($this->arrayCount != 2)
        {
            throw new Exception("Array count is invalid. Array count must be equal to 2", 500);             
        }

        return true;
    }

    private function Array1ColumnsEqualArray2Rows()
    {
        if(count($this->array1[0]) != count($this->array2))
        {
            throw new Exception("Number of columns in the 1st Matirx Must be equal to number of rows in the 2nd Matrix.", 500);             
        }

        return true;
    }
}
