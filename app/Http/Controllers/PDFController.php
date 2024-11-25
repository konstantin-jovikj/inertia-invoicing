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
        $clientId = $document->client_id;
        $client = Company::findOrFail($clientId);
        $owner = Company::findOrFail($ownerId);

        $owner->load('accounts.bank');
        $client->load('accounts.bank', 'customer.customerType');
        $document->load('documentType');

        $convertedOwner = latinToCyrillic($owner->name);
        $convertedAddress = latinToCyrillic($owner->address);
        $convertedPlace = latinToCyrillic($owner->place->place);
        $convertedPlaceClient = latinToCyrillic($client->place->place);
        $convertedCountry = latinToCyrillic($owner->place->country->name);
        $convertedCountryClient = latinToCyrillic($client->place->country->name);
        $convertedDocumentName = latinToCyrillic($document->documentType->type);
        $convertedCountryClient = latinToCyrillic($client->place->country->name);
        return pdf()->view('Pdf.document', compact('owner', 'convertedOwner', 'document', 'convertedAddress', 'convertedPlace', 'convertedCountry', 'convertedDocumentName', 'client', 'convertedPlaceClient', 'convertedCountryClient'))->name('doc.pdf');
    }

}
