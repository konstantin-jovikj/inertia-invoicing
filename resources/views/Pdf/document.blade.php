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
                @if (!$document->is_for_export)
                    <span class="text-sm">{{ $convertedDocumentName }} Бр: </span>
                    <span class="text-lg">{{ $document->document_no }} </span>
                @else
                    <span class="text-sm">{{ $convertedDocumentName }} / {{ $document->documentType->type }} No:
                    </span>
                    <span class="text-lg">{{ $document->document_no }} </span>
                @endif
            </div>

            <div>
                @if (!$document->is_for_export)
                    <span class="text-sm">Датум: {{ date('d-m-Y', strtotime($document->date)) }}</span>
                @else
                    <span class="text-sm">Date: {{ date('d-m-Y', strtotime($document->date)) }} </span>
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
                @if ($document->is_for_export)
                    <span class="text-xs text-purple-700 italic">Paritet / Delivery / INCOTERMS:</span>
                    <span class="text-sm font-semibold ms-2">{{ $document->incoterm->shortcut }}
                        {{ $client->place->place }}</span>
                @endif
            </div>
        </div>
        <div class="border-b border-gray-500   w-full  ">
            <div class="">
                @if ($document->is_for_export)
                    <span class="text-xs text-purple-700 italic">Isporaka:</span>
                    <span class="text-sm font-semibold ms-2">{{ $document->delivery }}</span>
                @else
                    <span class="text-xs text-purple-700 italic">Испорака:</span>
                    <span class="text-sm font-semibold ms-2">{{ $document->delivery }}</span>
                @endif
            </div>
        </div>

        <div class="border-b border-gray-500   w-full flex ">
            <div class="w-[25%] border-e me-2 border-gray-500">
                @if ($document->is_for_export)
                    <span class="text-xs text-purple-700 italic">Currency:</span>
                    <span class="text-sm font-semibold ms-2">{{ $document->curency->symbol }} - {{ $document->curency->code }}</span>
                @else
                    <span class="text-xs text-purple-700 italic">Валута:</span>
                    <span class="text-sm font-semibold ms-2">{{ $document->curency->symbol }} - {{ $document->curency->code }}</span>
                @endif
            </div>
            <div class="w-[28%] border-e border-gray-500">
                @if ($document->is_for_export)
                    <span class="text-xs text-purple-700 italic">Bruto/Netto Kg:</span>
                    <span class="text-sm font-semibold mx-1">{{ $document->total_weight }} Kg</span>
                @else
                    <span class="text-xs text-purple-700 italic ps-1">Маса / Тежина:</span>
                    <span class="text-sm font-semibold mx-1">{{ $document->total_weight }} Kg</span>
                @endif
            </div>
        </div>
        </div>


        {{-- PRODUCTS TABLE --}}
        <div class="mt-4">
            <div class="w-full">
                <table class="table-auto w-full border-collapse border border-gray-300 text-xs py-4">
                    <thead>
                        <tr class="bg-sky-200">
                            <th class="border border-gray-300 px-2 py-1 text-left leading-none w-[30px]">
                                @if ($document->is_for_export)
                                    No
                                @else
                                    Бр
                                @endif
                            </th>

                            @if ($document->drawing_no)
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
                            <th class="border border-gray-300 px-2 py-1 text-left leading-none">
                                @if ($document->is_for_export)
                                    Price
                                @else
                                    Цена
                                @endif
                            </th>
                            <th class="border border-gray-300 px-2 py-1 text-left leading-none">
                                @if ($document->is_for_export)
                                    Тот.Price
                                @else
                                    Вк.Цена
                                @endif
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 0;
                        @endphp
                        @foreach ($document->products as $product)
                            @php
                                $i++;
                            @endphp
                            <tr class="bg-white">
                                <td class="border border-gray-300 px-2 py-1 leading-none">{{ $i }}</td>
                                @if ($document->drawing_no)
                                    <td class="border border-gray-300 px-2 py-1 leading-none">Data 2</td>
                                @endif
                                <td class="border border-gray-300 px-2 py-1 leading-none">{{ $product->description }}
                                    @if ($product->length)
                                        -{{ rtrim(rtrim(number_format($product->length, 2), '0'), '.') }}
                                    @endif
                                    @if ($product->width)
                                        x {{ rtrim(rtrim(number_format($product->width, 2), '0'), '.') }}
                                    @endif
                                    @if ($product->height)
                                        x {{ rtrim(rtrim(number_format($product->height, 2), '0'), '.') }}
                                    @endif
                                    @if ($product->manufacturers)
                                        <span class="text-small font-bold">
                                            - {{ $product->manufacturers->name }}
                                        </span>
                                    @endif
                                </td>
                                <td class="border border-gray-300 px-2 py-1 leading-none">{{ $product->qty }}</td>
                                <td class="border border-gray-300 px-2 py-1 leading-none">
                                    @if ($product->single_price != 0)
                                        {{ number_format($product->single_price, 2, '.', ',') }}
                                    @endif
                                </td>
                                <td class="border border-gray-300 px-2 py-1 leading-none">
                                    @if ($product->total_price != 0)
                                        {{ number_format($product->total_price, 2, '.', ',') }}
                                        {{-- {{ number_format($product->total_price, floor($product->total_price) == $product->total_price ? 0 : 2, '.', ',') }} --}}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </main>
</body>

</html>
