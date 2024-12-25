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
        <main class="mt-6 p-4">
            <div class="w-full uppercase font-bold">
                <p class="text-center">
                    <span>Товарен Лист за внатрешен превоз на стока Бр:</span>
                    <span>{{ $document->document_no }}</span>
                </p>
            </div>

            <div class="w-full border border-black mt-6">
                {{-- Продавач --}}
                <div class="border-b border-black">
                    <div class="px-2">
                        <span class="text-xs text-gray-500">Продавач</span>
                    </div>
                    <div class="pb-1 text-sm">
                        <p class="text-center font-semibold">{{ $owner->name }}</p>
                        <p class="text-center">
                            {{ $owner->address }} -
                            {{ $owner->place->zip }} -
                            {{ $owner->place->place }} -
                            {{ $owner->place->country->name }}
                        </p>

                    </div>
                </div>
                {{-- Купувач --}}
                <div class="border-b border-black">
                    <div class="px-2">
                        <span class="text-xs text-gray-500">Купувач</span>
                    </div>
                    <div class="pb-1 text-sm">
                        <p class="text-center font-semibold">{{ $client->name }}</p>
                        <p class="text-center">
                            {{ $client->address }} -
                            {{ $client->place->zip }} -
                            {{ $client->place->place }} -
                            {{ $client->place->country->name }}
                        </p>

                    </div>
                </div>

                {{-- Prevoznik --}}
                <div class="border-b border-black">
                    <div class="px-2">
                        <span class="text-xs text-gray-500">Продавач</span>
                    </div>
                    <div class="pb-1 text-sm">
                        <p class="text-center font-semibold">{{ $owner->name }}</p>
                        <p class="text-center">
                            {{ $owner->address }} -
                            {{ $owner->place->zip }} -
                            {{ $owner->place->place }} -
                            {{ $owner->place->country->name }}
                        </p>

                    </div>
                </div>
                {{-- Reg Broj Utovar Istovar --}}
                <div class="flex border-b border-black w-full">
                    <div class="w-1/3 px-2 border-e border-black">
                        <p class="text-xs text-gray-500">Регистарски Број на Возило:</p>
                        @if ($document->vehicle)
                            <p class="text-center py-6">{{ $document->vehicle->register_plate_number }}</p>
                        @endif
                    </div>
                    <div class="w-1/3 border-e border-black">
                        <div class="border-b border-black">
                            <p class="text-xs text-gray-500 px-2">Место Утовар</p>
                            <p class="text-center py-2">{{ $document->load_place->place }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 px-2">Дата Утовар</p>
                            <p class="text-center py-2">{{ date('d.m.Y', strtotime($document->load_date)) }}
                        </div>
                    </div>
                    <div class="w-1/3 ">
                        <div class="border-b border-black">
                            <p class="text-xs text-gray-500 px-2">Место Истовар</p>
                            <p class="text-center py-2">{{ $document->unload_place->place }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 px-2">Дата Истовар</p>
                            <p class="text-center py-2">{{ date('d.m.Y', strtotime($document->unload_date)) }}
                        </div>
                    </div>

                </div>
                {{-- Broj, paketi tezina Volumen --}}
                <div class="flex border-b border-black w-full py-0">
                    <div class="w-1/5 px-2 border-e border-black py-0">
                        <p class="text-xs text-gray-500 py-0">Ознака/Број</p>
                        <p class="text-center  py-0">{{ $document->marking }}</p>
                    </div>
                    <div class="w-1/5 border-e border-black py-0">
                        <p class="text-xs text-gray-500 px-2 py-0">Број на Пакети</p>
                        <p class="text-center py-0">{{ $document->boxes_nr }}</p>
                    </div>
                    <div class="w-1/5 border-e border-black py-0">
                        <p class="text-xs text-gray-500 px-2 py-0">Вид на Амбалажа</p>
                        <p class="text-center py-0">{{ $document->packaging_type }}</p>
                    </div>
                    <div class="w-1/5 border-e border-black py-0">
                        <p class="text-xs text-gray-500 px-2 py-0">Бруто тежина</p>
                        <p class="text-center py-0">{{ $document->total_weight }}</p>
                    </div>
                    <div class="w-1/5 py-0">
                        <p class="text-xs text-gray-500 px-2 py-0">Зафатнина m<sup>3</p>
                        <p class="text-center py-0">{{ $document->total_volume }}</p>
                    </div>

                </div>

                <div class="flex border-b border-black w-full px-2">
                    <p class="text-xs text-gray-500">Вид на Стока</p>
                    <p class="text-center py-6">{{ $document->goods_type }}</p>
                </div>

                <div class="flex border-b border-black w-full px-2">
                    <p class="text-xs text-gray-500">Забелешки и ограничувања на Превозникот</p>
                    <p class="text-center py-6">{{ $document->note }}</p>
                </div>
                <div class="flex border-b border-black w-full px-2">
                    <p class="text-xs text-gray-500">Дополнителни инструкции при превоз на стоката</p>
                    <p class="text-center py-6">{{ $document->instruction }}</p>
                </div>
                <div class="flex  w-full px-2">
                    <p class="text-xs text-gray-500">Робата за Презема</p>
                    <p class="text-center py-6">{{ $document->picked_up_by }} на
                        {{ date('d.m.Y', strtotime($document->unload_date)) }} во {{ $document->unload_place->place }}
                    </p>
                </div>
            </div>




        </main>
        <footer class="w-full flex justify-between p-4" style="margin-top: 80px;">
            <div class="w-1/3 flex flex-col items-center gap-2 text-xs">
                <p>_________________________________</p>
                <p>Печат и потпис на испраќачот</p>
            </div>
            <div class="w-1/3 flex flex-col items-center gap-2 text-xs">
                <p>_________________________________</p>
                <p>Печат и потпис на превозникот</p>
            </div>
            <div class="w-1/3 flex flex-col items-center gap-2 text-xs">
                <p>_________________________________</p>
                <p>Печат и потпис на примачот</p>
            </div>
        </footer>
    </div>

    </div>
</body>

</html>
