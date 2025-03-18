<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* Menghilangkan panah di input type number untuk browser berbasis Webkit (Chrome, Safari, dll) */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Menghilangkan panah di input type number untuk Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        /* Tambahan CSS opsional untuk memastikan tampilan yang rapi */
        input[type=number] {
            appearance: textfield;
        }
    </style>
</head>

<body class="h-full bg-gradient-to-r from-slate-800 to-blue-900 text-white">
    <div class="min-h-full flex items-center justify-center ">
        <div class="w-full">
            {{ $slot }}
        </div>
    </div>
</body>

</html>
