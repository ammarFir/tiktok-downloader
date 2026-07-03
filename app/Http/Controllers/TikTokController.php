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
            // Panggil API TikWM
            $response = Http::get('https://www.tikwm.com/api/', [
                'url' => $request->url
            ]);

            $data = $response->json();

            if ($data['code'] !== 0) {
                throw new \Exception('Gagal ambil data dari API');
            }

            $videoUrl = $data['data']['play'] ?? null;
            $coverUrl = $data['data']['cover'] ?? null;
            $author = $data['data']['author']['unique_id'] ?? 'Unknown';
            $description = $data['data']['title'] ?? 'No description';

            if (!$videoUrl) {
                throw new \Exception('URL video tidak ditemukan');
            }

            return view('tiktok.result', compact('videoUrl', 'coverUrl', 'author', 'description'));
        } catch (\Exception $e) {
            return back()->with('error', 'gagal proses : ' . $e->getMessage());
        }
    }

    public function stream(Request $request)
    {
        $videoUrl = urldecode($request->url);

        // Tambahin cookie biar dianggap user beneran
        $response = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            'Referer' => 'https://www.tiktok.com/',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8',
            'Accept-Language' => 'id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7',
            'Accept-Encoding' => 'gzip, deflate, br',
            'Connection' => 'keep-alive',
            'Sec-Ch-Ua' => '"Not_A Brand";v="8", "Chromium";v="120", "Google Chrome";v="120"',
            'Sec-Ch-Ua-Mobile' => '?0',
            'Sec-Ch-Ua-Platform' => '"Windows"',
            'Upgrade-Insecure-Requests' => '1',
        ])->withOptions([
            'allow_redirects' => true,
            'verify' => false,
        ])->get($videoUrl);

        if ($response->failed()) {
            return response()->json([
                'error' => 'Gagal ambil video',
                'status' => $response->status(),
                'body' => substr($response->body(), 0, 200)
            ]);
        }

        return response($response->body(), 200, [
            'Content-Type' => 'video/mp4',
            'Content-Disposition' => 'attachment; filename="tiktok_video.mp4"'
        ]);
    }
}
