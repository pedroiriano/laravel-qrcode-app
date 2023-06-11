<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QrCodeController extends Controller
{
    public function index()
    {
        return view('qrcode');
    }

    public function generateQrCode()
    {
        $image = \QrCode::format('png')->size(200)->errorCorrection('H')->generate('Pedro Iriano');

        $output_image = '/public/img/qr-code/img-'.time().'.png';
        Storage::disk('local')->put($output_image, $image);

        return 'Success';
    }
}
