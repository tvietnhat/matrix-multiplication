<?php 

declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ArrayObject;
use Exception;

class Matrix extends Model
{
    use HasFactory;
    
    /**
     * The 2-dimension array that contains be values of cells in the matrix in the format of $$values[$row][$col].
     *
     * @var array
     */
    public $cells;
    
    public function __construct(...$params) 
    {
        if (!empty($params) && is_array($params)) {
            if (is_array($params[0])) {
                $this->cells = $params[0];
            } else if ($params[0] instanceof self ) {
                $this->cells = $params[0]->cells;
            }
        } else {
            $this->cells = [];
        }
    }
    
    /**
     * Create a maxtrix and generate some randome values.
     */
    public static function random(int $rows, int $cols, int $offset = 0) : Matrix
    {
        $matrix = new Matrix();
        $n = range($offset, $cols*2 + $offset);

        for ($i = 0; $i < $rows; $i++) {
            shuffle($n);
            $matrix->cells[] = array_slice($n, 0, $cols);
        }

        return $matrix;
    }
    
    /**
     * Return number of rows
     */
    public function getRows() : int
    {
        return count($this->cells);
    }
    
    /**
     * Return number of columns
     */
    public function getCols() : int 
    {
        return count($this->cells) > 0 ? count($this->cells[0]) : 0;
    }
    
    /**
     * Return human-readable string
     */
    public function toString() : string
    {
        $lines = [];
        foreach ($this->cells as &$row) {
            $lines[] = implode(',',$row);
        }
        return implode("\n",$lines);
    }
    
    /**
     * check if the matrix can be multiplied with another one
     */
    public function canMultiplyWith(Matrix $matrix) : bool 
    {
        return $this->getCols() === $matrix->getRows();
    }

    /**
     * Multiply with another matrix and return the result.
     */
    public function multiply(Matrix $matrix) : Matrix 
    {
        if ( !$this->canMultiplyWith($matrix) ) {
            throw new MatrixException("Cannot multiply. Incompatible matrices!");
        }
        
        $result = new Matrix();
        $result->cells = array_fill(0, $this->getRows(), array_fill(0, $matrix->getCols(), 0));
        
        for ($r = 0; $r < $this->getRows(); $r++) {
            for ($c = 0; $c < $matrix->getCols(); $c++) {
                $dotProduct = 0;
                for ($i = 0; $i < count($this->cells[$r]); $i++) {
                    $dotProduct += $this->cells[$r][$i] * $matrix->cells[$i][$c];
                }
                $result->cells[$r][$c] = $dotProduct;
            }
        }
        
        return $result;
    }
    
    /**
     * Convert a number from decimal notation to alphabet notation.
     */
    private static function intToChar(int $val) : string
    {
        if ($val === 0) return '0';
        
        $absVal = abs($val);
        $base = ord('Z') - ord('A') + 1; // base 26
        $result = '';
        
        while ($absVal > 0) {
            $digit = ($absVal - 1) % $base;
            $result = chr(ord('A') + $digit) . $result;
            $absVal = intdiv($absVal - $digit - 1, $base);
        }
        
        if ($val < 0) {
            $result = '-' . $result;
        }
        
        return $result;
    }
    
    /**
     * Convert cell values from decimal notation to alphabet notation.
     */
    public function translateToChars()
    {
        foreach ($this->cells as &$row) {
            for ($c = 0; $c < count($row); $c++) {
                $row[$c] = self::intToChar($row[$c]);
            }
        }
    }
}

class MatrixException extends Exception {}
