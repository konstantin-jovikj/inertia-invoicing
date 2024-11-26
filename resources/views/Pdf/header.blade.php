<div class="header flex">
    <div class="image-wrapper ">
        <img class="image-width" src="{{ $logo }}" alt="Logo">
        <div class="flex">
            <div class="w-50">
                @if ($document->is_for_export)
                <p class="text-small">{{ $owner->name }}</p>
                <p class="text-small">{{ $owner->address }}</p>
                @else
                <p class="text-small">{{ $convertedOwner }}</p>
                <p class="text-small">{{ $convertedAddress }}</p>
                @endif
            </div>
            <div class="w-50">
                @if ($document->is_for_export)
                <p class="text-small">{{ $owner->place->zip }} - {{ $owner->place->place }}</p>
                <p class="text-small">{{ $owner->place->country->name }}</p>
                @else
                <p class="text-small">{{ $owner->place->zip }} - {{ $convertedPlace }}</p>
                <p class="text-small">{{ $convertedCountry }}</p>
                @endif
            </div>
        </div>
    </div>
    <div class="image-wrapper ">
        <img class="image-width" src="{{ $cert }}" alt="Cert">
    </div>
    <div class="image-wrapper bank">
        <div id="bank_account">
            @if ($document->is_for_export)
                <div class="flex flex-col">
                    @foreach ($owner->accounts as $account)
                        @if ($account->is_for_export)
                            <p class="text-medium font-bold">{{ $account->bank->name_lat }}</p>
                            <p class="text-medium">Acc.No:{{ $account->account_no }}</p>
                            <p class="text-medium">SWIFT:{{ $account->swift }}</p>
                            <p class="text-medium">IBAN:{{ $account->iban }}</p>
                        @endif
                    @endforeach
                </div>
            @endif

            @if (!$document->is_for_export)
                <div class="flex flex-col">
                    @foreach ($owner->accounts as $account)
                        @if (!$account->is_for_export)
                            <p class="text-medium font-bold">{{ $account->bank->name_cyr }}</p>
                            <p class="text-medium">Жиро Сметка:{{ $account->giro_account }}</p>
                        @endif
                    @endforeach
                    <p class="text-medium">Даночен Број:{{ $owner->tax_number }}</p>
                </div>
            @endif
        </div>
    </div>

</div>

<style>
    .bank{
        padding-left: 15px;
    }
    .flex-col{
        flex-direction: column;
    }
    .font-color{
        color: blue;
    }

    .font-bold{
        font-weight: bold;

    }
    .text-small{
        font-size: 9px;
        line-height: 5px;
        text-align: left;

    }

    .text-medium{
        font-size: 12px;
        line-height: 5px;
        text-align: left;

    }
    .w-50{
        width: 50%;
    }

    .w-100{
        width:100%;
    }

    .flex {
        display: flex;
    }

    .header {
        position: fixed;
        color: gray;
        top: 0;
        left: 0;
        right: 0;
        height: 20px;
        text-align: center;
        line-height: 20px;
        font-size: 9px;
        z-index: 1000;
        padding-top: 10px;
        padding-left: 40px;
    }

    .image-wrapper {
        width: 230px;
        /* height: 250px; */
        background-color: rgb(255, 0, 0);
    }

    .text-color {
        color: rgb(255, 0, 0);
    }

    .image-width {
        width: 100%;
    }
</style>
