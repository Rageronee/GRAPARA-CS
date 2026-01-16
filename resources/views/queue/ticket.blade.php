<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket Antrian - Grapara</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-xl shadow-2xl max-w-sm w-full text-center relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-500 to-purple-500"></div>

        <h2 class="text-gray-500 uppercase tracking-widest text-sm mb-2">Nomor Antrian Anda</h2>
        <div class="text-6xl font-black text-gray-800 mb-4 font-mono">
            {{ $queue->ticket_number }}
        </div>

        <div class="bg-gray-50 p-4 rounded-lg mb-6">
            <p class="text-sm text-gray-600 mb-1">Estimasi Menunggu</p>
            <p class="font-bold text-lg text-blue-600">3 Orang</p>
        </div>

        <p class="text-gray-400 text-xs mb-8">
            Silakan menunggu nomor Anda dipanggil. <br>
            Tiket dibuat pada: {{ $queue->created_at->format('H:i') }}
        </p>

        <a href="{{ url('/') }}"
            class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-6 rounded-full transition">
            Kembali ke Menu
        </a>
    </div>
</body>

</html>