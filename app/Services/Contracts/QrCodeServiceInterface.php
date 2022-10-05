<?php
namespace App\Services\Contracts;

use Illuminate\Http\Request;

interface QrCodeServiceInterface
{
    public function generate($id);

    public function activate($hash);

    public function show(Request $request);
}
