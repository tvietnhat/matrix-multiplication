<?php 

declare(strict_types = 1);

namespace Tests\Unit;

use Exception;
use PHPUnit\Framework\TestCase;
use App\Models\Matrix;
use App\Models\MatrixException;
use vermotr\Math\Matrix as VMatrix;

class MatrixTest extends TestCase
{
    /**
     * converted number from alphabet notation to decimal notation.
     * @throws Exception
     * @return int
     */
    private static function charToInt(string $val) : int
    {
        if ($val === '') return 0;
        
        $matches = [];
        preg_match('/^\-*([A-Z]+)$/', $val, $matches);
        if (empty($matches)) {
            throw new Exception("Invalid alphabet notation: " . "$val : " . json_encode($matches));
        }
        
        $absVal = $matches[0];
        $base = ord('Z') - ord('A') + 1;
        $result = 0;
        
        for ($i = 0; $i < strlen($absVal); $i++) {
            $digit = $absVal[strlen($absVal) - 1 - $i];
            $result += pow($base, $i) * (ord($digit) - ord('A') + 1);
        }
        
        if (strpos($val, '-') === 0) {
            $result *= -1;
        }
        
        return $result;
    }
    
    /**
     * test matrices cannot be multiplied.
     *
     * @return void
     */
    public function testMatricesCannotBeMultiplied()
    {
        $matrix1 = Matrix::random(39, 30, 20);
        $matrix2 = Matrix::random(10, 50, 20);
        $this->assertFalse( $matrix1->canMultiplyWith($matrix2) );
    }

    /**
     * test matrices can be multiplied.
     *
     * @return void
     */
    public function testMatricesCanBeMultiplied()
    {
        $matrix1 = Matrix::random(39, 10, 20);
        $matrix2 = Matrix::random(10, 50, 20);
        $this->assertTrue( $matrix1->canMultiplyWith($matrix2) );
    }

    /**
     * test matrices multiplication result.
     *
     * @return void
     */
    public function testMatricesMultiplicationResult()
    {
        $matrix1 = Matrix::random(39, 30, 20);
        $matrix2 = Matrix::random(30, 50, 20);
        
        $matrixMultiplied = $matrix1->multiply($matrix2);

        $vMatrix1 = new VMatrix($matrix1->cells);
        $vMatrix2 = new VMatrix($matrix2->cells);
        $vMatrixMultiplied = $vMatrix1->multiply($vMatrix2);
        
        $this->assertTrue( $vMatrixMultiplied->equals(new VMatrix($matrixMultiplied->cells)) );
    }
    
    /**
     * test matrix cell values converted from decimal notation to alphabet notation.
     *
     * @return void
     */
    public function testTranslateToChars() {
        $original = Matrix::random(39, 30, 20);
        $converted = new Matrix($original);
        $converted->translateToChars();
        
        try {
            for ($r = 0; $r < $converted->getRows(); $r++) {
                for ($c = 0; $c < $converted->getCols(); $c++) {
                    $this->assertTrue($original->cells[$r][$c] === self::charToInt($converted->cells[$r][$c]));
                }
            }
        } catch (Exception $e) {
            echo "original: " . $original->toString();
            echo "converted: " . $converted->toString();
            $this->fail();
        }
    }
}
