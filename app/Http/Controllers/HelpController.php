<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelpController extends Controller
{
    public function index()
    {
        $faqs = [
            [
                'question' => 'Bagaimana cara menggunakan simulasi rakit PC?',
                'answer' => 'Anda cukup menjelajahi halaman Rakit PC, masukkan budget yang diinginkan, dan sistem kami akan merekomendasikan kombinasi komponen terbaik yang kompatibel satu sama lain. Anda juga bisa memilih komponen secara manual sesuai preferensi brand atau spesifikasi tertentu.',
            ],
            [
                'question' => 'Apakah semua komponen yang dijual bergaransi resmi?',
                'answer' => 'Ya, semua produk yang kami jual dilengkapi dengan garansi resmi dari distributor atau manufacturer. Setiap produk memiliki informasi garansi yang jelas di halaman detail produk, mulai dari 1 tahun hingga lifetime warranty tergantung brand dan jenis komponen.',
            ],
            [
                'question' => 'Berapa lama estimasi waktu perakitan PC?',
                'answer' => 'Untuk rakitan PC yang dipesan melalui sistem kami, estimasi waktu perakitan adalah 2-3 hari kerja. Proses ini sudah termasuk assembly, instalasi OS, stress test, dan quality control untuk memastikan PC berfungsi optimal sebelum dikirim.',
            ],
            [
                'question' => 'Apakah pengiriman ke luar kota aman?',
                'answer' => 'Sangat aman! Kami menggunakan packaging khusus dengan bubble wrap berlapis dan box kardus tebal untuk melindungi komponen. Untuk rakitan lengkap, kami lepas VGA card dan cooler besar agar tidak merusak motherboard saat transit. Kami juga menggunakan jasa ekspedisi terpercaya dengan asuransi pengiriman.',
            ],
            [
                'question' => 'Bagaimana prosedur klaim garansi?',
                'answer' => 'Jika produk mengalami kerusakan dalam masa garansi, hubungi customer service kami dengan menyertakan nomor invoice dan bukti kerusakan (foto/video). Kami akan membantu koordinasi dengan distributor untuk proses klaim. Untuk komponen tertentu, kami menyediakan layanan unit replacement sementara produk Anda dalam perbaikan.',
            ],
            [
                'question' => 'Apakah tersedia metode cicilan?',
                'answer' => 'Ya, kami bekerja sama dengan berbagai platform cicilan seperti Kredivo, Akulaku, dan kartu kredit untuk tenor 3, 6, atau 12 bulan. Anda bisa memilih metode cicilan saat checkout. Syarat dan ketentuan mengikuti kebijakan masing-masing penyedia layanan.',
            ],
        ];

        return view('help.index', compact('faqs'));
    }
}
