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
        <div class="border-y-2 border-sky-700 mt-2 py-2 font-bold flex flex-row justify-around">
            <div>
                <span class="text-xl">
                    @if (!$document->is_for_export)
                        {{ $convertedDocumentName }} Бр:
                    @else
                        {{ $convertedDocumentName }} / {{ $document->documentType->type }} No:
                    @endif
                </span>
                <span class="text-xl">{{ $document->document_no }}</span>
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

        <div class=" pb-1 mt-10">

            {{-- Pravno Lice --}}
            @if ($client->customer->customerType->id !== 1)
                @if (!$document->is_for_export)
                    <div>
                        <span class="text-lg text-purple-700 italic">Од:</span>
                        <span class="text-lg font-bold ms-2">{{ $client->name }}</span>
                    @else
                        <span class="text-lg text-purple-700 italic">From: </span>
                        <span class="text-lg font-bold ms-2"> {{ $client->name }}</span>
                    </div>
                @endif
            @endif

            {{-- Fizicko Lice --}}
            @if ($client->customer->customerType->id == 1)
                @if (!$document->is_for_export)
                    <div>
                        <span class="text-lg  font-bold ms-4"><span class="text-xs text-purple-700 italic">Име и
                                Од:
                            </span>{{ $client->name }}</span>
                    @else
                        <span class="text-lg font-bold ms-4"><span class="text-xs text-purple-700 italic">First and Last
                                From: </span>
                            {{ $client->name }}
                        </span>
                    </div>
                @endif
            @endif
        </div>
        </div>
        <div class="   w-full  ">
            <div class="mb-2">
                @if ($document->is_for_export)
                    <span class="text-lg text-purple-700 italic ">Place / Address:</span>
                    <span class="text-lg ms-4 font-semibold">{{ $client->address }}</span>
                    <span class="text-lg font-semibold">-{{ $client->place->zip }} -
                        {{ $client->place->place }}</span>
                    <span class="text-lg font-semibold">-{{ $client->place->country->name }}</span>
                @else
                    <span class="text-lg text-purple-700 italic">Место / Адреса:</span>
                    <span class="text-lg ms-4 font-semibold">{{ $client->address }}</span>
                    <span class="text-lg font-semibold">{{ $client->place->zip }} - {{ $client->place->place }}</span>
                    <span class="text-lg font-semibold">{{ $client->place->country->name }}</span>
                @endif
            </div>
        </div>
        <div class="   w-full  ">
            <div class="mb-2">
                @if ($document->is_for_export)
                    <span class="text-lg text-purple-700 italic">Ammount:</span>
                    <span class="text-lg ms-4 font-semibold">
                        @foreach ($products as $product)
                            @if ($product->total_price != 0)
                                {{ number_format($document->total_with_tax_and_discount, 2, '.', ',') }}
                                {{ $document->curency->symbol }}
                            @endif
                        @endforeach
                    </span>
                @else
                    <span class="text-lg text-purple-700 italic">Сума од:</span>
                    <span class="text-lg ms-4 font-semibold">
                        @foreach ($products as $product)
                            @if ($product->total_price != 0)
                                {{ number_format($document->total_with_tax_and_discount, 2, '.', ',') }}
                                {{ $document->curency->symbol }}
                            @endif
                        @endforeach
                    </span>

                @endif
            </div>
        </div>
        {{-- So zborovi --}}
        <div class="   w-full  ">
            <div class="mb-2">
                @if ($document->is_for_export)
                    <span class="text-lg text-purple-700 italic">With words:</span>
                    <span class="text-lg ms-4 font-semibold">
                        With words
                    </span>
                @else
                    <span class="text-lg text-purple-700 italic">Со зборови:</span>
                    <span class="text-lg ms-4 font-semibold">
                        Со зборови
                    </span>
                @endif
            </div>
        </div>

        {{-- Na smetka na --}}
        <div class="   w-full  ">
            <div class="mb-2">
                @if ($document->is_for_export)
                    <span class="text-lg text-purple-700 italic">To the Account of:</span>
                    <span class="text-lg ms-4 font-semibold">
                        {{ $owner->name }} - {{ $owner->place->place }}
                    </span>
                @else
                    <span class="text-lg text-purple-700 italic">На сметка на:</span>
                    <span class="text-lg ms-4 font-semibold">
                        {{ $owner->name }} - {{ $owner->place->place }}
                    </span>
                @endif
            </div>
        </div>
        {{-- Za --}}
        <div class="   w-full  ">
            <div class="mb-2">
                @if ($document->is_for_export)
                    <span class="text-lg text-purple-700 italic">For:</span>
                    <span class="text-lg ms-4 font-semibold">
                        @foreach ($products as $product)
                            @if ($product->total_price != 0)
                                {{ $product->description }}
                            @endif
                        @endforeach
                    </span>
                @else
                    <span class="text-lg text-purple-700 italic">За:</span>
                    <span class="text-lg ms-4 font-semibold">
                        @foreach ($products as $product)
                            @if ($product->total_price != 0)
                            {{ $product->description }}
                            @endif
                        @endforeach
                    </span>

                @endif
            </div>
        </div>


        <div class="   w-full  border-t-2 border-sky-700 h-[5px] my-10">
        </div>


        <div class="w-full flex">
            <div class="w-1/2">
                <p class="italic font-sm mb-4" >Уплатил: </p>
                <p>____________________________________</p>
            </div>
            <div class="w-1/2">
                <p class="italic font-sm mb-4">Примил: </p>
                <p>____________________________________</p>
            </div>
        </div>


    </main>
</body>

</html>
