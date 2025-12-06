<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>E-Receipt {{ $reservation->booking_code }}</title>
    <style>
        /* Mengatur halaman A4 tanpa margin bawaan agar kita bisa atur sendiri */
        @page {
            margin: 0;
            size: A4 portrait;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            margin: 0;
            padding: 30px; /* Jarak aman dari tepi kertas */
            background: #fff;
        }

        /* Garis Tepi Pembungkus Utama */
        .container {
            border: 1px solid #E0C3FC; /* Warna ungu muda */
            padding: 20px;
            border-radius: 12px;
            /* Tinggi fix agar border terlihat satu halaman penuh jika mau, 
               atau biarkan auto agar mengikuti konten */
            min-height: 950px; 
            position: relative;
        }

        /* Header */
        .header {
            text-align: center;
            border-bottom: 2px dashed #E0C3FC;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #8E44AD;
            font-size: 22px;
            text-transform: uppercase;
            margin: 0 0 5px 0;
        }
        .header p {
            margin: 2px 0;
            font-size: 11px;
            color: #777;
        }

        /* Banner Status */
        .status-banner {
            background-color: #F3E7FC;
            border: 1px solid #D1C4E9;
            color: #8E44AD;
            padding: 10px;
            text-align: center;
            border-radius: 6px;
            margin-bottom: 25px;
        }
        .booking-code {
            display: block;
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 2px;
            margin-bottom: 4px;
        }
        .status-text {
            font-size: 11px;
            text-transform: uppercase;
            background: #8E44AD;
            color: #fff;
            padding: 2px 8px;
            border-radius: 4px;
        }

        /* Judul Section */
        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #999;
            text-transform: uppercase;
            margin-bottom: 8px;
            border-bottom: 1px solid #eee;
            padding-bottom: 4px;
        }

        /* Tabel Rincian (Dibuat Compact) */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 13px;
        }
        td {
            padding: 5px 0;
            vertical-align: top;
        }
        .label {
            color: #666;
            width: 40%;
        }
        .value {
            color: #333;
            font-weight: bold;
            text-align: right;
        }

        /* Highlight Total */
        .total-row td {
            border-top: 1px dashed #ccc;
            padding-top: 10px;
            font-size: 15px;
            color: #8E44AD;
        }

        /* Footer & Timestamp */
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 11px;
            color: #888;
        }
        .timestamp {
            position: absolute;
            bottom: 10px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
            color: #ccc;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <h1>🎮 LOUNGE GAME ROOM</h1>
            <p>Jl. Perintis Kemerdekaan KM.10, Makassar</p>
            <p>Email: admin@lounge.com | Telp: 0812-3456-7890</p>
        </div>

        <div class="status-banner">
            <span class="booking-code">{{ $reservation->booking_code }}</span>
            <span class="status-text">{{ ucfirst($reservation->status) }}</span>
        </div>

        <div class="section-title">Informasi Customer</div>
        <table>
            <tr>
                <td class="label">Nama</td>
                <td class="value">{{ $reservation->user->name }}</td>
            </tr>
            <tr>
                <td class="label">Email</td>
                <td class="value">{{ $reservation->user->email }}</td>
            </tr>
            <tr>
                <td class="label">Telepon</td>
                <td class="value">{{ $reservation->user->phone ?? '-' }}</td>
            </tr>
        </table>

        <div class="section-title">Detail Reservasi</div>
        <table>
            <tr>
                <td class="label">Ruangan</td>
                <td class="value">{{ $reservation->gameRoom->name }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal</td>
                <td class="value">{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d F Y') }}</td>
            </tr>
            <tr>
                <td class="label">Jam</td>
                <td class="value">{{ substr($reservation->start_time, 0, 5) }} - {{ substr($reservation->end_time, 0, 5) }}</td>
            </tr>
            <tr>
                <td class="label">Durasi</td>
                <td class="value">{{ $reservation->duration_hours }} Jam</td>
            </tr>
        </table>

        <div class="section-title">Pembayaran</div>
        <table>
            <tr>
                <td class="label">Harga / Jam</td>
                <td class="value">Rp {{ number_format($reservation->gameRoom->price_per_hour, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td class="label"><strong>TOTAL BAYAR</strong></td>
                <td class="value"><strong>Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</strong></td>
            </tr>
        </table>

        <div class="footer">
            <p>"Terima kasih sudah bermain! Harap datang 10 menit sebelum jadwal."</p>
            <p>Simpan bukti ini sebagai tiket masuk yang sah.</p>
        </div>

        <div class="timestamp">
            Document generated on {{ now()->format('d M Y, H:i:s') }}
        </div>
    </div>

</body>
</html>