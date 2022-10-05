<?php

namespace App\Http\Controllers\API\Loyal;

use App\Http\Controllers\API\ApiController as ApiController;
use App\Models\CdpMalls;
use App\Services\Contracts\QrCodeServiceInterface;
use Illuminate\Http\Request;

class OrderQrController extends ApiController
{
    public function __construct(QrCodeServiceInterface $qrCodeService)
    {
        $this->qrService = $qrCodeService;
    }

    public function activate($hash)
    {
        try {
            $data =  $this->qrService->activate($hash);
            $uri = CdpMalls::where('mall_id' , $data['mall_id'])->pluck('uri')->first();
            return redirect($uri.'?'.http_build_query($data['params']));
        }catch (\Exception $exception){
        }
    }

    public function show(Request $request)
    {
        try {
            $data =  $this->qrService->show($request);
            return $this->sendResponse($data, null , 200);
        }catch (\Exception $exception){
        }
    }
}
