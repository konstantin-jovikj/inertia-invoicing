<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/js/app.js')

</head>

<body class="w-11/12 m-auto py-t px-4 pb-20">

    <main>
        <div class="border-y-2 border-sky-700 mt-2 pb-1 font-bold flex flex-row justify-around">
            <div>
                @if ($type === 'packingList')
                    @if ($document->is_translation)
                        <span class="text-sm">Lista e Paketimit Nr: </span>
                        <span class="text-sm">{{ $packingList->document_no }}</span>
                    @else
                        <span class="text-sm">Пакинг Листа Бр: / Packing List Nr: </span>
                        <span class="text-sm">{{ $packingList->document_no }}</span>
                    @endif
                @else
                    @if ($document->is_for_advanced_payment)
                        <span>Авансна</span>
                    @endif
                    <span class="text-sm">
                        @if (!$document->is_for_export)
                            @if ($document->is_translation && $document->document_type_id == 1)
                                Oferta Nr:
                            @else
                                {{ $convertedDocumentName }} Бр:
                            @endif
                        @else
                            @if ($document->is_translation && $document->document_type_id == 1)
                                Oferta Nr:
                            @else
                                {{ $convertedDocumentName }} / {{ $document->documentType->type }} No:
                            @endif
                        @endif
                    </span>
                    <span class="text-lg">{{ $document->document_no }}</span>
                @endif
            </div>


            <div>
                @if ($type === 'packingList')
                    @if ($document->is_translation)
                        <span class="text-sm">Data: {{ date('d.m.Y', strtotime($packingList->date)) }}</span>
                    @else
                        <span class="text-sm">Датум: / Date: {{ date('d.m.Y', strtotime($packingList->date)) }}</span>
                    @endif
                @elseif (!$document->is_for_export)
                    @if ($document->is_translation)
                        <span class="text-sm">Data: {{ date('d.m.Y', strtotime($document->date)) }}</span>
                    @else
                        <span class="text-sm">Датум: {{ date('d.m.Y', strtotime($document->date)) }}</span>
                    @endif
                @else
                    <span class="text-sm">Date: {{ date('d.m.Y', strtotime($document->date)) }} </span>
                @endif
            </div>
        </div>

        <div class="border-b border-gray-500 pb-1 px-2 bg-sky-50">

            {{-- Pravno Lice --}}
            @if ($client->customer->customerType->id !== 1)
                @if (!$document->is_for_export)
                    <div>
                        @if ($document->is_translation)
                            <span class="text-xs text-purple-700 italic">Firma:</span>
                            <span class="text-md font-bold ms-2">{{ $client->name }}</span>
                        @else
                            <span class="text-xs text-purple-700 italic">Фирма:</span>
                            <span class="text-md font-bold ms-2">{{ $client->name }}</span>
                        @endif
                    @else
                        @if ($document->is_translation)
                            <span class="text-xs text-purple-700 italic">Firma:</span>
                            <span class="text-md font-bold ms-2">{{ $client->name }}</span>
                        @else
                            <span class="text-xs text-purple-700 italic">Company: </span>
                            <span class="text-md font-bold ms-2"> {{ $client->name }}</span>
                        @endif
                    </div>
                @endif
            @endif

            {{-- Fizicko Lice --}}
            @if ($client->customer->customerType->id == 1)
                @if (!$document->is_for_export)
                    <div>
                        @if ($document->is_translation)
                            <span class="text-xs text-purple-700 italic">Emri dhe Mbiemri:</span>
                            <span>{{ $client->name }}</span>
                        @else
                            <span class="text-xs text-purple-700 italic">Име и Презиме:</span>
                            <span>{{ $client->name }}</span>
                        @endif
                    @else
                        @if ($document->is_translation)
                            <span class="text-xs text-purple-700 italic">Emri dhe Mbiemri:</span>
                            <span>{{ $client->name }}</span>
                        @else
                            <span class="text-xs text-purple-700 italic">First and Last Name: </span>
                            <span>{{ $client->name }}</span>
                        @endif
                    </div>
                @endif
            @endif
        </div>
        </div>
        <div class="border-b border-gray-500   w-full  bg-sky-50 px-2">
            <div class="">
                @if ($document->is_for_export)
                    @if ($document->is_translation)
                        <span class="text-xs text-purple-700 italic">Adresa:</span>
                    @else
                        <span class="text-xs text-purple-700 italic">Address:</span>
                    @endif
                    <span class="text-sm ms-4 font-semibold">{{ $client->address }}</span>
                    <span class="text-sm font-semibold">-{{ $client->place->zip }} -
                        {{ $client->place->place }}</span>
                    <span class="text-sm font-semibold">-{{ $client->place->country->name }}</span>
                @else
                    @if ($document->is_translation)
                        <span class="text-xs text-purple-700 italic">Adresa:</span>
                    @else
                        <span class="text-xs text-purple-700 italic">Адреса:</span>
                    @endif
                    <span class="text-sm ms-4 font-semibold">{{ $client->address }}</span>
                    <span class="text-sm font-semibold">{{ $client->place->zip }} -
                        {{ $client->place->place }}</span>
                    <span class="text-sm font-semibold">{{ $client->place->country->name }}</span>
                @endif
            </div>
        </div>
        <div class="border-b border-gray-500   w-full  ">
            <div class="">
                @if ($document->is_for_export && $document->incoterm)
                    <span class="text-xs text-purple-700 italic">Paritet / Delivery / INCOTERMS:</span>
                    <span class="text-sm font-semibold ms-2">{{ $document->incoterm->shortcut }}
                        @if ($document->incotermPlace)
                            {{ $document->incotermPlace->place }}
                        @endif
                    </span>
                @endif
            </div>
        </div>
        @if ($document->delivery)
            <div class="border-b border-gray-500   w-full  ">
                <div class="">
                    @if ($document->is_for_export)
                        <span class="text-xs text-purple-700 italic">Isporaka/Delivery time:</span>
                        <span class="text-sm font-semibold ms-2">{{ $document->delivery }}</span>
                    @else
                        <span class="text-xs text-purple-700 italic">Испорака:</span>
                        <span class="text-sm font-semibold ms-2">{{ $document->delivery }}</span>
                    @endif
                </div>
            </div>
        @endif

        <div class="border-b border-gray-500   w-full flex ">
            @if ($type !== 'packingList' && $document->print_price)

                <div class="w-[25%] border-e me-2 border-gray-500">
                    @if ($document->is_for_export)
                        @if ($document->is_translation)
                            <span class="text-xs text-purple-700 italic">Valutë:</span>
                        @else
                            <span class="text-xs text-purple-700 italic">Currency:</span>
                        @endif
                        <span class="text-sm font-semibold ms-2">{{ $document->curency->symbol }} -
                            {{ $document->curency->code }}</span>
                    @else
                        @if ($document->is_translation)
                            <span class="text-xs text-purple-700 italic">Valutë:</span>
                        @else
                            <span class="text-xs text-purple-700 italic">Валута:</span>
                        @endif
                        <span class="text-sm font-semibold ms-2">{{ $document->curency->symbol }} -
                            {{ $document->curency->code }}</span>
                    @endif
                </div>
            @endif
            <div class="w-[28%] border-e border-gray-500">
                @if ($document->is_for_export)
                    <span class="text-xs text-purple-700 italic">Bruto/Netto Kg:</span>
                    @if (!is_null($packingList))
                        <span class="text-sm font-semibold mx-1">{{ $packingList->total_weight }} Kg</span>
                    @endif
                @else
                    @if ($document->is_translation)
                        <span class="text-xs text-purple-700 italic ps-1">Bruto/Netto Kg:</span>
                    @else
                        <span class="text-xs text-purple-700 italic ps-1">Маса / Тежина:</span>
                    @endif
                    @if (!is_null($packingList))
                        <span class="text-sm font-semibold mx-1">{{ $packingList->total_weight }} Kg</span>
                    @endif
                @endif
            </div>

            <div class="w-[28%] border-e border-gray-500">
                @if ($document->is_for_export)
                    @if ($document->is_translation)
                        <span class="text-xs text-purple-700 italic">Volumi total :</span>
                    @else
                        <span class="text-xs text-purple-700 italic">Total Volume :</span>
                    @endif
                    @if (!is_null($packingList))
                        <span class="text-sm font-semibold mx-1">{{ $packingList->total_volume }} m<sup>3</sup> </span>
                    @endif
                @else
                    @if ($document->is_translation)
                        <span class="text-xs text-purple-700 italic">Volumi total :</span>
                    @else
                        <span class="text-xs text-purple-700 italic ps-1">Волумен / Зафатнина:</span>
                    @endif
                    @if (!is_null($packingList))
                        <span class="text-sm font-semibold mx-1">{{ $packingList->total_volume }} m<sup>3</sup></span>
                    @endif
                @endif
            </div>
        </div>
        <div class="border-b border-gray-500   w-full flex">
            @if (!is_null($document->term))
                <div class="w-full">
                    @if ($document->is_for_export)
                        @if ($document->is_translation)
                            <span class="text-xs text-purple-700 italic">Kushtet e pagesës :</span>
                        @else
                            <span class="text-xs text-purple-700 italic">Payment Terms :</span>
                        @endif
                        <span class="text-sm font-semibold mx-1">{{ $document->term->term }} </sup> </span>
                    @else
                        @if ($document->is_translation)
                            <span class="text-xs text-purple-700 italic">Kushtet e pagesës :</span>
                        @else
                            <span class="text-xs text-purple-700 italic ps-1">Услови на Плаќање:</span>
                        @endif
                        <span class="text-sm font-semibold mx-1">{{ $document->term->term }} </sup> </span>

                    @endif
                </div>
            @endif
        </div>
        </div>


        {{-- PRODUCTS TABLE --}}
        <div class="mt-4">
            <div class="w-full">
                <table class="table-auto w-full border-collapse border border-gray-300 text-xs py-4">
                    <thead class="">
                        <tr class="bg-sky-200 text-[8px]">
                            <th class="border border-gray-300 px-2 py-1 text-left leading-none w-[30px]">
                                @if ($document->is_for_export)
                                    @if ($document->is_translation)
                                        Nr
                                    @else
                                        No
                                    @endif
                                @else
                                    @if ($document->is_translation)
                                        Nr
                                    @else
                                        Бр
                                    @endif
                                @endif
                            </th>

                            @if ($type == 'packingList')

                                <th class="border border-gray-300 px-2 py-1 text-left leading-none w-[30px]">
                                    @if ($document->is_for_export)
                                        @if ($document->is_translation)
                                            Nr në faturë
                                        @else
                                            No.in Invoice
                                        @endif
                                    @else
                                        @if ($document->is_translation)
                                            Nr në faturë
                                        @else
                                            Бр.во Фактура
                                        @endif
                                    @endif
                                </th>
                            @endif


                            @if ($document->drawing_no && $document->document_type_id == 1)
                                <th class="border border-gray-300 px-2 py-1 text-left leading-none w-[50px]">
                                    @if ($document->is_for_export)
                                        @if ($document->is_translation)
                                            Pozicioni
                                        @else
                                            Position
                                        @endif
                                    @else
                                        @if ($document->is_translation)
                                            Pozicioni
                                        @else
                                            Позиција
                                        @endif
                                    @endif
                                </th>
                            @endif

                            <th class="border border-gray-300 px-2 py-1 text-left leading-none">
                                @if ($document->is_for_export)
                                    @if ($document->is_translation)
                                        Lista
                                    @else
                                        Description
                                    @endif
                                @else
                                    @if ($document->is_translation)
                                        Lista
                                    @else
                                        Опис
                                    @endif
                                @endif
                            </th>
                            <th class="border border-gray-300 px-2 py-1 text-left leading-none w-[60px]">
                                @if ($document->is_for_export)
                                    @if ($document->is_translation)
                                        Cop
                                    @else
                                        Q-ty
                                    @endif
                                @else
                                    @if ($document->is_translation)
                                        Cop
                                    @else
                                        Кол
                                    @endif
                                @endif
                            </th>
                            @if ($type !== 'packingList' && $document->print_price)
                                <th class="border border-gray-300 px-2 py-1 text-left leading-none">
                                    @if ($document->is_for_export)
                                        @if ($document->is_translation)
                                            Çmimi
                                        @else
                                            Price
                                        @endif
                                    @else
                                        @if ($document->is_translation)
                                            Çmimi
                                        @else
                                            Цена
                                        @endif
                                    @endif
                                </th>
                            @endif
                            @if ($type == 'packingList')
                                @if ($document->is_translation)
                                    <th class="border border-gray-300 px-2 py-1 text-left leading-none">
                                        Prod.Pesha
                                    </th>
                                    <th class="border border-gray-300 px-2 py-1 text-left leading-none">
                                        Tot.Pesha
                                    </th>
                                    <th class="border border-gray-300 px-2 py-1 text-left leading-none">
                                        Prod.Volumi
                                    </th>
                                    <th class="border border-gray-300 px-2 py-1 text-left leading-none">
                                        Tot.Volumi
                                    </th>
                                @endif
                                <th class="border border-gray-300 px-2 py-1 text-left leading-none">
                                    Prod.Weight
                                </th>
                                <th class="border border-gray-300 px-2 py-1 text-left leading-none">
                                    Tot.Weight
                                </th>
                                <th class="border border-gray-300 px-2 py-1 text-left leading-none">
                                    Prod.Volume
                                </th>
                                <th class="border border-gray-300 px-2 py-1 text-left leading-none">
                                    Tot.Volume
                                </th>
                            @endif
                            @if ($type !== 'packingList' && $document->print_price)
                                <th class="border border-gray-300 px-2 py-1 text-left leading-none">
                                    @if ($document->is_for_export)
                                        @if ($document->is_translation)
                                            Тот.Çmimi
                                        @else
                                            Тот.Price
                                        @endif
                                    @else
                                        @if ($document->is_translation)
                                            Тот.Çmimi
                                        @else
                                            Вк.Цена
                                        @endif
                                    @endif
                                </th>
                            @endif
                        </tr>
                    </thead>
                    {{-- For Other Documents --}}
                    @if ($type !== 'packingList')
                        <tbody>
                            @php
                                $i = 1; // Initialize row number outside the loop
                            @endphp

                            @foreach ($products as $product)
                                @php
                                    $showRowNumber = $product->description && $product->qty;
                                @endphp
                                <tr class="bg-white">
                                    <td
                                        class="border border-gray-300 px-2 {{ $showRowNumber ? 'py-0.5' : 'py-2.5' }} leading-none">
                                        @if ($showRowNumber)
                                            {{ $i }}
                                        @endif
                                    </td>
                                    @if ($document->drawing_no && $document->document_type_id == 1)
                                        <td class="border border-gray-300 px-2 py-1 leading-none">
                                            @if ($showRowNumber)
                                                {{ $product->product_code }}
                                            @endif
                                        </td>
                                    @endif
                                    <td class="border border-gray-300 px-2 py-1 leading-none">
                                        {{ $product->description }}
                                        @if ($product->length)
                                            -
                                            {{ rtrim(rtrim(number_format($product->length, 2, '.', ','), '0'), '.') }}
                                        @endif
                                        @if ($product->width)
                                            x {{ rtrim(rtrim(number_format($product->width, 2, '.', ','), '0'), '.') }}
                                        @endif
                                        @if ($product->height)
                                            x
                                            {{ rtrim(rtrim(number_format($product->height, 2, '.', ','), '0'), '.') }}
                                        @endif
                                        @if ($product->manufacturers)
                                            - <span class="font-bold">{{ $product->manufacturers->name }} -
                                                {{ $product->manufacturers->place->country->name }}</span>
                                        @endif
                                    </td>
                                    <td class="border border-gray-300 px-2 py-1 leading-none">
                                        @if ($showRowNumber)
                                            {{ $product->qty == (int) $product->qty ? number_format($product->qty, 0) : number_format($product->qty, 2) }}
                                        @endif
                                    </td>





                                    @if ($type !== 'packingList' && $document->print_price)
                                        <td class="border border-gray-300 px-2 py-1 leading-none text-right">
                                            @if ($showRowNumber && $product->single_price != 0)
                                                {{ number_format($product->single_price, 2, '.', ',') }}
                                            @endif
                                        </td>
                                        <td class="border border-gray-300 px-2 py-1 leading-none text-right">
                                            @if ($showRowNumber && $product->total_price != 0)
                                                {{ number_format($product->total_price, 2, '.', ',') }}
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                                @if ($showRowNumber)
                                    @php
                                        $i++;
                                    @endphp
                                @endif
                            @endforeach


                        </tbody>
                    @endif

                    {{-- For Packing List --}}
                    @if ($type == 'packingList')
                        <tbody>
                            @php
                                $i = 1; // Initialize row number outside the loop
                            @endphp

                            @foreach ($packingList->products as $product)
                                @php
                                    $showRowNumber = $product->description && $product->qty;
                                @endphp
                                <tr class="bg-white">
                                    <td
                                        class="border border-gray-300 px-2 {{ $showRowNumber ? 'py-0.5' : 'py-2.5' }} leading-none">
                                        @if ($showRowNumber)
                                            {{ $i }}
                                        @endif
                                    </td>

                                    @if ($type == 'packingList')
                                        @if ($product->product_code === null || $product->product_code == 0)
                                            <td colspan="2"
                                                class="border border-gray-300 px-2 {{ $showRowNumber ? 'py-0.5' : 'py-2.5' }} leading-none font-semibold">
                                                {{ $product->description }}
                                                @if ($product->length)
                                                    -
                                                    {{ rtrim(rtrim(number_format($product->length, 2, '.', ','), '0'), '.') }}
                                                @endif
                                                @if ($product->width)
                                                    x
                                                    {{ rtrim(rtrim(number_format($product->width, 2, '.', ','), '0'), '.') }}
                                                @endif
                                                @if ($product->height)
                                                    x
                                                    {{ rtrim(rtrim(number_format($product->height, 2, '.', ','), '0'), '.') }}
                                                @endif
                                                @if ($product->manufacturers)
                                                    - <span class="font-bold">{{ $product->manufacturers->name }} -
                                                        {{ $product->manufacturers->place->country->name }}</span>
                                                @endif
                                            </td>
                                        @else
                                            <td
                                                class="border border-gray-300 px-2 {{ $showRowNumber ? 'py-0.5' : 'py-2.5' }} leading-none">
                                                {{ $product->product_code }}
                                            </td>
                                            <td class="border border-gray-300 px-2 py-1 leading-none">
                                                {{ $product->description }}
                                                @if ($product->length)
                                                    -
                                                    {{ rtrim(rtrim(number_format($product->length, 2, '.', ','), '0'), '.') }}
                                                @endif
                                                @if ($product->width)
                                                    x
                                                    {{ rtrim(rtrim(number_format($product->width, 2, '.', ','), '0'), '.') }}
                                                @endif
                                                @if ($product->height)
                                                    x
                                                    {{ rtrim(rtrim(number_format($product->height, 2, '.', ','), '0'), '.') }}
                                                @endif
                                                @if ($product->manufacturers)
                                                    - <span class="font-bold">{{ $product->manufacturers->name }} -
                                                        {{ $product->manufacturers->place->country->name }}</span>
                                                @endif
                                            </td>
                                        @endif
                                    @endif

                                    <td class="border border-gray-300 px-2 py-1 leading-none">
                                        @if ($showRowNumber)
                                            {{ $product->qty == (int) $product->qty ? number_format($product->qty, 0) : number_format($product->qty, 2) }}
                                        @endif
                                    </td>

                                    <td class="border border-gray-300 px-2 py-1 leading-none">
                                        @if ($showRowNumber && $type == 'packingList')
                                            {{ $product->weight }} Kg
                                        @endif
                                    </td>

                                    <td
                                        class="border border-gray-300 px-2 py-1 leading-none flex-nowrap whitespace-nowrap">
                                        @if ($showRowNumber && $type == 'packingList')
                                            {{ $product->product_total_weight }} Kg
                                        @endif
                                    </td>

                                    <td class="border border-gray-300 px-2 py-1 leading-none">
                                        @if ($showRowNumber && $type == 'packingList')
                                            @php
                                                $volume =
                                                    ($product->length * $product->width * $product->height) / 1000000;
                                                $formattedVolume = number_format($volume, 2, '.', ',');
                                                $formattedVolume = rtrim(rtrim($formattedVolume, '0'), '.');
                                            @endphp
                                            {{ $formattedVolume }} m<sup>3</sup>
                                        @endif
                                    </td>

                                    <td class="border border-gray-300 px-2 py-1 leading-none">
                                        @if ($showRowNumber && $type == 'packingList')
                                            {{ $product->product_total_volume }} m<sup>3</sup>
                                        @endif
                                    </td>

                                    @if ($type !== 'packingList')
                                        <td class="border border-gray-300 px-2 py-1 leading-none text-right">
                                            @if ($showRowNumber && $product->single_price != 0)
                                                {{ number_format($product->single_price, 2, '.', ',') }}
                                            @endif
                                        </td>
                                        <td class="border border-gray-300 px-2 py-1 leading-none text-right">
                                            @if ($showRowNumber && $product->total_price != 0)
                                                {{ number_format($product->total_price, 2, '.', ',') }}
                                            @endif
                                        </td>
                                    @endif
                                </tr>

                                @if ($showRowNumber)
                                    @php
                                        $i++;
                                    @endphp
                                @endif
                            @endforeach


                        </tbody>
                    @endif
                </table>
            </div>

        </div>


        <div class="flex w-full mt-4 gap-2">
            <div class="w-3/5 ">
                {{-- Note --}}
                @if ($document->note)
                    <div class="mb-2  text-xs text-purple-700 border border-purple-900 p-2 rounded-md">
                        {!! nl2br(e($document->note)) !!}
                    </div>
                @endif
                {{-- Declarations --}}
                @if ($selectedDeclarations->isNotEmpty())
                    <div class="flex flex-col justify-start text-xs">
                        @foreach ($selectedDeclarations as $selectedDeclaration)
                            <p class="mb-2 text-gray-800">{{ $selectedDeclaration->content }}</p>
                        @endforeach
                        <div class="flex justify-start gap-2">
                            <span>{{ date('d.m.Y', strtotime($document->date)) }}</span>
                            <span>-</span>
                            <span>{{ $owner->place->place }}</span>
                        </div>
                        @if ($owner->contacts->isNotEmpty())
                            <p>
                                <span>{{ $owner->contacts->first()->first_name }}</span>
                                <span>{{ $owner->contacts->first()->last_name }}</span>
                            </p>
                        @endif

                    </div>
                @endif
            </div>

            {{-- Calculated Fields --}}
            @if ($document->print_price)


                <div class="w-2/5">
                    <div class=" ">
                        @if ($type !== 'packingList')

                            <table class="table-auto w-full border-collapse border border-gray-600 py-4 text-md">
                                <tbody>
                                    <tr class="">
                                        <th
                                            class="border border-gray-600 px-2 py-1 text-left leading-none  bg-sky-200 text-sm font-normal italic">
                                            @if ($document->is_for_export)
                                                @if ($document->is_translation)
                                                    Baze
                                                @else
                                                    Total
                                                @endif
                                            @else
                                                @if ($document->is_translation)
                                                    Baze
                                                @else
                                                    Основица
                                                @endif
                                            @endif
                                        </th>
                                        <td
                                            class="border border-gray-600 px-2 py-1 text-right text-sm font-semibold align-middle">
                                            {{ number_format($document->total, 2, '.', ',') }}
                                            {{ $document->curency->symbol }}
                                        </td>
                                    </tr>

                                    @if ($document->discount !== '0.00' && $document->discount !== null)
                                        <tr class="">
                                            <th
                                                class="border border-gray-600 px-2 py-1 text-left leading-none  bg-sky-200 text-sm font-normal italic">
                                                @if ($document->is_for_export)
                                                    @if ($document->is_translation)
                                                        Zbritje {{ $document->discount }} %
                                                    @else
                                                        Discount {{ $document->discount }} %
                                                    @endif
                                                @else
                                                    @if ($document->is_translation)
                                                        Zbritje {{ $document->discount }} %
                                                    @else
                                                        Попуст {{ $document->discount }} %
                                                    @endif
                                                @endif
                                            </th>
                                            <td
                                                class="border border-gray-600 px-2 py-1 text-right text-sm font-semibold align-middle">
                                                {{ number_format($document->discount_amount, 2, '.', ',') }}
                                                {{ $document->curency->symbol }}
                                            </td>
                                        </tr>
                                    @endif

                                    @if ($document->tax_id !== 1 && $document->tax_id !== null)
                                        <tr class="">
                                            <th
                                                class="border border-gray-600 px-2 py-1 text-left leading-none  bg-sky-200 text-sm font-normal italic">
                                                @if ($document->is_for_export)
                                                    @if ($document->is_translation)
                                                        Tax / DDV {{ $document->tax->tax_rate }} %
                                                    @else
                                                        Tax / DDV {{ $document->tax->tax_rate }} %
                                                    @endif
                                                @else
                                                    @if ($document->is_translation)
                                                        Tax / DDV {{ $document->tax->tax_rate }} %
                                                    @else
                                                        ДДВ {{ $document->tax->tax_rate }} %
                                                    @endif
                                                @endif
                                            </th>
                                            <td
                                                class="border border-gray-600 px-2 py-1 text-right text-sm font-semibold align-middle">
                                                {{ number_format($document->tax_amount, 2, '.', ',') }}
                                                {{ $document->curency->symbol }}
                                            </td>
                                        </tr>
                                    @endif



                                    <tr class="">
                                        <th
                                            class="border border-gray-600 px-2 py-1 text-left leading-none  bg-red-200 text-md font-normal italic">
                                            @if ($document->is_for_export)
                                                Grand Total
                                            @else
                                                @if ($document->is_translation)
                                                    Totali
                                                @else
                                                    Вкупно
                                                @endif
                                            @endif
                                        </th>
                                        <td
                                            class="border border-gray-600 px-2 py-1 text-right text-md font-semibold align-middle whitespace-nowrap">
                                            <span
                                                class="pe-1">{{ number_format($document->total_with_tax_and_discount, 2, '.', ',') }}</span>
                                            <span>{{ $document->curency->symbol }}</span>
                                        </td>
                                    </tr>

                                    @if (!is_null($document->advance_payment) && $document->advance_payment != 0)
                                        <tr class="  w-full justify-stretch flex-grow">
                                            @if ($document->is_translation)
                                                <th
                                                    class="border border-gray-600 px-2 py-1 text-left leading-none  bg-green-200 text-xs font-normal italic">

                                                    Avans total

                                                </th>
                                            @else
                                                <th
                                                    class="border border-gray-600 px-2 py-1 text-left leading-none  bg-green-200 text-xs font-normal italic">

                                                    Вкупно Aванс

                                                </th>
                                            @endif
                                            <td
                                                class="border border-gray-600 px-2 py-1 text-right text-sm font-semibold align-middle">
                                                {{ number_format($document->advance_payment, 2, '.', ',') }}
                                                {{ $document->curency->symbol }}
                                            </td>
                                        </tr>

                                        <tr class="">
                                            <th
                                                class="border border-gray-600 px-2 py-1 text-left leading-none  bg-sky-200 text-xs font-normal italic">
                                                @if ($document->is_for_export)
                                                    @if ($document->is_translation)
                                                        Totali
                                                    @else
                                                        Total
                                                    @endif
                                                @else
                                                    @if ($document->is_translation)
                                                        Totali
                                                    @else
                                                        Преостанато Основица
                                                    @endif
                                                @endif
                                            </th>
                                            <td
                                                class="border border-gray-600 px-2 py-1 text-right text-sm font-semibold align-middle">
                                                {{ number_format($document->advanced_payment_base, 2, '.', ',') }}
                                                {{ $document->curency->symbol }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th
                                                class="border border-gray-600 px-2 py-1 text-left leading-tight bg-sky-200 text-xs font-normal italic align-top">
                                                @if ($document->is_for_export)
                                                    @if ($document->is_translation)
                                                        Totali
                                                    @else
                                                        Total
                                                    @endif
                                                @else
                                                    @if ($document->is_translation)
                                                        DDV e mbetur {{ $document->tax->tax_rate }} %
                                                    @else
                                                        Преостанато ДДВ {{ $document->tax->tax_rate }} %
                                                    @endif
                                                @endif
                                            </th>
                                            <td
                                                class="border border-gray-600 px-2 py-1 text-right text-md font-semibold align-middle">
                                                {{ number_format($document->advanced_payment_tax, 2, '.', ',') }}
                                                {{ $document->curency->symbol }}
                                            </td>
                                        </tr>


                                        <tr class="">
                                            @if ($document->is_translation)
                                                <th
                                                    class="border border-gray-600 px-2 py-1 text-left leading-none  bg-red-200 font-normal italic text-sm">

                                                    Totali i mbetur

                                                </th>
                                            @else
                                                <th
                                                    class="border border-gray-600 px-2 py-1 text-left leading-none  bg-red-200 font-normal italic text-sm">

                                                    Преостанато Вкупно

                                                </th>
                                            @endif
                                            <td
                                                class=" px-2 py-1  flex justify-end font-semibold text-md  align-middle items-center whitespace-nowrap">
                                                {{ number_format($document->grand_total, 2, '.', ',') }}
                                                {{ $document->curency->symbol }}
                                            </td>
                                        </tr>


                                    @endif
                                    @if ($document->curency_id == 1 && $document->document_type_id == 3 && !$document->is_for_export)
                                        <tr class="">
                                            <th class="w-full border border-gray-600 px-2 py-1 text-left leading-none bg-green-200 text-[8px]"
                                                colspan="2">

                                                {{ $words }} {{ $document->curency->symbol }}
                                            </th>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>
                        @else
                            <table class="table-auto w-full border-collapse border border-gray-600 py-4 text-md">
                                <tbody>
                                    <tr class="border-t border-b border-indigo-300 border-e border-s">
                                        <th class="border-indigo-300 bg-indigo-50 border-e">
                                            @if ($document->is_translation)
                                                <span
                                                    class="italic font-normal text-right text-indigo-600 pe-4 text-md">
                                                    Masa Totale
                                                </span>
                                            @else
                                                <span
                                                    class="italic font-normal text-right text-indigo-600 pe-4 text-md">
                                                    Вкупно Маса
                                                </span>
                                            @endif
                                        </th>
                                        <td class="text-lg font-bold text-right text-indigo-600">
                                            {{ $packingList->total_weight }}
                                            <span class="pe-2 text-sm">
                                                Kg
                                            </span>
                                        </td>
                                    </tr>


                                    <tr class="border-t border-b border-indigo-300 border-e border-s">
                                        <th class="border-indigo-300 bg-indigo-50 border-e">
                                            @if ($document->is_translation)
                                                <span
                                                    class="italic font-normal text-right text-indigo-600 pe-4 text-md">
                                                    Vëllimi Total
                                                </span>
                                            @else
                                                <span
                                                    class="italic font-normal text-right text-indigo-600 pe-4 text-md">
                                                    Вкупно Волумен
                                                </span>
                                            @endif
                                        </th>
                                        <td class="text-lg font-bold text-right text-indigo-600">
                                            {{ $packingList->total_volume }}
                                            <span class="pe-2 text-sm">
                                                m<sup>3</sup>
                                            </span>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        @endif
                    </div>

                </div>
            @endif
        </div>

        {{-- Signature --}}
        <div class="flex w-full mt-4 gap-2 text-xs text-gray-600 justify-between">
            <div class="border-b border-gray-600 px-12 py-6">
                <p>Примил</p>
            </div>
            <div>


                <div class="border-b border-gray-600 px-12 py-6">
                    <p>Овластено Лице за потпишување на фактури</p>
                </div>
            </div>
        </div>
        <div class="flex justify-end text-xs gap-4 px-4 py-1">

            @if ($firstContact = $owner->contacts->first())
                <div class="flex gap-2">
                    <span>{{ $firstContact->first_name }}</span>
                    <span>{{ $firstContact->last_name }}</span>
                </div>
            @endif
            <div>
                @if ($document->is_for_export)
                    <span class="font-bold">{{ $owner->name }}</span>
                @else
                    <span class="font-bold">{{ $convertedOwner }}</span>
                @endif
            </div>
        </div>



    </main>
</body>

</html>
