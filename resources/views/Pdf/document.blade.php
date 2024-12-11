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
                    <span class="text-sm">Пакинг Листа Бр: / Packing List Nr: </span>
                    <span class="text-sm">{{ $packingList->document_no }}</span>
                @elseif (!$document->is_for_export)
                    <span class="text-sm">{{ $convertedDocumentName }} Бр: </span>
                    <span class="text-lg">{{ $document->document_no }} </span>
                @else
                    <span class="text-sm">{{ $convertedDocumentName }} / {{ $document->documentType->type }} No: </span>
                    <span class="text-lg">{{ $document->document_no }} </span>
                @endif
            </div>

            <div>
                @if ($type === 'packingList')
                    <span class="text-sm">Датум: / Date: {{ date('d.m.Y', strtotime($packingList->date)) }}</span>
                @elseif (!$document->is_for_export)
                    <span class="text-sm">Датум: {{ date('d.m.Y', strtotime($document->date)) }}</span>
                @else
                    <span class="text-sm">Date: {{ date('d.m.Y', strtotime($document->date)) }} </span>
                @endif
            </div>
        </div>

        <div class="border-b border-gray-500 pb-1 ">

            {{-- Pravno Lice --}}
            @if ($client->customer->customerType->id !== 1)
                @if (!$document->is_for_export)
                    <div>
                        <span class="text-xs text-purple-700 italic">Фирма:</span>
                        <span class="text-md font-bold ms-2">{{ $client->name }}</span>
                    @else
                        <span class="text-xs text-purple-700 italic">Company: </span>
                        <span class="text-md font-bold ms-2"> {{ $client->name }}</span>
                    </div>
                @endif
            @endif

            {{-- Fizicko Lice --}}
            @if ($client->customer->customerType->id == 1)
                @if (!$document->is_for_export)
                    <div>
                        <span class="text-md text-md font-bold ms-4"><span class="text-xs text-purple-700 italic">Име и
                                Презиме:
                            </span>{{ $client->name }}</span>
                    @else
                        <span class="text-md font-bold ms-4"><span class="text-xs text-purple-700 italic">First and Last
                                Name: </span>
                            {{ $client->name }}
                        </span>
                    </div>
                @endif
            @endif
        </div>
        </div>
        <div class="border-b border-gray-500   w-full  ">
            <div class="">
                @if ($document->is_for_export)
                    <span class="text-xs text-purple-700 italic">Address:</span>
                    <span class="text-sm ms-4 font-semibold">{{ $client->address }}</span>
                    <span class="text-sm font-semibold">-{{ $client->place->zip }} -
                        {{ $client->place->place }}</span>
                    <span class="text-sm font-semibold">-{{ $client->place->country->name }}</span>
                @else
                    <span class="text-xs text-purple-700 italic">Адреса:</span>
                    <span class="text-sm ms-4 font-semibold">{{ $client->address }}</span>
                    <span class="text-sm font-semibold">{{ $client->place->zip }} - {{ $client->place->place }}</span>
                    <span class="text-sm font-semibold">{{ $client->place->country->name }}</span>
                @endif
            </div>
        </div>
        <div class="border-b border-gray-500   w-full  ">
            <div class="">
                @if ($document->is_for_export && $document->incoterm)
                    <span class="text-xs text-purple-700 italic">Paritet / Delivery / INCOTERMS:</span>
                    <span class="text-sm font-semibold ms-2">{{ $document->incoterm->shortcut }}
                        {{ $client->place->place }}</span>
                @endif
            </div>
        </div>
        @if ($document->delivery)
            <div class="border-b border-gray-500   w-full  ">
                <div class="">
                    @if ($document->is_for_export)
                        <span class="text-xs text-purple-700 italic">Isporaka:</span>
                        <span class="text-sm font-semibold ms-2">{{ $document->delivery }}</span>
                    @endif
                    @if (!$document->is_for_export)
                        <span class="text-xs text-purple-700 italic">Испорака:</span>
                        <span class="text-sm font-semibold ms-2">{{ $document->delivery }}</span>
                    @endif
                </div>
            </div>
        @endif

        <div class="border-b border-gray-500   w-full flex ">
            @if ($type !== 'packingList')

                <div class="w-[25%] border-e me-2 border-gray-500">
                    @if ($document->is_for_export)
                        <span class="text-xs text-purple-700 italic">Currency:</span>
                        <span class="text-sm font-semibold ms-2">{{ $document->curency->symbol }} -
                            {{ $document->curency->code }}</span>
                    @else
                        <span class="text-xs text-purple-700 italic">Валута:</span>
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
                    <span class="text-xs text-purple-700 italic ps-1">Маса / Тежина:</span>
                    @if (!is_null($packingList))
                        <span class="text-sm font-semibold mx-1">{{ $packingList->total_weight }} Kg</span>
                    @endif
                @endif
            </div>

            <div class="w-[28%] border-e border-gray-500">
                @if ($document->is_for_export)
                    <span class="text-xs text-purple-700 italic">Total Volume :</span>
                    @if (!is_null($packingList))
                        <span class="text-sm font-semibold mx-1">{{ $packingList->total_volume }} m<sup>3</sup> </span>
                    @endif
                @else
                    <span class="text-xs text-purple-700 italic ps-1">Волумен / Зафатнина:</span>
                    @if (!is_null($packingList))
                        <span class="text-sm font-semibold mx-1">{{ $packingList->total_volume }} m<sup>3</sup></span>
                    @endif
                @endif
            </div>
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
                                    No
                                @else
                                    Бр
                                @endif
                            </th>

                            @if ($type == 'packingList')

                                <th class="border border-gray-300 px-2 py-1 text-left leading-none w-[30px]">
                                    @if ($document->is_for_export)
                                        No.in Invoice
                                    @else
                                        Бр.во Фактура
                                    @endif
                                </th>
                            @endif


                            @if ($document->drawing_no && $document->document_type_id == 1)
                                <th class="border border-gray-300 px-2 py-1 text-left leading-none w-[50px]">
                                    @if ($document->is_for_export)
                                        Position
                                    @else
                                        Позиција
                                    @endif
                                </th>
                            @endif

                            <th class="border border-gray-300 px-2 py-1 text-left leading-none">
                                @if ($document->is_for_export)
                                    Description
                                @else
                                    Опис
                                @endif
                            </th>
                            <th class="border border-gray-300 px-2 py-1 text-left leading-none w-[60px]">
                                @if ($document->is_for_export)
                                    Q-ty
                                @else
                                    Кол
                                @endif
                            </th>
                            @if ($type !== 'packingList')
                                <th class="border border-gray-300 px-2 py-1 text-left leading-none">
                                    @if ($document->is_for_export)
                                        Price
                                    @else
                                        Цена
                                    @endif
                                </th>
                            @endif
                            @if ($type == 'packingList')
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
                            @if ($type !== 'packingList')
                                <th class="border border-gray-300 px-2 py-1 text-left leading-none">
                                    @if ($document->is_for_export)
                                        Тот.Price
                                    @else
                                        Вк.Цена
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
                                            {{ $product->qty }}
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
                                            {{ $product->qty }}
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
        {{-- Declarations --}}
        <div class="flex w-full mt-4 gap-2">
            <div class="w-3/5 ">

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
                </div>
            @endif
            </div>

            {{-- Calculated Fields --}}
            <div class="w-2/5">
                <div class=" ">
                    @if ($type !== 'packingList')

                        <table class="table-auto w-full border-collapse border border-gray-600 py-4 text-md">
                            <tbody>
                                <tr class="">
                                    <th
                                        class="border border-gray-600 px-2 py-1 text-left leading-none  bg-sky-200 text-sm font-normal italic">
                                        @if ($document->is_for_export)
                                            Total
                                        @else
                                            Основица
                                        @endif
                                    </th>
                                    <td
                                        class="border border-gray-600 px-2 py-1 leading-none flex justify-end text-md font-semibold">
                                        {{ number_format($document->total, 2, '.', ',') }}
                                        {{ $document->curency->symbol }}
                                    </td>
                                </tr>

                                @if ($document->discount !== '0.00' && $document->discount !== null)
                                    <tr class="">
                                        <th
                                            class="border border-gray-600 px-2 py-1 text-left leading-none  bg-sky-200 text-sm font-normal italic">
                                            @if ($document->is_for_export)
                                                Discount {{ $document->discount }} %
                                            @else
                                                Попуст {{ $document->discount }} %
                                            @endif
                                        </th>
                                        <td
                                            class="border border-gray-600 px-2 py-1 leading-none flex justify-end font-semibold">
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
                                                Tax / DDV {{ $document->tax->tax_rate }} %
                                            @else
                                                ДДВ {{ $document->tax->tax_rate }} %
                                            @endif
                                        </th>
                                        <td
                                            class="border border-gray-600 px-2 py-1 leading-none flex justify-end font-semibold">
                                            {{ number_format($document->tax_amount, 2, '.', ',') }}
                                            {{ $document->curency->symbol }}
                                        </td>
                                    </tr>
                                @endif

                                <tr class="">
                                    <th
                                        class="border border-gray-600 px-2 py-1 text-left leading-none  bg-red-200 text-lg font-normal italic">
                                        @if ($document->is_for_export)
                                            Grand Total
                                        @else
                                            Вкупно
                                        @endif
                                    </th>
                                    <td
                                        class="border border-gray-600 px-2 py-1 leading-none flex justify-end font-semibold text-lg">
                                        {{ number_format($document->total_with_tax_and_discount, 2, '.', ',') }}
                                        {{ $document->curency->symbol }}
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    @else
                        <table class="table-auto w-full border-collapse border border-gray-600 py-4 text-md">
                            <tbody>
                                <tr class="border-t border-b border-indigo-300 border-e border-s">
                                    <th class="border-indigo-300 bg-indigo-50 border-e">
                                        <span class="italic font-normal text-right text-indigo-600 pe-4 text-md">
                                            Вкупно Маса
                                        </span>
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
                                        <span class="italic font-normal text-right text-indigo-600 pe-4 text-md">
                                            Вкупно Волумен
                                        </span>
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
        </div>
    </main>
</body>

</html>
