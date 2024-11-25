<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Document;
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
        $documentId = $product->document_id;

        $ownerId = $product->document->owner_id;
        $clientId = $product->document->client_id;

        $document = Document::findOrFail($documentId);
        $owner = Company::findOrFail($ownerId);
        $client = Company::findOrFail($clientId);

        $fileName = $client->name . '_' . $product->serial_no . '_' . $product->description . '_' . date('d-m-Y', strtotime($product->document->date));

        return pdf()
            ->view('Pdf.warranty', compact('product', 'owner', 'client', 'document'))
            ->name("{$fileName}.pdf");
    }

    public function printDocument(Document $document)
    {
        // dd($document->products);
        $ownerId = $document->owner_id;
        $owner = Company::findOrFail($ownerId);

        $owner->load('accounts.bank');
        $document->load('documentType');

        $convertedOwner = latinToCyrillic($owner->name);
        $convertedAddress = latinToCyrillic($owner->address);
        $convertedPlace = latinToCyrillic($owner->place->place);
        $convertedCountry = latinToCyrillic($owner->place->country->name);
        $convertedDocumentName = latinToCyrillic($document->documentType->type);
        return pdf()->view('Pdf.document', compact('owner', 'convertedOwner', 'document', 'convertedAddress', 'convertedPlace', 'convertedCountry', 'convertedDocumentName'))->name('doc.pdf');
    }

}
