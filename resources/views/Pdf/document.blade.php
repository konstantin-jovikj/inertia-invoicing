<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/js/app.js')

</head>

<body class="w-11/12 m-auto py-4 px-6">
    {{-- <h1 class="text-xl text-purple-800 font-bold">Document</h1> --}}
    <header class="w-full flex gap-2">
        <div>
            <div class="w-[200px]">
                <img src="{{ asset('storage/' . $owner->logo) }}" alt="Logo">
                <div class="ms-4">
                    <p class="text-xs text-sky-800">{{$owner->name}}</p>
                    <p class="text-xs text-sky-800">{{$convertedOwner}}</p>
                    <p class="text-xs text-sky-800">{{ $owner->address }}</p>
                    <p class="text-xs text-sky-800">{{ $owner->place->zip }} - {{ $owner->place->place }}</p>
                    <p class="text-xs text-sky-800">{{ $owner->place->country->name }}</p>
                </div>
            </div>
        </div>
        <div class="w-[200px]">
            <img src="{{ asset('storage/' . $owner->cert) }}" alt="Logo">
        </div>
    </header>
</body>

</html>
