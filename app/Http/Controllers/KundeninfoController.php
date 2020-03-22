<?php


namespace App\Http\Controllers;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Response\QrCodeResponse;
use http\Env\Request;

class KundeninfoController
{

    public function getQRCode($text) {

        $qrCode = new QrCode('https://127.0.0.1:8000/queueUserInQueueQR/'. $text);
        $qrCode->setForegroundColor(['r' => 0, 'g' => 152, 'b' => 255, 'a' => 0]);

        header('Content-Type: '.$qrCode->getContentType());
        $response = new QrCodeResponse($qrCode);

        return $response;
    }

    public function getPage($uuid) {
        return view("kundeninfo")->with(compact('uuid'));
    }
}


