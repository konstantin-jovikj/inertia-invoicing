<div class="header flex">
    <div class="image-wrapper ">
        @if ($logo)
            <img class="image-width logo-height" src="{{ $logo }}" alt="Logo">
        @else
            <p>Место за Лого</p>
        @endif
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
        <p class="text-small font-bold web">{{ $owner->web }}</p>
    </div>
    <div class="image-wrapper">
        @if ($cert)
            <img class="image-width cert-height" src="{{ $cert }}" alt="Cert">
        @else
            <p>Место за сертификат</p>
        @endif

    </div>
    <div class="image-wrapper bank ">
        <div id="bank_account">
            @if ($document->is_for_export)
                <div class="">
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
                <div class="">
                    @foreach ($owner->accounts as $account)
                        @if (!$account->is_for_export)
                            <p class="text-medium font-bold">{{ $account->bank->name_cyr }}</p>
                            <p class="text-medium">Жиро Сметка:{{ $account->giro_account }}</p>
                        @endif
                    @endforeach
                    <hr class="line">
                    <p class="text-medium font-bold">Даночен Број:{{ $owner->tax_number }}</p>
                </div>
            @endif
        </div>
    </div>

</div>

<style>
    .web {
        margin-top: 5px;
        text-align: center;
    }

    p {
        padding: 5px;
        margin: 0;
    }

    .line p {
        padding: 0;
        margin: 0;
    }

    .bank {
        padding-left: 15px;
        line-height: 10px;
    }

    .flex-col {
        flex-direction: column;
    }

    .font-color {
        color: blue;
    }

    .font-bold {
        font-weight: bold;

    }

    .text-small {
        font-size: 9px;
        line-height: 5px;
        text-align: left;
        padding: 3px;
        margin: 0;

    }

    .text-medium {
        font-size: 12px;
        line-height: 5px;
        text-align: left;

    }

    .w-50 {
        width: 50%;
    }

    .w-100 {
        width: 100%;
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
        padding-top: 20px;
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
    .logo-height {
        max-height: 61px;
    }

    .cert-height{
        max-height: 94px;
        margin-left: 5px;
        padding: 0 5px;
    }
</style>
