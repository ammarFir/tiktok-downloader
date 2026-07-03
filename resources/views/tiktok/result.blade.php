<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil - TikTok Downloader</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-purple-600 to-blue-500 min-h-screen">
    <div class="container mx-auto px-4 py-20">
        <div class="max-w-2xl mx-auto">
            <a href="/" class="text-white/70 hover:text-white inline-block mb-6">
                ← Kembali
            </a>

            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                @if ($coverUrl)
                    <img src="{{ $coverUrl }}" alt="Thumbnail" class="w-full aspect-video object-cover">
                @endif

                <div class="p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-2">
                        {{ $author }}
                    </h2>
                    <p class="text-gray-600 text-sm mb-4">
                        {{ Str::limit($description, 100) }}
                    </p>

                    <a href="{{ route('download.stream', ['url' => urlencode($videoUrl)]) }}" download
                        class="block w-full bg-purple-600 text-white font-bold py-3 rounded-xl hover:bg-purple-700 transition text-center">
                        ⬇️ Download Video (No Watermark)
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
