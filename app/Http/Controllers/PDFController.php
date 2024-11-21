<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Product;
use Illuminate\Http\Request;
use Spatie\LaravelPdf\PdfBuilder;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\Browsershot\Browsershot;
use function Spatie\LaravelPdf\Support\pdf;

class PDFController extends Controller
{
    public function createWarranty(Product $product)
    {
        $document = $product->document_id;
        $ownerId = $product->document->owner_id;
        $clientId = $product->document->client_id;
        $owner = Company::findOrFail($ownerId);
        $client = Company::findOrFail($clientId);

        $fileName = $client->name . '_' . $product->serial_no . '_' . $product->description . '_' . date('d-m-Y', strtotime($product->document->date));

        return pdf()->view('Pdf.warranty', compact('product', 'owner', 'client', 'document'))->name("{$fileName}.pdf");

    }
}

