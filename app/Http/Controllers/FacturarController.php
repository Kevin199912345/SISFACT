<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use SimpleXMLElement;
use phpseclib3\Crypt\RSA;
use phpseclib3\File\X509;


class FacturarController extends Controller
{
    public function index()
    {
        return view('facturar');
    }

    public function generarFactura()
    {
        // Crear la estructura base del XML
        $xml = new SimpleXMLElement('<FacturaElectronica/>');

        // Información clave y número consecutivo
        $xml->addChild('Clave', 'NUMERO_CLAVE_UNICO');
        $xml->addChild('NumeroConsecutivo', '00100001010000001001');
        $xml->addChild('FechaEmision', now()->format('Y-m-d\TH:i:sP'));

        // Información del Emisor
        $emisor = $xml->addChild('Emisor');
        $emisor->addChild('Nombre', 'Nombre de la Empresa');
        $identificacionEmisor = $emisor->addChild('Identificacion');
        $identificacionEmisor->addChild('Numero', '3101234567');
        $identificacionEmisor->addChild('Tipo', '02'); // Tipo de identificación

        // Información del Receptor
        $receptor = $xml->addChild('Receptor');
        $receptor->addChild('Nombre', 'Nombre del Cliente');
        $identificacionReceptor = $receptor->addChild('Identificacion');
        $identificacionReceptor->addChild('Numero', '3107654321');
        $identificacionReceptor->addChild('Tipo', '01'); // Tipo de identificación

        // Detalles de la factura
        $detalleServicio = $xml->addChild('DetalleServicio');
        $lineaDetalle = $detalleServicio->addChild('LineaDetalle');
        $lineaDetalle->addChild('NumeroLinea', 1);
        $lineaDetalle->addChild('Cantidad', 2);
        $lineaDetalle->addChild('UnidadMedida', 'Sp');
        $lineaDetalle->addChild('Detalle', 'Descripción del Producto');
        $lineaDetalle->addChild('PrecioUnitario', 5000);
        $lineaDetalle->addChild('MontoTotal', 10000);

        // Guardar el XML en el almacenamiento local
        $path = 'facturas/factura_electronica.xml';
        Storage::put($path, $xml->asXML());

        //  Firmar el XML
        $signedXMLPath = $this->firmarXML($path);

        return response()->json([
            'message' => 'Factura generada y firmada con éxito',
            'xml' => Storage::get($signedXMLPath)
        ]);
    }

    public function firmarXML($xmlPath)
    {
        // Rutas del certificado y clave privada en formato PEM
        $certPath = 'C:\xampp\htdocs\sist_fact_v1\storage\app\certificados\certificado.pem';
        $keyPath = 'C:\xampp\htdocs\sist_fact_v1\storage\app\certificados\clave_privada.pem';

        // Verificar si los archivos existen
        if (!file_exists($certPath) || !file_exists($keyPath)) {
            return response()->json(['error' => 'Los archivos de certificado o clave privada no existen en la ruta especificada.'], 500);
        }

        // Cargar el certificado y la clave privada
        $certificado = file_get_contents($certPath);
        $clavePrivada = file_get_contents($keyPath);

        // Cargar el XML generado
        $xmlContent = Storage::get($xmlPath);

        // Crear el hash del XML
        $digestValue = base64_encode(hash('sha256', $xmlContent, true));

        // Crear la firma usando la clave privada
        openssl_sign($digestValue, $signature, $clavePrivada, OPENSSL_ALGO_SHA256);

        // Convertir la firma en base64
        $signatureValue = base64_encode($signature);

        // Añadir la firma al XML
        $signedXML = new SimpleXMLElement($xmlContent);
        $signedInfo = $signedXML->addChild('Signature', $signatureValue);

        // Guardar el XML firmado
        $signedXMLPath = 'facturas/factura_electronica_firmada.xml';
        Storage::put($signedXMLPath, $signedXML->asXML());

        return $signedXMLPath;
    }


}
