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
                @else
                    @if ($document->is_for_advanced_payment)
                        <span>Авансна</span>
                    @endif
                    <span class="text-sm">
                        @if (!$document->is_for_export)
                            {{ $convertedDocumentName }} Бр: 
                        @else
                            {{ $convertedDocumentName }} / {{ $document->documentType->type }} No: 
                        @endif
                    </span>
                    <span class="text-lg">{{ $document->document_no }}</span>
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

SMETKO POTVRDA



    </main>
</body>

</html>
