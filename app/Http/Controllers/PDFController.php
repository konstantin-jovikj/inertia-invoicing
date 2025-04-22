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


    public function processSegment($number, $units, $teens, $tens, $hundreds)
    {
        $words = "";

        // Handle hundreds
        if ($number >= 100) {
            $hundredPart = intdiv($number, 100);
            $number %= 100;

            $words .= $hundreds[$hundredPart];
            if ($number > 0) {
                $words .= " и ";
            }
        }

        // Handle tens and units
        if ($number >= 10 && $number < 20) {
            $words .= $teens[$number - 10];
        } else {
            $tenPart = intdiv($number, 10);
            $unitPart = $number % 10;

            if ($tenPart > 0) {
                $words .= $tens[$tenPart];
                if ($unitPart > 0) {
                    $words .= " и ";
                }
            }

            if ($unitPart > 0) {
                $words .= $units[$unitPart];
            }
        }

        return $words;
    }

    public function numberToWordsMK($number)
    {
        $units = ["", "еден", "два", "три", "четири", "пет", "шест", "седум", "осум", "девет"];
        $teens = ["десет", "единаесет", "дванаесет", "тринаесет", "четиринаесет", "петнаесет", "шеснаесет", "седумнаесет", "осумнаесет", "деветнаесет"];
        $tens = ["", "", "дваесет", "триесет", "четириесет", "педесет", "шеесет", "седумдесет", "осумдесет", "деведесет"];
        $hundreds = ["", "сто", "двеста", "триста", "четиристотини", "петстотини", "шестотини", "седумстотини", "осумстотини", "деветстотини"];
        $thousands = ["", "илјада", "илјади"];
        $millions = ["", "милион", "милиони"];

        if ($number == 0) {
            return "нула";
        }

        $words = "";

        // Handle millions
        if ($number >= 1000000) {
            $millionPart = intdiv($number, 1000000);
            $number %= 1000000;

            $words .= $this->processSegment($millionPart, $units, $teens, $tens, $hundreds) . " ";
            $words .= $millionPart == 1 ? $millions[1] : $millions[2];
            if ($number > 0) {
                $words .= " и ";
            }
        }

        // Handle thousands
        if ($number >= 1000) {
            $thousandPart = intdiv($number, 1000);
            $number %= 1000;

            $words .= $this->processSegment($thousandPart, $units, $teens, $tens, $hundreds) . " ";
            $words .= $thousandPart == 1 ? $thousands[1] : $thousands[2];
            if ($number > 0) {
                $words .= " и ";
            }
        }

        // Handle hundreds, tens, and units
        if ($number > 0) {
            $words .= $this->processSegment($number, $units, $teens, $tens, $hundreds);
        }

        return $words;
    }



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

        $owner->load('accounts.bank', 'contacts');
        $client->load('accounts.bank', 'customer.customerType');
        $document->load('documentType', 'incotermPlace');
        $products = Product::whereNull('packing_list_id')->where('document_id', $document->id)->get();



        $packingList = PackingList::where('document_id', $document->id)->first();
        $packingListProducts = Product::whereNotNull('packing_list_id')->where('document_id', $document->id)->get();


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

        $words = $this->numberToWordsMK($document->grand_total);
        // dd($words);

        if ($document->documentType->id != 5) {
            $docName = "";

            switch ($document->documentType->id) {
                case 1:
                    $docName = "PO-{$document->document_no}.pdf";
                    break;
                case 2:
                    $docName = "PI-{$document->document_no}.pdf";
                    break;
                case 3:
                    $docName = "IN-{$document->document_no}.pdf";
                    break;
                case 4:
                    $docName = "IS-{$document->document_no}.pdf";
                    break;
                case 6:
                    $docName = "PR-{$document->document_no}.pdf";
                    break;
                case 7:
                    return redirect()->route('print.travelorder', ['document' => $document->id]);
                // $docName = "TL-{$document->document_no}.pdf";
                // break;
                default:
                    // Optional: Handle cases where the documentType id is not recognized
                    $docName = "DOC-{$document->document_no}.pdf";
                    break;
            }



            return Pdf::view('Pdf.document', compact('type', 'owner', 'convertedOwner', 'document', 'convertedAddress', 'convertedPlace', 'convertedCountry', 'convertedDocumentName', 'client', 'convertedPlaceClient', 'convertedCountryClient', 'products', 'packingList', 'packingListProducts', 'selectedDeclarations', 'words'))
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
                ->name($docName);
        } else {
            return Pdf::view('Pdf.smetkopotvrda', compact('type', 'owner', 'convertedOwner', 'document', 'convertedAddress', 'convertedPlace', 'convertedCountry', 'convertedDocumentName', 'client', 'convertedPlaceClient', 'convertedCountryClient', 'products', 'packingList', 'packingListProducts', 'selectedDeclarations', 'words'))
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
                ->name('smetkopotvrda.pdf');
        }
    }

    public function printCe(Product $product)
    {
        $product->load('categories', 'model', 'document.owner');
        // dd($product);
        return Pdf::view('Pdf.ce', compact('product'))
            ->withBrowsershot(function (Browsershot $browsershot) {
                $browsershot->transparentBackground();
                $browsershot->writeOptionsToFile();
            })
            ->margins(10, 0, 14, 0)
            ->format(Format::A4)
            ->name('ce.pdf');
    }

    public function freonCert(Product $product)
    {
        $product->load('categories', 'model', 'document.owner', 'refrigerant');
        // dd($product);
        return Pdf::view('Pdf.freon', compact('product'))
            ->withBrowsershot(function (Browsershot $browsershot) {
                $browsershot->transparentBackground();
                $browsershot->writeOptionsToFile();
            })
            ->margins(10, 0, 14, 0)
            ->format(Format::A4)
            ->name('freon.pdf');
    }


    public function printTravelOrder(Document $document)
    {
        $ownerId = $document->owner_id;
        $clientId = $document->client_id;
        $client = Company::findOrFail($clientId);
        $owner = Company::findOrFail($ownerId);

        $client->load('place.country');
        $owner->load('place.country');

        $document->load('company', 'vehicle', 'place.country', 'load_place', 'unload_place');
        // dd($product);
        return Pdf::view('Pdf.travelorder', compact('document', 'client', 'owner'))
            ->withBrowsershot(function (Browsershot $browsershot) {
                $browsershot->transparentBackground();
                $browsershot->writeOptionsToFile();
            })
            ->margins(10, 0, 14, 0)
            ->format(Format::A4)
            ->name('PatenNalog.pdf');
    }




}
