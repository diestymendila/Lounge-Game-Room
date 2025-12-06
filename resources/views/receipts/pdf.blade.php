<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran - {{ $reservation->booking_code }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @page {
            margin: 0;
            size: A4 portrait;
        }

        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            font-size: 11pt;
            line-height: 1.5;
            color: #2c3e50;
            background: #ffffff;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 20mm;
            margin: 0 auto;
            background: white;
            position: relative;
        }

        /* Header */
        .header {
            text-align: center;
            padding: 25px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            margin-bottom: 25px;
            color: white;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .header .logo {
            font-size: 32pt;
            font-weight: bold;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .header .company-name {
            font-size: 28pt;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .header .tagline {
            font-size: 10pt;
            opacity: 0.9;
            font-style: italic;
            margin-bottom: 10px;
        }

        .header .divider {
            width: 80%;
            height: 2px;
            background: rgba(255,255,255,0.3);
            margin: 10px auto;
        }

        .header .contact {
            font-size: 9pt;
            line-height: 1.6;
            opacity: 0.95;
        }

        /* Booking Code Section */
        .booking-section {
            text-align: center;
            padding: 20px;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0 3px 5px rgba(0,0,0,0.1);
        }

        .booking-code {
            font-size: 26pt;
            font-weight: bold;
            color: white;
            letter-spacing: 3px;
            margin-bottom: 10px;
        }

        .status-row {
            margin-top: 10px;
        }

        .badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 25px;
            font-size: 10pt;
            font-weight: bold;
            margin: 0 5px;
            color: white;
        }

        .badge-pending { background: #f39c12; }
        .badge-confirmed { background: #3498db; }
        .badge-completed { background: #27ae60; }
        .badge-cancelled { background: #e74c3c; }
        .badge-paid { background: #27ae60; }
        .badge-unpaid { background: #e74c3c; }

        /* Section */
        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 13pt;
            font-weight: bold;
            color: #2c3e50;
            padding: 10px 15px;
            background: linear-gradient(90deg, #D0D5EA 0%, #B8DAED 100%);
            border-left: 5px solid #667eea;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        /* Info Table */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .info-table tr {
            border-bottom: 1px solid #ecf0f1;
        }

        .info-table td {
            padding: 12px 15px;
            font-size: 11pt;
        }

        .info-table td:first-child {
            width: 40%;
            color: #7f8c8d;
            font-weight: 600;
        }

        .info-table td:last-child {
            color: #2c3e50;
            font-weight: 500;
        }

        .info-table tr:last-child {
            border-bottom: none;
        }

        /* Payment Summary Box */
        .payment-summary {
            background: linear-gradient(135deg, #ffeaa7 0%, #fdcb6e 100%);
            padding: 20px;
            border-radius: 12px;
            border: 3px dashed #e17055;
            margin: 25px 0;
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        }

        .payment-summary .title {
            font-size: 13pt;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 15px;
            text-align: center;
        }

        .payment-row {
            display: table;
            width: 100%;
            margin-bottom: 10px;
            font-size: 11pt;
        }

        .payment-row .label {
            display: table-cell;
            width: 70%;
            color: #2c3e50;
            font-weight: 500;
        }

        .payment-row .value {
            display: table-cell;
            text-align: right;
            color: #2c3e50;
            font-weight: 600;
        }

        .payment-total {
            border-top: 3px solid #e17055;
            padding-top: 15px;
            margin-top: 15px;
        }

        .payment-total .label {
            font-size: 13pt;
            font-weight: bold;
        }

        .payment-total .value {
            font-size: 20pt;
            font-weight: bold;
            color: #d63031;
        }

        /* Grid Layout */
        .grid-2 {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }

        .grid-col {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding: 0 10px;
        }

        .grid-col:first-child {
            padding-left: 0;
        }

        .grid-col:last-child {
            padding-right: 0;
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 40px;
            padding: 25px 20px;
            background: linear-gradient(135deg, #B8DAED 0%, #BCC6E0 100%);
            border-radius: 12px;
            page-break-inside: avoid;
        }

        .footer .main-text {
            font-size: 12pt;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 8px;
        }

        .footer .sub-text {
            font-size: 9pt;
            color: #555;
            line-height: 1.6;
        }

        /* Print Info */
        .print-info {
            text-align: center;
            font-size: 8pt;
            color: #95a5a6;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #ecf0f1;
        }

        /* Highlight */
        .highlight {
            background: #fff3cd;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: bold;
        }

        /* Divider */
        .divider {
            height: 3px;
            background: linear-gradient(90deg, transparent, #667eea, transparent);
            margin: 25px 0;
        }

        /* Strong Emphasis */
        strong {
            font-weight: 700;
            color: #2c3e50;
        }
    </style>
</head>
<body>
    <div class="page">
        <!-- Header -->
        <div class="header">
            <div class="logo">🎮</div>
            <div class="company-name">LOUNGE GAME ROOM</div>
            <div class="tagline">Your Gaming Paradise</div>
            <div class="divider"></div>
            <div class="contact">
                Jl. Perintis Kemerdekaan KM.10, Makassar, Sulawesi Selatan<br>
                Telepon: (0411) 123456 | Email: info@loungegameroom.com<br>
                Website: www.loungegameroom.com
            </div>
        </div>

        <!-- Booking Code -->
        <div class="booking-section">
            <div class="booking-code">{{ $reservation->booking_code }}</div>
            <div class="status-row">
                <span class="badge badge-{{ $reservation->status }}">
                    {{ $reservation->status_label }}
                </span>
                <span class="badge badge-{{ $reservation->payment_status }}">
                    {{ $reservation->payment_status_label }}
                </span>
            </div>
        </div>

        <!-- Customer Info -->
        <div class="section">
            <div class="section-title">👤 INFORMASI CUSTOMER</div>
            <table class="info-table">
                <tr>
                    <td>Nama</td>
                    <td><strong>{{ $reservation->user->name }}</strong></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>{{ $reservation->user->email }}</td>
                </tr>
                <tr>
                    <td>Telepon</td>
                    <td>{{ $reservation->user->phone }}</td>
                </tr>
            </table>
        </div>

        <!-- Reservation Details -->
        <div class="section">
            <div class="section-title">📅 DETAIL RESERVASI</div>
            <table class="info-table">
                <tr>
                    <td>Ruangan</td>
                    <td><strong>{{ $reservation->gameRoom->name }}</strong></td>
                </tr>
                <tr>
                    <td>Kapasitas</td>
                    <td>{{ $reservation->gameRoom->capacity }} orang</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td><strong>{{ \Carbon\Carbon::parse($reservation->reservation_date)->isoFormat('dddd, D MMMM YYYY') }}</strong></td>
                </tr>
                <tr>
                    <td>Waktu</td>
                    <td><strong>{{ substr($reservation->start_time, 0, 5) }} - {{ substr($reservation->end_time, 0, 5) }} WITA</strong></td>
                </tr>
                <tr>
                    <td>Durasi</td>
                    <td><strong>{{ $reservation->duration_hours }} jam</strong></td>
                </tr>
                @if($reservation->notes)
                <tr>
                    <td>Catatan</td>
                    <td>{{ $reservation->notes }}</td>
                </tr>
                @endif
            </table>
        </div>

        <!-- Payment Info -->
        @if($reservation->payment)
        <div class="section">
            <div class="section-title">💳 INFORMASI PEMBAYARAN</div>
            <table class="info-table">
                <tr>
                    <td>Kode Pembayaran</td>
                    <td><strong>{{ $reservation->payment->payment_code }}</strong></td>
                </tr>
                <tr>
                    <td>Metode Pembayaran</td>
                    <td><span class="highlight">{{ $reservation->payment->payment_method_label }}</span></td>
                </tr>
                <tr>
                    <td>Status Pembayaran</td>
                    <td><strong style="color: #27ae60;">{{ $reservation->payment->status_label }}</strong></td>
                </tr>
                @if($reservation->payment->paid_at)
                <tr>
                    <td>Tanggal Pembayaran</td>
                    <td>{{ $reservation->payment->paid_at->isoFormat('dddd, D MMMM YYYY, HH:mm') }} WITA</td>
                </tr>
                @endif
            </table>
        </div>
        @endif

        <div class="divider"></div>

        <!-- Payment Summary -->
        <div class="payment-summary">
            <div class="title">💰 RINCIAN PEMBAYARAN</div>
            <div class="payment-row">
                <div class="label">Harga per Jam</div>
                <div class="value">{{ $reservation->gameRoom->formatted_price }}</div>
            </div>
            <div class="payment-row">
                <div class="label">Durasi</div>
                <div class="value">{{ $reservation->duration_hours }} jam</div>
            </div>
            <div class="payment-row payment-total">
                <div class="label">TOTAL PEMBAYARAN</div>
                <div class="value">{{ $reservation->formatted_total_price }}</div>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="section">
            <div class="section-title">ℹ️ INFORMASI TAMBAHAN</div>
            <table class="info-table">
                <tr>
                    <td>Tanggal Dibuat</td>
                    <td>{{ $reservation->created_at->isoFormat('D MMMM YYYY, HH:mm') }} WITA</td>
                </tr>
                <tr>
                    <td>Terakhir Diupdate</td>
                    <td>{{ $reservation->updated_at->isoFormat('D MMMM YYYY, HH:mm') }} WITA</td>
                </tr>
                <tr>
                    <td>Tanggal Cetak</td>
                    <td>{{ now()->isoFormat('D MMMM YYYY, HH:mm') }} WITA</td>
                </tr>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p class="main-text">✅ Terima kasih atas reservasi Anda!</p>
            <p class="sub-text">
                Simpan struk ini sebagai bukti pembayaran yang sah.<br>
                Tunjukkan kode booking saat check-in.<br>
                Untuk pertanyaan atau bantuan, silakan hubungi kami.
            </p>
        </div>

        <!-- Print Info -->
        <div class="print-info">
            Dokumen ini dicetak secara otomatis pada {{ now()->isoFormat('dddd, D MMMM YYYY, HH:mm:ss') }} WITA<br>
            Struk digital ini sah tanpa tanda tangan dan stempel<br>
            © {{ date('Y') }} Lounge Game Room - All Rights Reserved
        </div>
    </div>
</body>
</html>