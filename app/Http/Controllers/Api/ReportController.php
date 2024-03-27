<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\TaskReport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReportController extends Controller
{
    public function generatePdf(Request $request)
    {
        $dateFrom = $request->dateFrom;
        $dateTo = $request->dateTo;

        TaskReport::dispatch($dateFrom, $dateTo);

        return response()->json(['message' => 'El archivo se guardara en el storage de la aplicacion'], Response::HTTP_OK);
    }
}
