<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Product;
use App\Models\Document;
use Illuminate\Http\Request;
use Spatie\LaravelPdf\PdfBuilder;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Enums\Format;
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
        $products = Product::whereNull('packing_list_id')->where('document_id',$document->id )->get();
        $packingListProducts = Product::whereNotNull('packing_list_id')->where('document_id',$document->id )->get();

        // $products = Product::where('document_id', $document->id)->get();

        $convertedOwner = latinToCyrillic($owner->name);
        $convertedAddress = latinToCyrillic($owner->address);
        $convertedPlace = latinToCyrillic($owner->place->place);
        $convertedPlaceClient = latinToCyrillic($client->place->place);
        $convertedCountry = latinToCyrillic($owner->place->country->name);
        $convertedCountryClient = latinToCyrillic($client->place->country->name);
        $convertedDocumentName = latinToCyrillic($document->documentType->type);
        $convertedCountryClient = latinToCyrillic($client->place->country->name);

        return Pdf::view('Pdf.document', compact('owner', 'convertedOwner', 'document', 'convertedAddress', 'convertedPlace', 'convertedCountry', 'convertedDocumentName', 'client', 'convertedPlaceClient', 'convertedCountryClient', 'products', 'packingListProducts'))
                ->withBrowsershot(function (Browsershot $browsershot) {
                    $browsershot->transparentBackground();
                    $browsershot->writeOptionsToFile();
                    
                })
                ->margins(35,0,14,0)
                ->headerView('Pdf.header', 
                [
                    'owner' => $owner,
                    'convertedOwner' => $convertedOwner,
                    'document' => $document,
                    'convertedAddress' => $convertedAddress,
                    'convertedPlace' => $convertedPlace,
                    'convertedCountry' => $convertedCountry,
                    'convertedDocumentName' => $convertedDocumentName,
                    'client' => $client,
                    'convertedPlaceClient' => $convertedPlaceClient,
                    'convertedCountryClient' => $convertedCountryClient,
                    'logo' => 'data:image/png;base64,' . base64_encode(file_get_contents(storage_path('app/public/' . $owner->logo))),
                    'cert' => 'data:image/png;base64,' . base64_encode(file_get_contents(storage_path('app/public/' . $owner->cert))),

                    
                ])
                ->footerView('Pdf.footer',[
                    'document' => $document,
                ])
                ->format(Format::A4)
                ->name('invoice.pdf');


    }
}
