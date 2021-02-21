<?php 

declare(strict_types = 1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Matrix;
use App\Models\MatrixException;
use vermotr\Math\Matrix as VMatrix;

class MatrixTest extends TestCase
{
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
}
