<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class MatrixValidationTest extends TestCase
{

    public function testRequestContaintsTwoArrays()
    {
        Sanctum::actingAs(User::factory()->create());
        $response = $this->post('/api/MultiplyMatrix', $this->am([1]));

        $response->assertStatus(500);
    }

    public function testOnlyAuthedUserAllowed()
    {

        $badArray = [
            1 => [
                [2, 9, 0],
                [2, 9, 0],
            ]
        ];
        
        $response = $this->post('/api/MultiplyMatrix', $this->am($badArray));

        $response->assertStatus(302);
    }

    public function testArray1ColumnsEqualArray2Rows()
    {
        $badArray = [
            1 => [
                [2, 9, 0],
                [2, 9, 0],
            ]
        ];
        Sanctum::actingAs(User::factory()->create());
        $response = $this->post('/api/MultiplyMatrix', $this->am($badArray));

        $response->assertStatus(500);
    }

    public function testArrayValuesArePositiveNumbers()
    {
        // $this->withoutExceptionHandling();
        Sanctum::actingAs(User::factory()->create());
        $response = $this->post('/api/MultiplyMatrix', $this->negativeData());
        $response->assertStatus(500);
    }

    public function testArrayMultiplicationIsValid()
    {
        Sanctum::actingAs(User::factory()->create());
        $response = $this->post('/api/MultiplyMatrix', $this->data());
        $result = $response->getData();

        $this->assertEquals($result, $this->correctResponse());
    }

    private function am(array $newData)
    {
        return array_merge($this->data(), $newData);
    }

    // private function correctNumericResponse()
    // {
    //     return [
    //         [50, 42, 42],
    //         [25, 96, 26]
    //     ];
    // }

    private function correctResponse()
    {
        return [
            ["AX", "AP", "AP"],
            ["Y", "CR", "Z"]
        ];
    }

    private function data()
    {
        $matrixA = [
            [3, 2, 1, 5],
            [9, 1, 3, 0],
        ];
        $matrixB = [
            [2, 9, 0],
            [1, 3, 5],
            [2, 4, 7],
            [8, 1, 5],
        ];

        $data = [
            $matrixA, $matrixB
        ];

        return $data;
    }

    private function negativeData()
    {
        $matrixA = [
            [3, 2, 1, 5],
            [9, 1, 3, 0],
        ];
        $matrixB = [
            [2, 9, 0],
            [1, 3, 5],
            [2, 4, -7],
            [8, 1, 5],
        ];

        $data = [
            $matrixA, $matrixB
        ];

        return $data;
    }
}
