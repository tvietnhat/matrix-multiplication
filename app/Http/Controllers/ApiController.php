<?php 

declare(strict_types = 1);

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Matrix;
use App\Models\MatrixException;

class ApiController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function multiplyMatrices(Request $request) {
        $matrix1 = Matrix::random(2, 3, 0);
        $matrix2 = Matrix::random(3, 4, 0);
        
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
        
        $matrixChars = new Matrix($matrixMultiplied);
        $matrixChars->translateToChars();
        
        return response()->json([
            'success' => true,
            'matrix1' => $matrix1->toString(),
            'matrix2' => $matrix2->toString(),
            'result' => $matrixMultiplied->toString(),
            'result_in_chars' => $matrixChars->toString(),
        ]);
    }
}
