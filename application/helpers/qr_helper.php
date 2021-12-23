<?php 
require APPPATH.'third_party/endroid_qrcode/autoload.php';

use Endroid\QrCode\ErrorCorrectionLevel;
	        //use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode;
	        //use Endroid\QrCode\Response\QrCodeResponse;
function create_qr($datanya,$id){
            // Create a basic QR code
    $data = $datanya;
    $qrCode = new QrCode($data);
    $qrCode->setSize(250);

        // Set advanced options
    $qrCode->setWriterByName('png');
    $qrCode->setMargin(10);
    $qrCode->setEncoding('UTF-8');
    $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH);
    $qrCode->setForegroundColor(['r' => 128, 'g' => 0, 'b' => 0, 'a' => 0]);
    $qrCode->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255, 'a' => 0]);
    $qrCode->setLogoPath(FCPATH."assets/images/logo.png");
       // $qrCode->Encoder(DEFAULT_BYTE_MODE_ECODING, ErrorCorrectionLevel::H);
    $qrCode->setLogoWidth(80);
    $qrCode->setLabel("Scan me for validation", $labelFontSize = null, $labelFontPath = null, $labelAlignment = null, $labelMargin = null);
    $qrCode->setValidateResult(false);

        // Directly output the QR code
        //header('Content-Type: '.$qrCode->getContentType());
        //echo $qrCode->writeString();

        // Save it to a file
        //$filename = time().'.png';
    $filename = $id.'.png';
    $qrCode->writeFile('assets/images/qr/'.$filename);
    return $filename;
    
        //echo $file_name;
        //$qrCode->writeFile('assets/qrcode_'.time().'.png');

        // Create a response object
        //$response = new QrCodeResponse($qrCode);
    
}