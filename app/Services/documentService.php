<?php

namespace App\Services;

use App\Models\Document;
use App\Models\Product;
use App\Models\Company;
use Illuminate\Http\Request;

class documentService
{
    
    //  Create a new document
         public function createDocument(array $validatedData)
    {
        if (isset($validatedData['load_date'])) {
            $validatedData['date'] = $validatedData['load_date'];
        }

        return Document::create($validatedData);
    }

    
};