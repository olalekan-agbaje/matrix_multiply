<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MatrixValidationTest extends TestCase
{
    
    public function testRequestContaintsTwoArrays()
    {
        $response = $this->post('/api', $this->am([1]));

        $response->assertStatus(500);
    }

    public function testArray1ColumnsEqualArray2Rows()
    {
        // $this->withoutExceptionHandling();
        $response = $this->post('/api', $this->data());

        $response->assertStatus(500);
    }

    private function am(array $newData)
    {
        return array_merge($this->data(),$newData);
    }

    public function data()
    {
        $matrixA = [
            [3,2,1,5],
            [9,1,3,0],
        ];
        $matrixB = [
            [2,9,0],
            [2,9,0],
            [1,3,5],
            [2,4,7],
            [8,1,5],
        ];

        $data = [
            $matrixA, $matrixB
        ]; 

        return $data;
    }
}
