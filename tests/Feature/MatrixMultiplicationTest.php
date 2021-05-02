<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MatrixMultiplicationTest extends TestCase
{
    use RefreshDatabase;

    public function testRequestContaintsOnlyTwoArrays()
    {
        Sanctum::actingAs(User::factory()->create());
        $response = $this->post('/api/MultiplyMatrix', $this->am([1]));

        $response->assertStatus(500);
    }

    public function testArray1ColumnsCountEqualArray2RowsCount()
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

    public function testOnlyAuthenticatedUserIsAllowedToMultiplyMatrices()
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

    private function am(array $newData)
    {
        return array_merge($this->data(), $newData);
    }

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
