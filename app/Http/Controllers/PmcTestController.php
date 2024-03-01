<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Logic\PmcTestLogic;
use Illuminate\Http\Request;

class PmcTestController extends Controller
{
    public function __construct()
    {
    }

    public function GenerarTokenSeguridad(Request $request)
    {
        $response = PmcTestLogic::GenerarTokenSeguridad();
        return $response;
    }

    public function CasesRecordsLists(Request $request)
    {
        $response = new ApiResponse();
        try {
            $response = PmcTestLogic::CasesRecordsLists();
            $error = $response[2];
            $message = $response[1];
        } catch (\Exception $e) {
            return ApiResponse::error('Error' . $e, 404, $response);
        }
        return ApiResponse::success($message, 200, $response, $error);
        
    }

    public function GetCaseWithRecordId(Request $request)
    {
        $response = new ApiResponse();
        try {
            $response = PmcTestLogic::GetCaseWithRecordId();
            $error = $response[2];
            $message = $response[1];
        } catch (\Exception $e) {
            return ApiResponse::error('Error' . $e, 404, $response);
        }
        return ApiResponse::success($message, 200, $response, $error);       
    }

    public function ProbandoTabla(Request $request)
    {
        $response = PmcTestLogic::ProbandoTabla();
        return $response;
    }
}
