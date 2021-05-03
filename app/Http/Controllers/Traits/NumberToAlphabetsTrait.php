<?php

namespace App\Http\Controllers\Traits;

trait NumberToAlphabetsTrait
{
    /**
     * Convert number to alphabets recursively
     * @param int $num
     * @return string
     */
    public function numToAlpha(int $num): string
    {
        // fixed set of 26 uppercase letters to be used for the conversion
        $letters = [
          'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
          'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
        ];

        /**
         * decrement the number by one to account for zero based arrays,
         * get the integer value of the number divided by 26.
         * if the number is still greater than zero call the function again.
         * else return the character in the corresponding position
         */
        $num -= 1;

        $i = floor($num / 26);

        return $i > 0 ? $this->numToAlpha($i) . $letters[$num % 26] : $letters[$num % 26];
    }
    
    /**
     * Convert the numeric array to an alphabetic array
     * @var array $matrix
     * @return array
     */
    public function arrayNumToAlpha(array $matrix): array
    {
        // get the row and column count
        $row = count($matrix);
        $col = count($matrix[0]);

        /**
         * loop through the rows
         * loop through the columns
         * get the alphabetic equivalent of the number in this position
         */
        for ($i = 0; $i < $row; $i++) {

            for ($j = 0; $j < $col; $j++) {

                $matrix[$i][$j] = $this->numtoAlpha($matrix[$i][$j]);
            }
        }

        return $matrix;
    }
}
