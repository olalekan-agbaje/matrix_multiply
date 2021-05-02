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
        $data = $this->data();
        array_push($data['data'],[2, 9, 0]);

        Sanctum::actingAs(User::factory()->create());
        
        $response = $this
            ->withHeaders(['Accept' => 'application/json'])
            ->postJson('/api/MultiplyMatrix', $data);
        
        $response
            ->assertJsonValidationErrors(['data'])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['data'=>"Array count is invalid. Array count must be equal to 2"]);
    }

    public function testArray1ColumnsCountEqualArray2RowsCount()
    {
        $data = $this->data();
        array_push($data['data'][1],[2, 9, 0]);
        
        Sanctum::actingAs(User::factory()->create());

        $response = $this
            ->withHeaders(['Accept' => 'application/json'])
            ->postJson('/api/MultiplyMatrix', $data);

        $response
            ->assertJsonValidationErrors(['data'])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['data'=>"Number of columns in the 1st Matirx Must be equal to number of rows in the 2nd Matrix."]);
    }

    public function testArrayValuesArePositiveNumbers()
    {
        Sanctum::actingAs(User::factory()->create());
        
        $response = $this
            ->withHeaders(['Accept' => 'application/json'])
            ->postJson('/api/MultiplyMatrix', $this->negativeData());

        $response
            ->assertJsonValidationErrors(['data.0','data.1'])
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'data.0'=>"The array values are invalid. All values of both arrays must be zero or more.",
                'data.1'=>"The array values are invalid. All values of both arrays must be zero or more."
            ]);
    }

    public function testArrayMultiplicationIsValid()
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->post('/api/MultiplyMatrix', $this->data());

        $result = $response->getData();

        $response->assertStatus(200);

        $this->assertEquals($result, $this->correctResponse());        
    }

    public function testOnlyAuthenticatedUserIsAllowedToMultiplyMatrices()
    {
        $response = $this->post('/api/MultiplyMatrix', $this->data());

        $response->assertStatus(302);
    }

    private function am(array $newData)
    {
        return array_push($this->data(), $newData);
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

        return [
            'data'=>[
                $matrixA, $matrixB
            ]
        ];
    }

    private function negativeData()
    {
        $matrixA = [
            [3, 2, -1, 5],
            [9, 1, 3, 0],
        ];
        $matrixB = [
            [2, 9, 0],
            [1, 3, 5],
            [2, 4, -7],
            [8, 1, 5],
        ];

        $data = [
            'data'=>[
                $matrixA, $matrixB
            ]
        ];

        return $data;
    }
}
