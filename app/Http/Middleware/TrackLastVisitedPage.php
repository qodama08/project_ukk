<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackLastVisitedPage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Daftar halaman yang ingin di-track
        $protectedPages = [
            'siswa',
            'guru_bk',
            'pelanggaran',
            'jadwal_konseling',
            'catatan_konseling',
            'prestasi',
            'kelas',
            'jurusan',
            'roles',
            'bk-ai',
            'users',
            'notifikasi',
            'myprofile',
            'dashboard'
        ];

        // Cek apakah current path dimulai dengan salah satu protected page
        $currentPath = $request->path();
        
        // Jangan track jika path kosong (root /), dan user harus sudah login
        if ($currentPath !== '' && $currentPath !== '/' && auth()->check()) {
            foreach ($protectedPages as $page) {
                if (str_starts_with($currentPath, $page)) {
                    // Simpan full URL ke cookie (termasuk query string jika ada)
                    $fullPath = '/' . $currentPath;
                    if ($request->getQueryString()) {
                        $fullPath .= '?' . $request->getQueryString();
                    }
                    // Set cookie untuk menyimpan halaman terakhir (30 hari)
                    cookie()->queue('last_visited_page', $fullPath, 60 * 24 * 30);
                    break;
                }
            }
        }

        return $next($request);
    }
}
