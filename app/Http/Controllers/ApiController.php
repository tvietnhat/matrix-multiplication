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
        try {
            $cells1 = $request->input('matrix1');
            $matrix1 = $cells1 != null ? new Matrix($cells1) : null;
            $cells2 = $request->input('matrix2');
            $matrix2 = $cells2 != null ? new Matrix($cells2) : null;
            if ($matrix1 && $matrix2 ) {
                $matrixMultiplied = $matrix1->multiply($matrix2);
                $matrixChars = new Matrix($matrixMultiplied);
                $matrixChars->translateToChars();
        
                return response()->json([
                    'success' => true,
                    'matrix1' => $cells1,
                    'matrix2' => $cells2,
                    'result' => $matrixMultiplied->cells,
                    'resultInChars' => $matrixChars->cells,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'error' => 'Two matrices need for multiplication'
                ]);
            }
        }
        catch (MatrixException $e) {
            return response()->json([
                'success' => false,
                'matrix1' => $matrix1->toString(),
                'matrix2' => $matrix2->toString(),
                'error' => $e->getMessage()
            ]);
        }
    }
}
