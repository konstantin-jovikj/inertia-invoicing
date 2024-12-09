<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Product;
use App\Models\Document;
use App\Models\PackingList;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\StorePackingListRequest;
use App\Http\Requests\UpdatePackingListRequest;

class PackingListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(PackingList $packingList)
    {
// dd($packingList);
        // Load related data for the document
        $packingList->load('company', 'document');
    
        $products = Product::where('packing_list_id', $packingList->id)->get();
        
        $products->load('manufacturers.place.country');

        $packingList->total_weight = 0;
        $packingList->total_volume = 0;

        $packingList->total_weight = $products->sum('product_total_weight');
        $packingList->total_volume = $products->sum('product_total_volume');
    
        $packingList->save();
        // Return response with the created packing list and related data
        return inertia('PackingList/PackingListAdd', [
            'packingList' => $packingList,
            'products' => $products,
        ]);
    }
    
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Document $document)
    {
        // Load related data for the document
        $document->load('documentType', 'company', 'curency', 'tax');
        // dd($document->id);

        
        // Fetch products associated with the document and load related data
        $products = Product::where('document_id', $document->id)->get();
        $products->load('manufacturers.place.country');
        
        // dd($document);
        // Create Packing List
        $packingList = PackingList::create([
            'user_id' => $document->user_id,
            'owner_id' => $document->owner_id,
            'client_id' => $document->client_id,
            'document_id' => $document->id,
            'vehicle_id' => $document->vehicle_id,
            'driver_id' => $document->driver_id,
            'curency_id' => $document->curency_id,
            'incoterm_id' => $document->incoterm_id,
            'tax_id' => $document->tax_id,
            'term_id' => $document->term_id,
            'is_translation' => $document->is_translation,
            'is_for_export' => $document->is_for_export,
            'document_no' => $document->document_no,
            'drawing_no' => $document->drawing_no,
            'date' => $document->date,
            'advance_payment' => $document->advance_payment,
            'discount' => $document->discount,
            'delivery' => $document->delivery,
        ]);
        // dd('packing_list_id', $packingList->id,);
    
        // Loop through document products and add them to the created Packing List
        foreach ($products as $product) {
            $newProduct = $product->replicate(); // Creates a new instance
            $newProduct->packing_list_id = $packingList->id;
            $newProduct->save();
        }

        return redirect()
        ->route('packinglist.create', ['packingList' => $packingList])
        ->with('message', 'Packing List saved successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(PackingList $packingList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PackingList $packingList)
    {
        $packingList->load('document', 'products', 'company');

        $companies = Company::select('id', 'name', 'is_customer')
            ->whereIn('is_customer', [true, false])
            ->get()
            ->groupBy('is_customer');

        return inertia('PackingList/PackingListEdit', [
            'packingList' => $packingList,
            'ownerCompanies' => $companies->get(false, collect()), // companies where 'is_customer' is false
            'clientCompanies' => $companies->get(true, collect()), // companies where 'is_customer' is true
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PackingList $packingList)
    {
                // Validate all fields coming from the user
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'owner_id' => 'required|exists:companies,id',
            'client_id' => 'required|exists:companies,id',
            'document_no' => 'required|max:255',
            'date' => 'nullable|date',
        ]);

        $packingList->update($validatedData);
        return Inertia::location(route('packinglist.create', [
            'packingList' => $packingList->id,
        ]));
    }

    public function addEmptyRow(PackingList $packingList, Product $product)
    {

        $existingOrder = Product::where('packing_list_id', $packingList->id)->get();
 
        $emptyRow = new Product([
            "id" => $product->id,
            "packing_list_id" => $packingList->id,
            "description" => null,
            "qty" => null,
        ]);

        // Insert the empty row at the correct position in the collection
        $newOrder = $existingOrder->flatMap(function ($order) use ($emptyRow, $product) {
            return $order->id == $product->id ? collect([$emptyRow, $order]) : collect([$order]);
        });

        Product::where('packing_list_id', $packingList->id)->delete();
        $newOrder->each(fn($order) => Product::create($order->toArray()));

        return redirect()
        ->route('packinglist.create', ['packingList' => $packingList->id])
        ->with('message', 'Empty Row inserted successfully!');
    }

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PackingList $packingList)
    {
        //
    }
}
