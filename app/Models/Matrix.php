<?php declare(strict_types = 1);

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
	
	public function __construct() {
		$this->cells = [];
	}
	
	public static function random(int $rows, int $cols, int $offset = 0) {
		$matrix = new Matrix();
		$n = range($offset, $cols*2 + $offset);

		for ($i = 0; $i < $rows; $i++) {
			shuffle($n);
			$matrix->cells[] = array_slice($n, 0, $cols);
		}

		return $matrix;
	}
		
	public function getRows() {
		return count($this->cells);
	}
	public function getCols() {
		return count($this->cells) > 0 ? count($this->cells[0]) : 0;
	}
	
	public function toString() {
		$lines = [];
		foreach ($this->cells as &$row) {
			$lines[] = implode(',',$row);
		}
		return implode("\n",$lines);
	}

	public function multiply(Matrix $matrix) {
		if ($this->getCols() !== $matrix->getRows()) {
			throw new MatrixException("Cannot multiply. Incompatible matrices!");
		}
		
		$result = new Matrix();
		$result->cells = array_fill(0, $this->getRows(), array_fill(0, $matrix->getCols(), 0));
		
		for($r = 0; $r < $this->getRows(); $r++) {
			for($c = 0; $c < $matrix->getCols(); $c++) {
				$dotProduct = 0;
				for ($i = 0; $i < count($this->cells[$r]); $i++) {
					$dotProduct += $this->cells[$r][$i] * $matrix->cells[$i][$c];
				}
				$result->cells[$r][$c] = $dotProduct;
			}
		}
		
		return $result;
	}
}

class MatrixException extends Exception {}
