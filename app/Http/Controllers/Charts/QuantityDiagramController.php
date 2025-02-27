<?php

namespace App\Http\Controllers\Charts;

use App\Charts\QuantityDiagram;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class QuantityDiagramController extends Controller
{
    public function __invoke(
        QuantityDiagram $quantityDiagram
    ): JsonResponse
    {
        return response()->json($quantityDiagram->getData());
    }
}
