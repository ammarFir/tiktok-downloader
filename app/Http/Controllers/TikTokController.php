<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TikTokController extends Controller
{
    public function index()
    {
        return view('tiktok.index');
    }

    public function process(Request $request)
    {
        //validasi url
        $request->validate([
            'url' => 'required|url|starts_with:https://www.tiktok.com'
        ]);

        try {
            //ambil html dari tiktok 
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
            ])->get($request->url);

            $html = $response->body();

            //cari data
            preg_match('/<script id="__UNIVERSAL_DATA_FOR_REHYDRATION__" type="application\/json">(.*?)<\/script>/', $html, $matches);

            if (empty($matches[1])) {
                throw new \Exception('Gagal mengambil video');
            }
            $data = json_decode($matches[1], true);

            //ambilurl video dari data
            $videoUrl = $data['__DEFAULT_SCOPE__']['webapp.video-detail']['itemInfo']['itemStruct']['video']['playAddr'] ?? null;
            $coverUrl = $data['__DEFAULT_SCOPE__']['webapp.video-detail']['itemInfo']['itemStruct']['video']['cover'] ?? null;
            $author = $data['__DEFAULT_SCOPE__']['webapp.video-detail']['itemInfo']['itemStruct']['author']['uniqueId'] ?? 'Unknown';
            $description = $data['__DEFAULT_SCOPE__']['webapp.video-detail']['itemInfo']['itemStruct']['desc'] ?? 'No desription';

            if (!$videoUrl) {
                throw new \Exception('URL Video tidak ditemukan');
            }

            //kirim ke view reslut
            return view('tiktok.result', compact('videoUrl', 'coverUrl', 'author', 'description'));
        } catch (\Exception $e) {
            return back()->with('error', 'gagal proses : ' . $e->getMessage());
        }
    }
}
