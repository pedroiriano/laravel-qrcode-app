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

        $output_image = '/img/qr-code/img-'.time().'.png';
        Storage::disk('public')->put($output_image, $image);

        return 'Success';
    }
}
