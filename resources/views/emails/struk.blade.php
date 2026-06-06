<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Struk Pembelian J-Store</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f3f4f6; padding: 20px; }
        .container { max-w-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .header { background: #2563eb; color: #ffffff; padding: 20px; text-align: center; }
        .content { padding: 30px; color: #374151; }
        .info-table { w-full; border-collapse: collapse; margin-top: 20px; margin-bottom: 20px; width: 100%; }
        .info-table th, .info-table td { padding: 10px; border-bottom: 1px solid #e5e7eb; text-align: left; }
        .sn-box { background: #fef08a; border: 1px dashed #eab308; padding: 15px; text-align: center; border-radius: 8px; margin-top: 20px; }
        .sn-text { font-size: 18px; font-weight: bold; color: #854d0e; letter-spacing: 2px; margin: 0; }
        .footer { background: #f9fafb; padding: 15px; text-align: center; font-size: 12px; color: #6b7280; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 style="margin: 0;">Terima Kasih atas Pesanan Anda!</h2>
            <p style="margin: 5px 0 0 0; font-size: 14px;">Pesanan Anda di J-Store telah berhasil diproses.</p>
        </div>
        
        <div class="content">
            <p>Halo,</p>
            <p>Pembayaran Anda untuk produk digital berikut telah kami terima. Berikut adalah rincian pesanan Anda:</p>
            
            <table class="info-table">
                <tr>
                    <th style="width: 40%;">Order ID</th>
                    <td>TRX-{{ $transaksi->created_at->format('YmdHis') }}-{{ $transaksi->id_transaksi }}</td>
                </tr>
                <tr>
                    <th>Produk</th>
                    <td>{{ $transaksi->produk->nama_produk ?? 'Produk Digital' }}</td>
                </tr>
                <tr>
                    <th>ID Tujuan</th>
                    <td>{{ $transaksi->id_target }}</td>
                </tr>
                <tr>
                    <th>Total Bayar</th>
                    <td style="color: #16a34a; font-weight: bold;">Rp {{ number_format($transaksi->total_akhir, 0, ',', '.') }}</td>
                </tr>
            </table>

            <div class="sn-box">
                <p style="margin: 0 0 10px 0; font-size: 12px; color: #a16207; text-transform: uppercase;">KODE VOUCHER / SERIAL NUMBER (SN) / KREDENSIAL:</p>
                <p class="sn-text">{{ $sn_dummy }}</p>
            </div>

            <p style="margin-top: 30px; font-size: 14px;">Jika Anda memiliki pertanyaan terkait pesanan ini, silakan hubungi tim dukungan kami.</p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} J-Store Digital. All rights reserved.<br>
            Tugas Mata Kuliah Rekayasa Perangkat Lunak.
        </div>
    </div>
</body>
</html>