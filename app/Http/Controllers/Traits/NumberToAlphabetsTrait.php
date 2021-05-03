<?php

namespace App\Http\Controllers\Traits;

trait NumberToAlphabetsTrait
{

  public function NumToAlpha(int $num): string
  {
    $letters = [
      'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
      'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
    ];

    $num -= 1;

    $i = floor($num / 26);

    return $i > 0 ? $this->NumToAlpha($i) . $letters[$num % 26] : $letters[$num % 26];

  }
  
  private function arrayNumToAlpha(array $matrix): array
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
