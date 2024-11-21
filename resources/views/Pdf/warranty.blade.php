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
    <h1 class="text-red-500">Гаранција</h1>
    <p>{{ $product->description}}</p>
    <p>{{ $client->name}}</p>
    <p>{{ $owner->name}}</p>

    <img src="{{ asset('storage/' . $owner->logo) }}" alt="Logo">

</body>
</html>