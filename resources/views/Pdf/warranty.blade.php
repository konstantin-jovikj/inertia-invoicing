<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/js/app.js')

</head>

<body>
    <div class="m-4">
        <header class="w-10/12 flex justify-between m-auto">
            <div class="ps-8">
                <p class="font-bold">{{ $owner->name }}</p>
                <p class="text-xs">{{ $owner->address }}</p>
                <p class="text-xs">{{ $owner->place->zip }} - {{ $owner->place->place }}</p>
                <p class="text-xs">{{ $owner->place->country->name }}</p>
            </div>
            <div class="w-[250px]">
                <img src="{{ asset('storage/' . $owner->logo) }}" alt="Logo">
            </div>
        </header>
        <main class="mt-8">
            <div>
                <h1 class="text-center text-2xl font-medium uppercase">Гарантен Лист Бр:
                    <span>{{ $product->id }}-{{ $document->document_no }}</span>
                </h1>
            </div>

            <div class="mt-10 w-3/4 m-auto">
                <p> <span class="text-sm italic">Производ:</span> <span class="text-purple-800 font-medium">
                        {{ $product->description }}-{{ $product->length }} x {{ $product->width }} x
                        {{ $product->height }}</span> </p>
                <p> <span class="text-sm italic">Купувач:</span> <span class="text-purple-800 font-medium">
                        {{ $client->name }}</span> </p>
                <p> <span class="text-sm italic">Датум на Продажба:</span> <span class="text-purple-800 font-medium">
                        {{ date('d-m-Y', strtotime($document->date)) }}</span> </p>
                @if ($product->serial_no)
                    <p> <span class="text-sm italic">Сериски Број:</span> <span class="text-purple-800 font-medium">
                            {{ $product->serial_no }}</span> </p>
                @endif
                <p> <span class="text-sm italic">Број на {{ $product->document->documentType->type }} :</span> <span
                        class="text-purple-800 font-medium"> {{ $product->document->document_no }}</span> </p>
            </div>

            <div class="mt-10">
                <h3 class="text-center font-medium text-lg">Гарантниот рок важи 12месеци од денот на продажба.</h3>
                <h4 class="text-center font-medium text-md mt-4">Гаранциска Изјава:</h4>
                <div class="mt-8 w-10/12 m-auto">
                    <p class=" ">{{ $owner->name }} гарантира беспрекорно функционирање на купениот производ во
                        гарантниот рок</p>
                    <p class=" mt-2">{{ $owner->name }} се обврзува , на Ваше барање, доколку производот е во
                        гарантен рок
                        да го поправи дефектот и техничките недостатоци кај производот настанати со нормална
                        употреба во рокот за кој се дава гаранција.</p>
                    <p class=" mt-2 text-center font-medium">Гаранцијата не опфаќа:</p>
                </div>
                <div class="mt-8 w-10/12 m-auto">
                    <ul class="list-disc">
                        <li>Дефекти настанати како резултат на нормално абење.</li>
                        <li>Дефекти настанати поради несоодветен начин на употреба на производот.</li>
                        <li>Дефекти настанати од физичко оштетување ( дури и случајно), со користење на
                            неоригинални делови, и со сервисирање или модификација која ја направило лице
                            кое не е овластено од {{ $owner->name }} за таа работа.</li>
                        <li>Ако водениот греач кај топлите уреди останал без потребното ниво на вода.</li>
                        <li>Напукнување или кршење на стакло кај било кој уред, не е дел од гаранцијата.</li>
                        <li>Дефекти од природнинкатастрофи( гром, поплава, пожар и други природни непогоди),
                            електричен удар, нестабилно напојување и проблем со електричната исталација. </li>
                        <li>Гаранцијата престанува да важи доколку се констатира дека производот е отваран од
                            страна на неовластено лице. </li>
                    </ul>
                </div>
                <footer>
                    <div class="w-10/12 flex justify-end">
                        <div class="w-full  flex flex-col items-end gap-8">
                            <p>Одговорно Лице: ________________________ ;</p>
                            <p>Печат и потпис: ________________________ ;</p>
                        </div>
                    </div>
                </footer>
            </div>
        </main>

    </div>
</body>

</html>
