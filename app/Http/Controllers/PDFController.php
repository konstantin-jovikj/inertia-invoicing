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

        $convertedOwner = $this->latinToCyrillic($owner->name);
        return pdf()->view('Pdf.document', compact('owner', 'convertedOwner'))->name('doc.pdf');
    }



    function latinToCyrillic($string)
    {
        // Define multi-character mappings first
        $multiCharMap = [
            'kj' => 'ќ',
            'Kj' => 'Ќ',
            'KJ' => 'Ќ',
        ];

        // Replace multi-character mappings
        foreach ($multiCharMap as $latin => $cyrillic) {
            $string = str_replace($latin, $cyrillic, $string);
        }

        // Define single-character mappings
        $singleCharMap = [
            'A' => 'А',
            'B' => 'Б',
            'C' => 'Ц',
            'D' => 'Д',
            'E' => 'Е',
            'F' => 'Ф',
            'G' => 'Г',
            'H' => 'Х',
            'I' => 'И',
            'J' => 'Ј',
            'K' => 'К',
            'L' => 'Л',
            'M' => 'М',
            'N' => 'Н',
            'O' => 'О',
            'P' => 'П',
            'R' => 'Р',
            'S' => 'С',
            'T' => 'Т',
            'U' => 'У',
            'V' => 'В',
            'Z' => 'З',
            'a' => 'а',
            'b' => 'б',
            'c' => 'ц',
            'd' => 'д',
            'e' => 'е',
            'f' => 'ф',
            'g' => 'г',
            'h' => 'х',
            'i' => 'и',
            'j' => 'ј',
            'k' => 'к',
            'l' => 'л',
            'm' => 'м',
            'n' => 'н',
            'o' => 'о',
            'p' => 'п',
            'r' => 'р',
            's' => 'с',
            't' => 'т',
            'u' => 'у',
            'v' => 'в',
            'z' => 'з',
        ];

        // Replace single-character mappings
        return strtr($string, $singleCharMap);
    }

    // Example usage:
    // $string = 'FRIGO SAN Kj kj';
    // $converted = latinToCyrillic($string);
    // echo $converted; // Outputs: ФРИГО САН Ќ ќ
}
