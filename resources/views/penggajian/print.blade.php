<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji - {{ $penggajian->user->name }} - {{ \Carbon\Carbon::parse($penggajian->periode)->format('F Y') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            color: #333;
            font-size: 12px;
            line-height: 1.5;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background: white;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        @media print {
            body {
                background: white;
            }
            .container {
                margin: 0;
                padding: 20px;
                box-shadow: none;
            }
            .no-print {
                display: none !important;
            }
            @page {
                margin: 10mm;
            }
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid #e5e7eb;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .company-info h1 {
            font-size: 28px;
            color: #774900;
            font-weight: 700;
        }

        .company-info p {
            color: #666;
            font-size: 11px;
        }

        .slip-info {
            text-align: right;
        }

        .slip-info h2 {
            font-size: 18px;
            color: #333;
            font-weight: 600;
        }

        .slip-info p {
            color: #666;
            font-size: 12px;
        }

        .employee-section {
            display: flex;
            gap: 40px;
            background: linear-gradient(135deg, #f0fdfa, #e0f2fe);
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
        }

        .employee-photo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #0D9488;
        }

        .employee-details {
            flex: 1;
        }

        .employee-details h3 {
            font-size: 18px;
            color: #0D9488;
            margin-bottom: 5px;
        }

        .employee-details table {
            width: 100%;
        }

        .employee-details td {
            padding: 3px 0;
            vertical-align: top;
        }

        .employee-details td:first-child {
            width: 120px;
            color: #666;
        }

        .badge {
            display: inline-block;
            padding: 3px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-dokter { background: #f3e8ff; color: #7c3aed; }
        .badge-paramedis { background: #dbeafe; color: #2563eb; }
        .badge-tech { background: #dcfce7; color: #16a34a; }
        .badge-fo { background: #ffedd5; color: #ea580c; }

        .salary-section {
            margin-bottom: 25px;
        }

        .salary-section h4 {
            font-size: 14px;
            color: #0D9488;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e5e7eb;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .salary-table {
            width: 100%;
            border-collapse: collapse;
        }

        .salary-table td {
            padding: 10px 15px;
            border-bottom: 1px solid #f3f4f6;
        }

        .salary-table tr:last-child td {
            border-bottom: none;
        }

        .salary-table .label {
            color: #555;
        }

        .salary-table .value {
            text-align: right;
            font-weight: 500;
        }

        .salary-table .positive {
            color: #16a34a;
        }

        .salary-table .negative {
            color: #dc2626;
        }

        .salary-table .sub-label {
            padding-left: 30px;
            font-size: 11px;
            color: #888;
        }

        .insentif-detail {
            background: #f9fafb;
            border-radius: 8px;
            padding: 15px;
            margin: 10px 0;
        }

        .insentif-detail table {
            width: 100%;
        }

        .insentif-detail td {
            padding: 5px 0;
            font-size: 11px;
        }

        .total-section {
            background: linear-gradient(135deg, #0D9488, #0891b2);
            color: white;
            padding: 25px;
            border-radius: 12px;
            margin-top: 30px;
        }

        .total-section table {
            width: 100%;
        }

        .total-section td {
            padding: 5px 0;
        }

        .total-section .total-label {
            font-size: 16px;
        }

        .total-section .total-value {
            text-align: right;
            font-size: 28px;
            font-weight: 700;
        }

        .total-section .breakdown {
            font-size: 11px;
            opacity: 0.9;
        }

        .footer {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            text-align: center;
            width: 200px;
        }

        .signature-line {
            border-top: 1px solid #333;
            margin-top: 60px;
            padding-top: 8px;
        }

        .print-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #0D9488;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(13, 148, 136, 0.4);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .print-button:hover {
            background: #0f766e;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-final {
            background: #dcfce7;
            color: #16a34a;
        }

        .status-draft {
            background: #fef3c7;
            color: #d97706;
        }

        .note-section {
            background: #fffbeb;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin-top: 20px;
            border-radius: 0 8px 8px 0;
        }

        .note-section h5 {
            color: #92400e;
            margin-bottom: 5px;
            font-size: 12px;
        }

        .note-section p {
            color: #78350f;
            font-size: 11px;
        }
    </style>
</head>
<body>
    @php
        $detail = $penggajian->insentif_detail ?? [];
        $jabatan = $penggajian->user->jabatan;
    @endphp

    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="company-info">
                <h1>🐾 NVet Clinic</h1>
                <p>Jl. Contoh No. 123, Kota XYZ</p>
                <p>Telp: (021) 123-4567 | Email: info@nvet.id</p>
            </div>
            <div class="slip-info">
                <h2>SLIP GAJI</h2>
                <p>Periode: {{ \Carbon\Carbon::parse($penggajian->periode)->format('F Y') }}</p>
                <p>ID: #{{ str_pad($penggajian->id, 6, '0', STR_PAD_LEFT) }}</p>
                <span class="status-badge {{ $penggajian->status === 'final' ? 'status-final' : 'status-draft' }}">
                    {{ $penggajian->status }}
                </span>
            </div>
        </div>

        <!-- Employee Info -->
        <div class="employee-section">
            <img src="{{ $penggajian->user->avatar ? asset('storage/' . $penggajian->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($penggajian->user->name) . '&color=7F9CF5&background=EBF4FF&size=80' }}"
                alt="{{ $penggajian->user->name }}"
                class="employee-photo">
            <div class="employee-details">
                <h3>{{ $penggajian->user->name }}</h3>
                <table>
                    <tr>
                        <td>Jabatan</td>
                        <td>
                            <span class="badge badge-{{ strtolower($jabatan) }}">{{ $jabatan }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>{{ $penggajian->user->email }}</td>
                    </tr>
                    <tr>
                        <td>Jam Kerja</td>
                        <td>{{ $penggajian->user->jam_kerja ?? '-' }} jam/minggu</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Gaji Pokok -->
        <div class="salary-section">
            <h4>
                <span style="color: #0D9488;">●</span> Gaji Pokok
            </h4>
            <table class="salary-table">
                <tr>
                    <td class="label">Gaji Pokok</td>
                    <td class="value positive">Rp {{ number_format($penggajian->gaji_pokok, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <!-- Potongan -->
        <div class="salary-section">
            <h4>
                <span style="color: #dc2626;">●</span> Potongan
            </h4>
            <table class="salary-table">
                <tr>
                    <td class="label">Potongan Keterlambatan</td>
                    <td class="value negative">- Rp {{ number_format($penggajian->total_potongan_telat, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="sub-label">{{ $penggajian->total_menit_telat }} menit × Rp {{ number_format($penggajian->potongan_per_menit, 0, ',', '.') }}/menit</td>
                    <td></td>
                </tr>
            </table>
        </div>

        <!-- Insentif -->
        <div class="salary-section">
            <h4>
                <span style="color: #16a34a;">●</span> Insentif ({{ $jabatan }})
            </h4>

            <div class="insentif-detail">
                @if($jabatan === 'Dokter')
                    <table>
                        <tr>
                            <td>Total Transaksi</td>
                            <td style="text-align: right;">Rp {{ number_format($detail['transaksi'] ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Persentase Insentif</td>
                            <td style="text-align: right;">{{ $detail['persenan'] ?? 0 }}%</td>
                        </tr>
                        <tr>
                            <td>Pengurangan</td>
                            <td style="text-align: right;">- Rp {{ number_format($detail['pengurangan'] ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        @if(!empty($detail['keterangan_pengurangan']))
                            <tr><td colspan="2" style="color: #888; font-style: italic;">{{ $detail['keterangan_pengurangan'] }}</td></tr>
                        @endif
                        <tr>
                            <td>Penambahan</td>
                            <td style="text-align: right;">+ Rp {{ number_format($detail['penambahan'] ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        @if(!empty($detail['keterangan_penambahan']))
                            <tr><td colspan="2" style="color: #888; font-style: italic;">{{ $detail['keterangan_penambahan'] }}</td></tr>
                        @endif
                        <tr>
                            <td>Lain-lain Insentif</td>
                            <td style="text-align: right;">+ Rp {{ number_format($detail['lain_lain_insentif'] ?? 0, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                @elseif($jabatan === 'Paramedis')
                    <table>
                        <tr>
                            <td>Antar Jemput</td>
                            <td style="text-align: right;">{{ $detail['antar_jemput_qty'] ?? 0 }} × Rp {{ number_format($detail['antar_jemput_harga'] ?? 0, 0, ',', '.') }} = Rp {{ number_format(($detail['antar_jemput_qty'] ?? 0) * ($detail['antar_jemput_harga'] ?? 0), 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Rawat Inap</td>
                            <td style="text-align: right;">{{ $detail['rawat_inap_qty'] ?? 0 }} × Rp {{ number_format($detail['rawat_inap_harga'] ?? 0, 0, ',', '.') }} = Rp {{ number_format(($detail['rawat_inap_qty'] ?? 0) * ($detail['rawat_inap_harga'] ?? 0), 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Visit</td>
                            <td style="text-align: right;">{{ $detail['visit_qty'] ?? 0 }} × Rp {{ number_format($detail['visit_harga'] ?? 0, 0, ',', '.') }} = Rp {{ number_format(($detail['visit_qty'] ?? 0) * ($detail['visit_harga'] ?? 0), 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Grooming</td>
                            <td style="text-align: right;">{{ $detail['grooming_qty'] ?? 0 }} × Rp {{ number_format($detail['grooming_harga'] ?? 0, 0, ',', '.') }} = Rp {{ number_format(($detail['grooming_qty'] ?? 0) * ($detail['grooming_harga'] ?? 0), 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Lain-lain Insentif</td>
                            <td style="text-align: right;">+ Rp {{ number_format($detail['lain_lain_insentif'] ?? 0, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                @elseif($jabatan === 'FO')
                    <table>
                        <tr>
                            <td>Review</td>
                            <td style="text-align: right;">{{ $detail['review_qty'] ?? 0 }} × Rp {{ number_format($detail['review_harga'] ?? 0, 0, ',', '.') }} = Rp {{ number_format(($detail['review_qty'] ?? 0) * ($detail['review_harga'] ?? 0), 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Appointment</td>
                            <td style="text-align: right;">{{ $detail['appointment_qty'] ?? 0 }} × Rp {{ number_format($detail['appointment_harga'] ?? 0, 0, ',', '.') }} = Rp {{ number_format(($detail['appointment_qty'] ?? 0) * ($detail['appointment_harga'] ?? 0), 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Lain-lain Insentif</td>
                            <td style="text-align: right;">+ Rp {{ number_format($detail['lain_lain_insentif'] ?? 0, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                @elseif($jabatan === 'Tech')
                    <table>
                        <tr>
                            <td>Antar Konten</td>
                            <td style="text-align: right;">{{ $detail['antar_konten_qty'] ?? 0 }} × Rp {{ number_format($detail['antar_konten_harga'] ?? 0, 0, ',', '.') }} = Rp {{ number_format(($detail['antar_konten_qty'] ?? 0) * ($detail['antar_konten_harga'] ?? 0), 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Lain-lain Insentif</td>
                            <td style="text-align: right;">+ Rp {{ number_format($detail['lain_lain_insentif'] ?? 0, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                @endif
            </div>

            <table class="salary-table">
                <tr>
                    <td class="label"><strong>Total Insentif</strong></td>
                    <td class="value positive"><strong>+ Rp {{ number_format($penggajian->total_insentif, 0, ',', '.') }}</strong></td>
                </tr>
            </table>
        </div>

        <!-- Reimburse & Lain-lain -->
        <div class="salary-section">
            <h4>
                <span style="color: #f59e0b;">●</span> Lain-lain
            </h4>
            <table class="salary-table">
                @if($penggajian->reimburse > 0)
                <tr>
                    <td class="label">Reimburse</td>
                    <td class="value negative">- Rp {{ number_format($penggajian->reimburse, 0, ',', '.') }}</td>
                </tr>
                @if($penggajian->keterangan_reimburse)
                <tr>
                    <td class="sub-label">{{ $penggajian->keterangan_reimburse }}</td>
                    <td></td>
                </tr>
                @endif
                @endif

                @if($penggajian->lain_lain != 0)
                <tr>
                    <td class="label">Lain-lain</td>
                    <td class="value {{ $penggajian->lain_lain >= 0 ? 'positive' : 'negative' }}">
                        {{ $penggajian->lain_lain >= 0 ? '+ ' : '- ' }}Rp {{ number_format(abs($penggajian->lain_lain), 0, ',', '.') }}
                    </td>
                </tr>
                @if($penggajian->keterangan_lain)
                <tr>
                    <td class="sub-label">{{ $penggajian->keterangan_lain }}</td>
                    <td></td>
                </tr>
                @endif
                @endif
            </table>
        </div>

        <!-- Total -->
        <div class="total-section">
            <table>
                <tr>
                    <td class="total-label">TOTAL GAJI DITERIMA</td>
                    <td class="total-value">Rp {{ number_format($penggajian->total_gaji, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="breakdown">
                        Gaji Pokok (Rp {{ number_format($penggajian->gaji_pokok, 0, ',', '.') }})
                        - Potongan (Rp {{ number_format($penggajian->total_potongan_telat, 0, ',', '.') }})
                        + Insentif (Rp {{ number_format($penggajian->total_insentif, 0, ',', '.') }})
                        - Reimburse (Rp {{ number_format($penggajian->reimburse, 0, ',', '.') }})
                        {{ $penggajian->lain_lain >= 0 ? '+' : '-' }} Lain-lain (Rp {{ number_format(abs($penggajian->lain_lain), 0, ',', '.') }})
                    </td>
                </tr>
            </table>
        </div>

        <!-- Note -->
        @if($penggajian->catatan)
        <div class="note-section">
            <h5>Catatan:</h5>
            <p>{{ $penggajian->catatan }}</p>
        </div>
        @endif

        <!-- Footer Signatures -->
        <div class="footer">
            <div class="signature-box">
                <p>Penerima,</p>
                <div class="signature-line">
                    {{ $penggajian->user->name }}
                </div>
            </div>
            <div class="signature-box">
                <p>Dikeluarkan oleh,</p>
                <div class="signature-line">
                    Admin NVet Clinic
                </div>
            </div>
        </div>

        <p style="text-align: center; color: #888; font-size: 10px; margin-top: 30px;">
            Dokumen ini dicetak pada {{ now()->format('d F Y H:i') }}
        </p>
    </div>

    <!-- Print Button -->
    <button class="print-button no-print" onclick="window.print()">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="6,9 6,2 18,2 18,9"></polyline>
            <path d="M6,18 L4,18 C2.9,18 2,17.1 2,16 L2,11 C2,9.9 2.9,9 4,9 L20,9 C21.1,9 22,9.9 22,11 L22,16 C22,17.1 21.1,18 20,18 L18,18"></path>
            <rect x="6" y="14" width="12" height="8"></rect>
        </svg>
        Cetak Slip Gaji
    </button>
</body>
</html>
