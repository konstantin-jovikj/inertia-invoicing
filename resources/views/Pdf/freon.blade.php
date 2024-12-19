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
        <header class="w-full flex justify-between m-auto">
            <div class="px-4">
                <p class="font-bold">{{ $product->document->owner->name }}</p>
                <p class="text-xs">{{ $product->document->owner->address }}</p>
                <p class="text-xs">{{ $product->document->owner->place->zip }} -
                    {{ $product->document->owner->place->place }}</p>
                <p class="text-xs">{{ $product->document->owner->place->country->name }}</p>
            </div>
            <div class="w-[250px]">
                @if ($product->document->owner->logo)
                    <img src="{{ asset('storage/' . $product->document->owner->logo) }}" alt="Logo">
                @endif
            </div>
            <div class="w-[200px] pe-4">
                @if ($product->document->owner->cert)
                    <img src="{{ asset('storage/' . $product->document->owner->cert) }}" alt="Cert">
                @endif
            </div>
        </header>
        <main class="w-full  px-6 mt-12">
            <div>
                <p class="mx-auto text-center text-xl font-bold uppercase">Изјава / Statement</p>
            </div>
            <div class="mt-14">
                <p class="px-8 text-sm">Со овој документ потврдуваме дека во нашиот производ, го користиме следниот тип
                    на фреон:</p>
                <p class="px-8 text-sm">With this document, we confirm that in our product, we use the following type of
                    refrigerant:</p>
            </div>

            <div class="w-10/12 mx-auto mt-10">
                <table class="w-full  text-center text-gray-800 dark:text-gray-400 border border-black h-4">

                    <tbody>
                        <tr class="text-xs ">
                            <th class="border-e border-black p-1 bg-gray-200 uppercase">Модел / Model</th>
                            <td class="border-e border-black text-purple-800 font-semibold">
                                @if ($product->model)
                                    {{ $product->model->model }}
                                @endif
                            </td>
                        </tr>
                        <tr class="text-xs ">
                            <th class="border border-black p-1 bg-gray-200 uppercase">Сериски Број / Serial Number</th>
                            <td class="border border-black text-purple-800 font-semibold">
                                @if ($product->serial_no)
                                    {{ $product->serial_no }}
                                @endif
                            </td>
                        </tr>
                        <tr class="text-xs ">
                            <th class="border border-black p-1 bg-gray-200 uppercase">HFC тип / HFC Type</th>
                            <td class="border border-black text-purple-800 font-semibold">
                                @if ($product->refrigerant)
                                    {{ $product->refrigerant->short_name }}
                                @endif
                            </td>
                        </tr>
                        <tr class="text-xs ">
                            <th class="border border-black p-1 bg-gray-200 uppercase">HFC Количина / HFC Quantity</th>
                            <td class="border border-black text-purple-800 font-semibold">
                                @if ($product->hfc_qty)
                                    {{ $product->hfc_qty }} Kg
                                @endif
                            </td>
                        </tr>
                        <tr class="text-xs ">
                            <th class="border border-black p-1 bg-gray-200 uppercase">GWP ( Global Warming Potential)</th>
                            <td class="border border-black text-purple-800 font-semibold">
                                @if ($product->refrigerant)
                                    {{ $product->refrigerant->gwp }}
                                @endif
                            </td>
                        </tr>
                        <tr class="text-xs ">
                            <th class="border border-black p-1 bg-gray-200 uppercase">CO<sub>2</sub><span class="lowercase">-e</span></th>
                            <td class="border border-black text-purple-800 font-semibold">
                                @if ($product->co2)
                                    {{ $product->co2}} Kg
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="w-10/12 mx-auto mt-10">
                <p class="mx-auto text-center text-sm font-medium uppercase">Карактеристики и својства / Characteristics and Properties</p>
            </div>

            <div class="w-10/12 mx-auto mt-10">
                <table class="w-full  text-center text-gray-800 dark:text-gray-400 border border-black h-4">

                    <tbody>
                        <tr class="text-xs ">
                            <th class="border-e border-black p-1 bg-gray-200 uppercase">Ознака, Кратко Име / Short Name</th>
                            <td class="border-e border-black text-purple-800 font-semibold">
                                @if ($product->refrigerant)
                                    {{ $product->refrigerant->short_name }}
                                @endif
                            </td>
                        </tr>
                        <tr class="text-xs ">
                            <th class="border border-black p-1 bg-gray-200 uppercase">Синоним / Synonym</th>
                            <td class="border border-black text-purple-800 font-semibold">
                                @if ($product->refrigerant)
                                    {{ $product->refrigerant->synonym }}
                                @endif
                            </td>
                        </tr>
                        <tr class="text-xs ">
                            <th class="border border-black p-1 bg-gray-200 uppercase">Хемиска Формула / Chemical Formula</th>
                            <td class="border border-black text-purple-800 font-semibold">
                                @if ($product->refrigerant)
                                    {{ $product->refrigerant->formula }}
                                @endif
                            </td>
                        </tr>
                        <tr class="text-xs ">
                            <th class="border border-black p-1 bg-gray-200 uppercase">Точка на Вриење / Boiling Point</th>
                            <td class="border border-black text-purple-800 font-semibold">
                                @if ($product->refrigerant)
                                    {{ $product->refrigerant->boiling_point }}
                                @endif
                            </td>
                        </tr>
                        <tr class="text-xs ">
                            <th class="border border-black p-1 bg-gray-200 uppercase">Точка на Замрзнување / Freezing Point</th>
                            <td class="border border-black text-purple-800 font-semibold">
                                @if ($product->refrigerant)
                                    {{ $product->refrigerant->freezing_point }}
                                @endif
                            </td>
                        </tr>
                        <tr class="text-xs ">
                            <th class="border border-black p-1 bg-gray-200 uppercase">Запаливост / Flammability</th>
                            <td class="border border-black text-purple-800 font-semibold">
                                @if ($product->refrigerant)
                                    {{ $product->refrigerant->flammability }}
                                @endif
                            </td>
                        </tr>
                        <tr class="text-xs ">
                            <th class="border border-black p-1 bg-gray-200 uppercase">Оксидирање / Оxidizing</th>
                            <td class="border border-black text-purple-800 font-semibold">
                                @if ($product->refrigerant)
                                    {{ $product->refrigerant->oxidizing }}
                                @endif
                            </td>
                        </tr>
                        <tr class="text-xs ">
                            <th class="border border-black p-1 bg-gray-200 uppercase">Притисок на Пареа / Vapour Pressure</th>
                            <td class="border border-black text-purple-800 font-semibold">
                                @if ($product->refrigerant)
                                    {{ $product->refrigerant->vapour_pressure }}
                                @endif
                            </td>
                        </tr>
                        <tr class="text-xs ">
                            <th class="border border-black p-1 bg-gray-200 uppercase">Релативна Густина / Relative Density </th>
                            <td class="border border-black text-purple-800 font-semibold">
                                @if ($product->refrigerant)
                                    {{ $product->refrigerant->relative_density }}  / Kg/m<sup>3</sup>
                                @endif
                            </td>
                        </tr>
                        <tr class="text-xs ">
                            <th class="border border-black p-1 bg-gray-200 uppercase">Температура на Испарување / Evaporating Temperature </th>
                            <td class="border border-black text-purple-800 font-semibold">
                                @if ($product->refrigerant)
                                    {{ $product->refrigerant->evaporating_temp }}
                                @endif
                            </td>
                        </tr>

                        
                    </tbody>
                </table>
            </div>

            <footer>
                <div class="w-10/12 flex justify-end mt-16">
                    <div class="w-full  flex flex-col items-end gap-4 text-xs">
                        <p>{{$product->document->owner->name}} - {{$product->document->owner->place->place}} - {{date('d.m.Y', strtotime($product->document->date))}}</p>
                        <p> ________________________________________ </p>
                    </div>
                </div>
            </footer>

        </main>

    </div>
</body>

</html>
