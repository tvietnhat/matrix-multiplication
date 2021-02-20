<?php declare(strict_types = 1);

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Matrix;
use App\Models\MatrixException;
use vermotr\Math\Matrix as VMatrix;

class ApiController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	public function multiplyMatrices(Request $request) {
		$matrix1 = Matrix::random(10, 7, 20);
		$matrix2 = Matrix::random(7, 5, 20);
		
		try {
			$matrixMultiplied = $matrix1->multiply($matrix2);
		}
		catch (MatrixException $e) {
			return response()->json([
				'success' => false,
				'matrix1' => $matrix1->toString(),
				'matrix2' => $matrix2->toString(),
				'error' => $e->getMessage()
			]);
		}

		$vMatrix1 = new VMatrix($matrix1->cells);
		$vMatrix2 = new VMatrix($matrix2->cells);
		$vMatrixMultiplied = $vMatrix1->multiply($vMatrix2);
		
		return response()->json([
			'success' => true,
			'matrix1' => $matrix1->toString(),
			'matrix2' => $matrix2->toString(),
			'result' => $matrixMultiplied->toString(),
			'equals' => $vMatrixMultiplied->equals(new VMatrix($matrixMultiplied->cells))
		]);
	}
}
