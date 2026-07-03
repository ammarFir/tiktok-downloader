<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TikTok Downloader</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-purple-600 to-blue-500 min-h-screen">
    <div class="container mx-auto px-4 py-20">
        <div class="max-w-2xl mx-auto">
            <h1 class="text-4xl font-bold text-white text-center mb-2">
                🎥 TikTok Downloader
            </h1>
            <p class="text-white/80 text-center mb-8">
                Tempel link TikTok, download video tanpa watermark!
            </p>

            <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 shadow-2xl">
                <form action="{{ route('download.process') }}" method="POST">
                    @csrf
                    <div class="flex flex-col md:flex-row gap-3">
                        <input type="url" name="url" placeholder="https://www.tiktok.com/@username/video/123456"
                            class="flex-1 px-4 py-3 rounded-xl bg-white/20 text-white placeholder-white/60 border border-white/20 focus:outline-none focus:ring-2 focus:ring-white/50"
                            required>
                        <button type="submit"
                            class="px-8 py-3 bg-white text-purple-600 font-bold rounded-xl hover:bg-purple-50 transition">
                            ⬇️ Proses
                        </button>
                    </div>

                    @if (session('error'))
                        <div class="mt-4 p-3 bg-red-500/20 border border-red-500/50 rounded-lg text-white text-sm">
                            ❌ {{ session('error') }}
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</body>

</html>
