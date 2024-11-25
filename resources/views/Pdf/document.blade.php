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
        <div class="border-t-2 border-sky-700 mt-2">
            @if (!$document->is_for_export)
                <p class="text-sm">{{ $document->documentType->type }}</p>
            @else
            <p class="text-sm">{{ $document->documentType->type }}</p>
                <p class="text-sm">{{ $convertedDocumentName }}</p>
            @endif

        </div>
    </main>
</body>

</html>
