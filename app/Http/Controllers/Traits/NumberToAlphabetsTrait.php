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
}
