<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script defer type="module" src="/js/collection.js"></script>
    @vite(['resources/css/app.css'])
    <title>Collectie</title>
</head>
<body>
<h1>Dieren binnen geselecteerde gebieden</h1>
<form method="GET" action="{{ route('collectie') }}">
    <label for="region">Selecteer een gebied:</label>
    <select name="region" id="region">
        <option value="">Alle gebieden</option>
        @foreach(config('animals.defaultLocalities') as $locality)
            <option value="{{ $locality }}" {{ request('region') == $locality ? 'selected' : '' }}>
                {{ $locality }}
            </option>
        @endforeach
    </select>
</form>
<table>
    <thead>
    <tr>
        <th>Naam</th>
        <th>Wetenschappelijke naam</th>
        <th>Gebied</th>
    </tr>
    </thead>
    <tbody></tbody>
</table>
</body>
</html>
