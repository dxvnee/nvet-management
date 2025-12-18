<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji - {{ $penggajian->user->name }} - {{ \Carbon\Carbon::parse($penggajian->periode)->format('F Y') }}</title>
    <style>
        :root {
            --primary: #855E41;
            --primary-2: #6C4A34;
            --text: #111827;
            --muted: #6b7280;
            --border: #e5e7eb;
            --bg: #f6f7fb;
            --card: #ffffff;
            --positive: #16a34a;
            --negative: #dc2626;
            --warning: #f59e0b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple Color Emoji", "Segoe UI Emoji";
            background: var(--bg);
            color: var(--text);
            font-size: 12px;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
            font-variant-numeric: tabular-nums;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background: var(--card);
            padding: 40px;
            border-radius: 16px;
            border: 1px solid rgba(17, 24, 39, 0.06);
            box-shadow: 0 10px 30px rgba(17, 24, 39, 0.08);
            position: relative;
            overflow: hidden;
        }

        .container::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, var(--primary), var(--primary-2));
        }

        @media print {
            body {
                background: white;
            }
            .container {
                margin: 0;
                padding: 20px;
                box-shadow: none;
                border: none;
                border-radius: 0;
            }
            .container::before {
                display: none;
            }
            .no-print {
                display: none !important;
            }
            @page {
                margin: 10mm;
            }

            /* Keep print output clean and readable even without background printing */
            .employee-section,
            .insentif-detail,
            .note-section {
                background: #fff !important;
            }
            .employee-section {
                border: 1px solid var(--border);
            }
            .total-section {
                background: #fff !important;
                color: var(--text) !important;
                border: 2px solid var(--primary);
            }
            .total-section .breakdown {
                opacity: 1;
                color: var(--muted);
            }
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid var(--border);
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .company-info h1 {
            font-size: 26px;
            color: var(--primary);
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .company-info p {
            color: var(--muted);
            font-size: 11px;
        }

        .slip-info {
            text-align: right;
        }

        .slip-info h2 {
            font-size: 18px;
            color: var(--text);
            font-weight: 600;
            letter-spacing: 0.06em;
        }

        .slip-info p {
            color: var(--muted);
            font-size: 12px;
        }

        .employee-section {
            display: flex;
            gap: 40px;
            background: #f8fafc;
            border: 1px solid var(--border);
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
        }

        .employee-photo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(133, 94, 65, 0.25);
        }

        .employee-details {
            flex: 1;
        }

        .employee-details h3 {
            font-size: 18px;
            color: var(--primary);
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
            color: var(--muted);
        }

        .badge {
            display: inline-block;
            padding: 3px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            border: 1px solid rgba(17, 24, 39, 0.08);
            text-transform: uppercase;
            letter-spacing: 0.06em;
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
            color: var(--text);
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .salary-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }

        .salary-table td {
            padding: 10px 14px;
            border-bottom: 1px solid #f3f4f6;
        }

        .salary-table tr:nth-child(even) td {
            background: #fafafa;
        }

        .salary-table tr:last-child td {
            border-bottom: none;
        }

        .salary-table .label {
            color: #374151;
        }

        .salary-table .value {
            text-align: right;
            font-weight: 500;
        }

        .salary-table .positive {
            color: var(--positive);
        }

        .salary-table .negative {
            color: var(--negative);
        }

        .salary-table .sub-label {
            padding-left: 30px;
            font-size: 11px;
            color: var(--muted);
        }

        .insentif-detail {
            background: #f9fafb;
            border: 1px solid var(--border);
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
            background: linear-gradient(135deg, var(--primary), var(--primary-2));
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
            border-top: 1px solid #111827;
            margin-top: 60px;
            padding-top: 8px;
        }

        .print-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: var(--primary);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(133, 94, 65, 0.4);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .print-button:hover {
            background: #553820;
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
                <h1>NVet Clinic</h1>
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
                        @if(isset($detail['lain_lain_items']) && is_array($detail['lain_lain_items']))
                            @foreach($detail['lain_lain_items'] as $item)
                                <tr>
                                    <td>{{ $item['nama'] ?? 'Item' }}</td>
                                    <td style="text-align: right;">{{ $item['qty'] ?? 0 }} × Rp {{ number_format($item['harga'] ?? 0, 0, ',', '.') }} = Rp {{ number_format(($item['qty'] ?? 0) * ($item['harga'] ?? 0), 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        @endif
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
                        @if(isset($detail['lain_lain_items']) && is_array($detail['lain_lain_items']))
                            @foreach($detail['lain_lain_items'] as $item)
                                <tr>
                                    <td>{{ $item['nama'] ?? 'Item' }}</td>
                                    <td style="text-align: right;">{{ $item['qty'] ?? 0 }} × Rp {{ number_format($item['harga'] ?? 0, 0, ',', '.') }} = Rp {{ number_format(($item['qty'] ?? 0) * ($item['harga'] ?? 0), 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        @endif
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
                        @if(isset($detail['lain_lain_items']) && is_array($detail['lain_lain_items']))
                            @foreach($detail['lain_lain_items'] as $item)
                                <tr>
                                    <td>{{ $item['nama'] ?? 'Item' }}</td>
                                    <td style="text-align: right;">{{ $item['qty'] ?? 0 }} × Rp {{ number_format($item['harga'] ?? 0, 0, ',', '.') }} = Rp {{ number_format(($item['qty'] ?? 0) * ($item['harga'] ?? 0), 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </table>
                @elseif($jabatan === 'Tech')
                    <table>
                        <tr>
                            <td>Antar Konten</td>
                            <td style="text-align: right;">{{ $detail['antar_konten_qty'] ?? 0 }} × Rp {{ number_format($detail['antar_konten_harga'] ?? 0, 0, ',', '.') }} = Rp {{ number_format(($detail['antar_konten_qty'] ?? 0) * ($detail['antar_konten_harga'] ?? 0), 0, ',', '.') }}</td>
                        </tr>
                        @if(isset($detail['lain_lain_items']) && is_array($detail['lain_lain_items']))
                            @foreach($detail['lain_lain_items'] as $item)
                                <tr>
                                    <td>{{ $item['nama'] ?? 'Item' }}</td>
                                    <td style="text-align: right;">{{ $item['qty'] ?? 0 }} × Rp {{ number_format($item['harga'] ?? 0, 0, ',', '.') }} = Rp {{ number_format(($item['qty'] ?? 0) * ($item['harga'] ?? 0), 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        @endif
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

        <!-- Lembur -->
        @if($penggajian->total_menit_lembur ?? 0 > 0)
        <div class="salary-section">
            <h4>
                <span style="color: #8b5cf6;">●</span> Lembur
            </h4>
            <table class="salary-table">
                <tr>
                    <td class="label">Total Menit Lembur</td>
                    <td class="value">{{ $penggajian->total_menit_lembur ?? 0 }} menit</td>
                </tr>
                <tr>
                    <td class="sub-label">{{ floor(($penggajian->total_menit_lembur ?? 0) / 60) }} jam {{ ($penggajian->total_menit_lembur ?? 0) % 60 }} menit</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="label">Upah Lembur per Menit</td>
                    <td class="value">Rp {{ number_format($penggajian->upah_lembur_per_menit ?? 0, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="label"><strong>Total Upah Lembur</strong></td>
                    <td class="value positive"><strong>+ Rp {{ number_format($penggajian->total_upah_lembur ?? 0, 0, ',', '.') }}</strong></td>
                </tr>
            </table>
        </div>
        @endif

        <!-- Lain-lain -->
        @php
            $lainLainItems = $penggajian->lain_lain_items ?? [];
        @endphp
        @if(count($lainLainItems) > 0)
        <div class="salary-section">
            <h4>
                <span style="color: #f59e0b;">●</span> Lain-lain
            </h4>
            <table class="salary-table">
                @foreach($lainLainItems as $item)
                    @if(isset($item['nama']) && $item['nilai'] != 0)
                    <tr>
                        <td class="label">{{ $item['nama'] }}</td>
                        <td class="value {{ $item['nilai'] >= 0 ? 'positive' : 'negative' }}">
                            {{ $item['nilai'] >= 0 ? '+ ' : '' }}Rp {{ number_format($item['nilai'], 0, ',', '.') }}
                        </td>
                    </tr>
                    @endif
                @endforeach
                <tr>
                    <td class="label"><strong>Total Lain-lain</strong></td>
                    <td class="value {{ $penggajian->lain_lain >= 0 ? 'positive' : 'negative' }}">
                        <strong>{{ $penggajian->lain_lain >= 0 ? '+ ' : '' }}Rp {{ number_format($penggajian->lain_lain, 0, ',', '.') }}</strong>
                    </td>
                </tr>
            </table>
        </div>
        @endif

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
                        @if($penggajian->total_upah_lembur ?? 0 > 0)
                        + Lembur (Rp {{ number_format($penggajian->total_upah_lembur ?? 0, 0, ',', '.') }})
                        @endif
                        {{ $penggajian->lain_lain >= 0 ? '+' : '' }} Lain-lain (Rp {{ number_format($penggajian->lain_lain, 0, ',', '.') }})
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
