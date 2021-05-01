<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class MatirxMultiplyController extends Controller
{
    public int $arrayCount;

    public function index()
    {        
        $rawArray = request()->all();
        
        $this->arrayCount = count($rawArray);

        if($this->arrayCount != 2)
        {
            throw new Exception("Array count is invalid. Array count must be equal to 2", 1);             
        }

        dd($this->arrayCount);
        
    }
}
