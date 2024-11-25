<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/js/app.js')

</head>

<body class="w-11/12 m-auto py-4 px-4">
    {{-- <h1 class="text-xl text-purple-800 font-bold">Document</h1> --}}
    <header class="w-full flex gap-8">
        <div>
            <div class="w-[230px]">
                <img src="{{ asset('storage/' . $owner->logo) }}" alt="Logo">
                <div class="flex gap-2 border-t border-sky-700 w-full">
                    <div class="w-1/2">
                        @if ($document->is_for_export)
                            <p class="text-xs text-sky-800">{{ $owner->name }}</p>
                            <p class="text-xs text-sky-800">{{ $owner->address }}</p>
                        @else
                            <p class="text-xs text-sky-800">{{ $convertedOwner }}</p>
                            <p class="text-xs text-sky-800">{{ $convertedAddress }}</p>
                        @endif
                    </div>
                    <div class="w-1/2">
                        @if ($document->is_for_export)
                            <p class="text-xs text-sky-800">{{ $owner->place->zip }} - {{ $owner->place->place }}</p>
                            <p class="text-xs text-sky-800">{{ $owner->place->country->name }}</p>
                        @else
                            <p class="text-xs text-sky-800">{{ $owner->place->zip }} - {{ $convertedPlace }}</p>
                            <p class="text-xs text-sky-800">{{ $convertedCountry }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="w-[200px]">
            <img src="{{ asset('storage/' . $owner->cert) }}" alt="Logo">
        </div>
        <div id="bank_account">
            <div id="bank_account">
                @if ($document->is_for_export)
                    <div class="flex flex-col">
                        @foreach ($owner->accounts as $account)
                            @if ($account->is_for_export)
                                <p class="text-xs font-bold">{{ $account->bank->name_lat }}</p>
                                <p class="text-xs">Acc.No:{{ $account->account_no }}</p>
                                <p class="text-xs">SWIFT:{{ $account->swift }}</p>
                                <p class="text-xs">IBAN:{{ $account->iban }}</p>
                            @endif
                        @endforeach
                    </div>
                @endif

                @if (!$document->is_for_export)
                    <div class="flex flex-col">
                        @foreach ($owner->accounts as $account)
                            @if (!$account->is_for_export)
                                <p class="text-xs font-bold">{{ $account->bank->name_cyr }}</p>
                                <p class="text-xs">Жиро Сметка:{{ $account->giro_account }}</p>
                            @endif
                        @endforeach
                        <p class="text-xs">Даночен Број:{{ $owner->tax_number }}</p>
                    </div>
                @endif
            </div>

        </div>
    </header>
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

        <div class="border-b border-gray-300 pb-1 ">

            {{-- Pravno Lice --}}
            @if ($client->customer->customerType->id !== 1)
                @if (!$document->is_for_export)
                    <div>
                        <span class="text-sm"><span class="text-xs text-gray-500">Фирма:
                            </span>{{ $client->name }}</span>
                    @else
                        <span class="text-sm"><span class="text-xs text-gray-500">Company: </span> {{ $client->name }}
                        </span>
                    </div>
                @endif
            @endif

            {{-- Fizicko Lice --}}
            @if ($client->customer->customerType->id == 1)
                @if (!$document->is_for_export)
                    <div>
                        <span class="text-sm"><span class="text-xs text-gray-500">Име и Презиме:
                            </span>{{ $client->name }}</span>
                    @else
                        <span class="text-sm"><span class="text-xs text-gray-500">First and Last Name: </span>
                            {{ $client->name }}
                        </span>
                    </div>
                @endif
            @endif
        </div>
        </div>
        <div class="border-b border-gray-300  flex w-full gap-2 ">
            <div class="w-[33%] border-x border-gray-300">
                @if ($document->is_for_export)
                    <p class="text-sm"><span class="text-xs text-gray-500">Address:
                        </span>{{ $client->address }}</p>
                    <p class="text-sm ms-11">{{ $client->place->zip }} - {{ $client->place->place }}</p>
                    <p class="text-sm ms-11">{{ $client->place->country->name }}</p>
                @else
                    <p class="text-sm"><span class="text-xs text-gray-500">Адреса:
                        </span>{{ $client->address }}</p>
                    <p class="text-sm ms-11">{{ $client->place->zip }} - {{ $client->place->place }}</p>
                    <p class="text-sm ms-11">{{ $convertedCountryClient }}</p>
                @endif
            </div>
            <div class="w-[33%]  border-gray-300">
                @if ($document->is_for_export)
                    <p class="text-sm"><span class="text-xs text-gray-500">Delivery:
                        </span></p>
                    <p class="text-sm ms-11">{{ $document->incoterm->shortcut }} {{ $client->place->place }}</p>
                @else
                    <p class="text-sm"><span class="text-xs text-gray-500">Испорака:
                        </span>{{ $client->address }}</p>
                        <p class="text-sm ms-11">{{ $document->incoterm->shortcut }} {{ $client->place->place }}</p>
                @endif
            </div>

            <div class="w-[33%] border-x border-gray-300">
                @if ($document->is_for_export)
                    <p class="text-sm"><span class="text-xs text-gray-500">Delivery:
                        </span></p>
                    <p class="text-sm ms-11">{{ $document->incoterm->shortcut }} {{ $client->place->place }}</p>
                @else
                    <p class="text-sm"><span class="text-xs text-gray-500">Испорака:
                        </span>{{ $client->address }}</p>
                        <p class="text-sm ms-11">{{ $document->incoterm->shortcut }} {{ $client->place->place }}</p>
                @endif
            </div>

        </div>
    </main>
</body>

</html>
