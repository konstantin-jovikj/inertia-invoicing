<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\PackingList;
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

    public function printDocument(Document $document, Request $request)
    {
        $type = $request->query('type');
        // dd($document, $type);
        
        
        
        $ownerId = $document->owner_id;
        $clientId = $document->client_id;
        $client = Company::findOrFail($clientId);
        $owner = Company::findOrFail($ownerId);
        
        $owner->load('accounts.bank');
        $client->load('accounts.bank', 'customer.customerType');
        $document->load('documentType');
        $products = Product::whereNull('packing_list_id')->where('document_id', $document->id)->get();


        
        $packingList = PackingList::where('document_id', $document->id)->first();
        $packingListProducts = Product::whereNotNull('packing_list_id')->where('document_id', $document->id)->get();
        
        // dd($document, $type);

        // dd($packingList, $type, );


        $convertedOwner = latinToCyrillic($owner->name);
        $convertedAddress = latinToCyrillic($owner->address);
        $convertedPlace = latinToCyrillic($owner->place->place);
        $convertedPlaceClient = latinToCyrillic($client->place->place);
        $convertedCountry = latinToCyrillic($owner->place->country->name);
        $convertedCountryClient = latinToCyrillic($client->place->country->name);
        $convertedDocumentName = latinToCyrillic($document->documentType->type);

        $selectedDeclarations = $document->declarations;
        // dd($selectedDeclarations);
        $headerData = [
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
        ];

        if ($owner->cert && file_exists(storage_path('app/public/' . $owner->cert))) {
            $headerData['cert'] = 'data:image/png;base64,' . base64_encode(file_get_contents(storage_path('app/public/' . $owner->cert)));
        } else {
            $headerData['cert'] = null; // Ensure cert is defined even if it doesn't exist
        }

        if ($owner->logo && file_exists(storage_path('app/public/' . $owner->logo))) {
            $headerData['logo'] = 'data:image/png;base64,' . base64_encode(file_get_contents(storage_path('app/public/' . $owner->logo)));
        } else {
            $headerData['logo'] = null; // Ensure logo is defined even if it doesn't exist
        }

        return Pdf::view('Pdf.document', compact('type', 'owner', 'convertedOwner', 'document', 'convertedAddress', 'convertedPlace', 'convertedCountry', 'convertedDocumentName', 'client', 'convertedPlaceClient', 'convertedCountryClient', 'products', 'packingList', 'packingListProducts', 'selectedDeclarations'))
            ->withBrowsershot(function (Browsershot $browsershot) {
                $browsershot->transparentBackground();
                $browsershot->writeOptionsToFile();
            })
            ->margins(35, 0, 14, 0)
            ->headerView('Pdf.header', $headerData)
            ->footerView('Pdf.footer', [
                'document' => $document,
            ])
            ->format(Format::A4)
            ->name('invoice.pdf');
    }

}
