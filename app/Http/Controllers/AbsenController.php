<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\HariLibur;
use App\Models\Lembur;
use App\Models\User;
use App\Services\PhotoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AbsenController extends Controller
{
    protected PhotoService $photoService;

    // Koordinat kantor (bisa dicustom)
    private $officeLatitude = -6.189035762950233;
    private $officeLongitude = 106.61662426529043;
    private $allowedRadius = 50; // meter

    public function __construct(PhotoService $photoService)
    {
        $this->photoService = $photoService;
    }

    public function index()
    {
        $officeLatitude = $this->officeLatitude;
        $officeLongitude = $this->officeLongitude;
        $allowedRadius = $this->allowedRadius;

        $today = Carbon::today();
        $user = Auth::user();

        // Check if user is inactive today
        if ($user->isInactiveOnDate($today)) {
            return view('absensi.absen', [
                'officeLatitude' => $officeLatitude,
                'officeLongitude' => $officeLongitude,
                'allowedRadius' => $allowedRadius,
                'sudahHadir' => null,
                'sudahIzin' => null,
                'sudahPulang' => null,
                'totalJamKerja' => 0,
                'totalJamKerjaText' => '0 jam 0 menit',
                'absenHariIni' => null,
                'liburOrNot' => false,
                'isInactive' => true,
                'inactiveReason' => $user->inactive_reason,
                'inactiveEndDate' => $user->inactive_permanent ? null : $user->inactive_end_date,
            ]);
        }

        // Ambil absen hari ini (single record per day)
        $absenHariIni = Absen::where('user_id', $user->id)
            ->whereDate('tanggal', $today)
            ->first();

        $hariLibur = $user->hari_libur;

        // Status berdasarkan model baru
        $sudahHadir = $absenHariIni && $absenHariIni->jam_masuk ? $absenHariIni : null;
        $sudahIzin = $absenHariIni && $absenHariIni->izin ? $absenHariIni : null;
        $sudahPulang = $absenHariIni && $absenHariIni->jam_pulang ? $absenHariIni : null;

        // Hitung total jam kerja hari ini
        $totalJamKerja = 0;
        $totalJamKerjaText = '0 jam 0 menit';
        if ($sudahHadir && !$sudahIzin) {
            $jamMasuk = $absenHariIni->jam_masuk;
            $jamKeluar = $absenHariIni->jam_pulang ?? Carbon::now();

            $totalMenit = $jamMasuk->diffInMinutes($jamKeluar, false);
            $jam = floor($totalMenit / 60);
            $menit = $totalMenit % 60;

            $totalJamKerja = $jam;
            $totalJamKerjaText = $jam . ' jam ' . $menit . ' menit';
        }

        $hariIni = $today->isoWeekday();
        $liburOrNot = false;
        $isPublicHoliday = HariLibur::isHoliday($today);
        $publicHolidayInfo = HariLibur::getHoliday($today);

        // Check if it's a special working day (hari khusus with is_masuk and not lembur)
        $isHariKhususKerjaBiasa = false;
        if ($publicHolidayInfo) {
            // Jika hari khusus dengan is_masuk = true dan is_lembur = false,
            // maka dianggap sebagai hari kerja biasa
            if (
                $publicHolidayInfo->tipe === 'hari_khusus' &&
                $publicHolidayInfo->is_masuk &&
                !$publicHolidayInfo->is_lembur
            ) {
                $isHariKhususKerjaBiasa = true;
            }
        }

        // Check personal holiday OR public holiday (but not hari khusus kerja biasa)
        if ((in_array($hariIni, $hariLibur) || $isPublicHoliday) && !$isHariKhususKerjaBiasa) {
            $liburOrNot = true;

            // Auto-create absen record with libur status
            if (!$absenHariIni) {
                $absenHariIni = Absen::create([
                    'user_id' => $user->id,
                    'tanggal' => $today,
                    'libur' => true,
                    'izin' => false,
                    'telat' => false,
                    'tidak_hadir' => false,
                ]);
            } elseif (!$absenHariIni->libur && !$absenHariIni->jam_masuk) {
                // Update existing record to mark as libur if not already marked and no jam_masuk
                $absenHariIni->update(['libur' => true]);
            }
        }

        // Jika hari khusus kerja biasa, pastikan record absen tidak ditandai libur
        if ($isHariKhususKerjaBiasa && $absenHariIni && $absenHariIni->libur && !$absenHariIni->jam_masuk) {
            $absenHariIni->update(['libur' => false]);
        }

        // Riwayat absen
        $riwayat = Absen::where('user_id', $user->id)
            ->orderBy('tanggal', 'desc')
            ->limit(20)
            ->get();

        // Get holiday name for display
        $namaHariLibur = $publicHolidayInfo ? $publicHolidayInfo->nama : null;

        // Get hari khusus info for view
        $hariKhususInfo = $isHariKhususKerjaBiasa ? $publicHolidayInfo : null;
        $isInactive = $user->isInactiveOnDate($today);

        return view('absensi.absen', compact(
            'absenHariIni',
            'sudahHadir',
            'sudahIzin',
            'sudahPulang',
            'riwayat',
            'liburOrNot',
            'namaHariLibur',
            'hariKhususInfo',
            'today',
            'isInactive',
            'officeLatitude',
            'officeLongitude',
            'allowedRadius',
            'totalJamKerja',
            'totalJamKerjaText'
        ));
    }

    public function riwayat(Request $request)
    {
        $user = Auth::user();

        // Default sorting
        $sortBy = $request->get('sort_by', 'tanggal');
        $sortDirection = $request->get('sort_direction', 'desc');

        // Validasi kolom yang bisa di-sort
        $allowedSortColumns = ['tanggal', 'jam_masuk', 'jam_pulang', 'menit_kerja', 'izin', 'telat'];
        if (!in_array($sortBy, $allowedSortColumns)) {
            $sortBy = 'tanggal';
        }

        // Validasi arah sorting
        if (!in_array($sortDirection, ['asc', 'desc'])) {
            $sortDirection = 'desc';
        }

        $query = Absen::where('user_id', $user->id);

        // Sorting berdasarkan kolom
        if ($sortBy === 'tanggal') {
            $query->orderBy('tanggal', $sortDirection);
        } elseif ($sortBy === 'jam_masuk') {
            $query->orderBy('jam_masuk', $sortDirection);
        } elseif ($sortBy === 'jam_pulang') {
            $query->orderBy('jam_pulang', $sortDirection);
        } elseif ($sortBy === 'menit_kerja') {
            $query->orderBy('menit_kerja', $sortDirection);
        } elseif ($sortBy === 'izin') {
            $query->orderBy('izin', $sortDirection);
        } elseif ($sortBy === 'telat') {
            $query->orderBy('telat', $sortDirection);
        }

        // Secondary sort by tanggal desc untuk konsistensi
        if ($sortBy !== 'tanggal') {
            $query->orderBy('tanggal', 'desc');
        }

        $riwayat = $query->paginate(10)->appends(request()->query());

        return view('absensi.riwayat', compact(
            'riwayat',
            'sortBy',
            'sortDirection'
        ));
    }

    public function riwayatKalender(Request $request)
    {
        $user = Auth::user();
        $bulan = $request->get('bulan', Carbon::now()->month);
        $tahun = $request->get('tahun', Carbon::now()->year);

        // Ambil semua absensi user dalam bulan tersebut
        $startDate = Carbon::create($tahun, $bulan, 1)->startOfMonth();
        $endDate = Carbon::create($tahun, $bulan, 1)->endOfMonth();

        // Get public holidays for this month
        $publicHolidays = HariLibur::where(function ($query) use ($startDate, $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]);
        })->orWhere(function ($query) use ($startDate, $endDate) {
            $query->where('is_recurring', true)
                ->whereMonth('tanggal', $startDate->month);
        })->get()->keyBy(function ($item) {
            return $item->tanggal->format('m-d');
        });

        // Ambil absensi user saja
        $absensiBulan = Absen::where('user_id', $user->id)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal')
            ->get()
            ->keyBy(function ($item) {
                return $item->tanggal->format('Y-m-d');
            });

        // Hitung statistik per hari
        $kalenderData = [];
        $hariLiburUser = $user->hari_libur ?? [];

        // Summary statistics
        $totalHadir = 0;
        $totalTelat = 0;
        $totalIzin = 0;
        $totalLibur = 0;
        $totalMenitKerja = 0;

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $tanggal = $date->format('Y-m-d');
            $monthDay = $date->format('m-d');
            $absenHari = $absensiBulan->get($tanggal);

            // Check if this day is a public holiday
            $publicHoliday = $publicHolidays->get($monthDay);

            // Check if this is user's personal holiday
            $isPersonalHoliday = in_array($date->isoWeekday(), $hariLiburUser);

            $status = null;
            $statusColor = 'gray';
            $statusIcon = '';

            if ($absenHari) {
                if ($absenHari->libur) {
                    $status = 'libur';
                    $statusColor = 'blue';
                    $statusIcon = '🌴';
                    $totalLibur++;
                } elseif ($absenHari->izin) {
                    $status = 'izin';
                    $statusColor = 'amber';
                    $statusIcon = '📝';
                    $totalIzin++;
                } elseif ($absenHari->tidak_hadir) {
                    $status = 'tidak_hadir';
                    $statusColor = 'gray';
                    $statusIcon = '✗';
                } elseif ($absenHari->telat) {
                    $status = 'telat';
                    $statusColor = 'red';
                    $statusIcon = '⚠';
                    $totalTelat++;
                    $totalHadir++;
                    $totalMenitKerja += $absenHari->menit_kerja ?? 0;
                } elseif ($absenHari->jam_masuk) {
                    $status = 'hadir';
                    $statusColor = 'green';
                    $statusIcon = '✓';
                    $totalHadir++;
                    $totalMenitKerja += $absenHari->menit_kerja ?? 0;
                }
            }

            $kalenderData[$tanggal] = [
                'tanggal' => $date->copy(),
                'absen' => $absenHari,
                'status' => $status,
                'status_color' => $statusColor,
                'status_icon' => $statusIcon,
                'public_holiday' => $publicHoliday,
                'is_personal_holiday' => $isPersonalHoliday,
            ];
        }

        // Calculate total working hours
        $totalJam = floor($totalMenitKerja / 60);
        $sisaMenit = $totalMenitKerja % 60;

        return view('absensi.riwayat-kalender', compact(
            'kalenderData',
            'bulan',
            'tahun',
            'totalHadir',
            'totalTelat',
            'totalIzin',
            'totalLibur',
            'totalJam',
            'sisaMenit'
        ));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today();
        $now = Carbon::now();

        // Check if user is inactive today
        if ($user->isInactiveOnDate($today)) {
            return back()->with('error', 'Anda tidak dapat melakukan absen karena status Anda sedang inactive.');
        }

        // Validate photo is required
        $request->validate([
            'foto' => 'required|string',
        ], [
            'foto.required' => 'Foto wajib diambil untuk absensi.',
        ]);

        // Ambil / buat data absen hari ini
        $absen = Absen::firstOrCreate(
            [
                'user_id' => $user->id,
                'tanggal' => $today,
            ],
            [
                'izin' => false,
                'telat' => false,
            ]
        );

        /* ===============================
     * VALIDASI LOKASI
     * =============================== */
        $distance = $this->calculateDistance(
            $request->latitude,
            $request->longitude,
            $this->officeLatitude,
            $this->officeLongitude
        );

        // Check if outside location
        $isOutsideLocation = $distance > $this->allowedRadius;
        $hasDiluarLokasiAlasan = $request->filled('diluar_lokasi_alasan');

        // Allow absen from outside if reason is provided
        if ($isOutsideLocation && !$hasDiluarLokasiAlasan) {
            return back()->with(
                'error',
                'Anda berada di luar radius kantor. Jarak Anda: ' . round($distance, 2) . ' meter. Silakan masukkan alasan jika ingin absen dari luar lokasi.'
            );
        }

        // Check for hari khusus kerja biasa (special working day with custom hours)
        $hariKhusus = HariLibur::getHoliday($today);
        $isHariKhususKerjaBiasa = $hariKhusus &&
            $hariKhusus->tipe === 'hari_khusus' &&
            $hariKhusus->is_masuk &&
            !$hariKhusus->is_lembur;

        /* ===============================
     * HADIR
     * =============================== */
        if ($request->tipe === 'hadir') {

            if ($absen->jam_masuk) {
                return back()->with('error', 'Anda sudah absen masuk hari ini.');
            }

            // Determine jam masuk based on shift or non-shift
            $jamMasukSetting = Carbon::parse($user->jam_masuk); // Default
            $shiftNumber = null;

            if ($user->is_shift && $user->shift_partner_id) {
                // Check if partner already clocked in today
                $partnerAbsen = Absen::where('user_id', $user->shift_partner_id)
                    ->whereDate('tanggal', $today)
                    ->first();

                if ($partnerAbsen && $partnerAbsen->jam_masuk) {
                    // Partner already clocked in, this user is shift 2
                    $shiftNumber = 2;
                    $jamMasukSetting = Carbon::parse($user->shift2_jam_masuk);
                } else {
                    // This user is shift 1 (first to clock in)
                    $shiftNumber = 1;
                    $jamMasukSetting = Carbon::parse($user->shift1_jam_masuk);
                }
            } else {
                // Non-shift user
                if ($user->jam_masuk) {
                    $jamMasukSetting = Carbon::parse($user->jam_masuk);
                }
            }

            // Override with hari khusus custom jam masuk if available
            if ($isHariKhususKerjaBiasa && $hariKhusus->jam_masuk) {
                if ($hariKhusus->is_shift_enabled && $user->is_shift && $shiftNumber) {
                    // Use shift-specific jam masuk from hari khusus
                    $customJamMasuk = $shiftNumber === 1 ? $hariKhusus->shift1_jam_masuk : $hariKhusus->shift2_jam_masuk;
                    if ($customJamMasuk) {
                        $jamMasukSetting = Carbon::parse($customJamMasuk);
                    }
                } else {
                    // Use general jam masuk from hari khusus
                    $jamMasukSetting = Carbon::parse($hariKhusus->jam_masuk);
                }
            }

            $batasAbsen = Carbon::today()
                ->setTime($jamMasukSetting->hour, $jamMasukSetting->minute)
                ->subMinutes(30);

            if ($now->lt($batasAbsen)) {
                return back()->with('error', 'Anda hanya bisa absen mulai 30 menit sebelum jam masuk (' . $jamMasukSetting->format('H:i') . ').');
            }

            $jamMasukToday = Carbon::today()->setTime($jamMasukSetting->hour, $jamMasukSetting->minute);
            $batasTelat = $jamMasukToday->copy()->addMinutes(10); // Toleransi 10 menit
            $telat = $now->gt($batasTelat);

            // Process and save photo
            $fotoPath = $this->photoService->processPhoto($request->foto, 'masuk', $user->id);

            $absen->update([
                'jam_masuk'   => $now,
                'telat'       => $telat,
                'menit_telat' => $telat ? $batasTelat->diffInMinutes($now) : 0,
                'lat_masuk'   => $request->latitude,
                'lng_masuk'   => $request->longitude,
                'foto_masuk'  => $fotoPath,
                'shift_number' => $shiftNumber,
                'diluar_lokasi_alasan' => $request->diluar_lokasi_alasan,
            ]);

            // Handle lembur hari libur
            $lemburMessage = '';
            if ($request->is_lembur == '1' && $absen->libur) {
                // Create lembur record for holiday overtime (jam_mulai = now, jam_selesai will be filled on pulang)
                Lembur::create([
                    'user_id' => $user->id,
                    'tanggal' => $today,
                    'jam_mulai' => $now,
                    'foto_mulai' => $fotoPath,
                    'keterangan' => $request->lembur_keterangan ?? 'Lembur hari libur',
                    'status' => 'pending',
                ]);
                $lemburMessage = ' (Lembur Hari Libur)';
            }

            $shiftInfo = $shiftNumber ? " (Shift $shiftNumber)" : '';
            return back()->with(
                'success',
                'Absen masuk berhasil dicatat pukul ' . $now->format('H:i') . ($telat ? ' (TELAT)' : '') . $shiftInfo . $lemburMessage
            );
        }

        /* ===============================
     * PULANG
     * =============================== */
        if ($request->tipe === 'pulang') {

            if (!$absen->jam_masuk) {
                return back()->with('error', 'Anda belum melakukan absen masuk hari ini.');
            }

            if ($absen->jam_pulang) {
                return back()->with('error', 'Anda sudah absen pulang hari ini.');
            }

            if ($absen->izin) {
                return back()->with('error', 'Anda sudah izin pulang awal hari ini.');
            }

            // Determine jam pulang based on shift or non-shift
            $jamPulangSetting = Carbon::today()->setTime(20, 0); // Default

            if ($user->is_shift && $user->shift_partner_id) {
                // Use shift-specific jam keluar
                if ((int) $absen->shift_number === 1) {
                    $jamPulangSetting = Carbon::today()->setTime(
                        Carbon::parse($user->shift1_jam_keluar)->hour,
                        Carbon::parse($user->shift1_jam_keluar)->minute
                    );
                } elseif ((int) $absen->shift_number === 2) {
                    $jamPulangSetting = Carbon::today()->setTime(
                        Carbon::parse($user->shift2_jam_keluar)->hour,
                        Carbon::parse($user->shift2_jam_keluar)->minute
                    );
                }
            } else {
                // Non-shift user
                if ($user->jam_keluar) {
                    $jamPulangSetting = Carbon::today()->setTime(
                        Carbon::parse($user->jam_keluar)->hour,
                        Carbon::parse($user->jam_keluar)->minute
                    );
                }
            }

            // Override with hari khusus custom jam keluar if available
            if ($isHariKhususKerjaBiasa && $hariKhusus->jam_keluar) {
                if ($hariKhusus->is_shift_enabled && $user->is_shift && $absen->shift_number) {
                    // Use shift-specific jam keluar from hari khusus
                    $customJamKeluar = (int) $absen->shift_number === 1 ? $hariKhusus->shift1_jam_keluar : $hariKhusus->shift2_jam_keluar;
                    if ($customJamKeluar) {
                        $jamPulangSetting = Carbon::today()->setTime(
                            Carbon::parse($customJamKeluar)->hour,
                            Carbon::parse($customJamKeluar)->minute
                        );
                    }
                } else {
                    // Use general jam keluar from hari khusus
                    $jamPulangSetting = Carbon::today()->setTime(
                        Carbon::parse($hariKhusus->jam_keluar)->hour,
                        Carbon::parse($hariKhusus->jam_keluar)->minute
                    );
                }
            }

            // Skip jam pulang check for holiday lembur
            if (!$absen->libur && $now->lt($jamPulangSetting)) {
                return back()->with('error', 'Absen pulang baru bisa dilakukan setelah jam ' . $jamPulangSetting->format('H:i') . ' WIB. Gunakan "Izin Pulang Awal" jika ingin pulang sebelum waktunya.');
            }

            $menitKerja = $absen->jam_masuk->diffInMinutes($now);

            // Process and save photo
            $fotoPath = $this->photoService->processPhoto($request->foto, 'pulang', $user->id);

            $absen->update([
                'jam_pulang'  => $now,
                'lat_pulang'  => $request->latitude,
                'lng_pulang'  => $request->longitude,
                'foto_pulang' => $fotoPath,
                'menit_kerja' => $menitKerja,
                'diluar_lokasi_alasan' => $request->diluar_lokasi_alasan ?? $absen->diluar_lokasi_alasan,
            ]);

            // Check if this is lembur hari libur (update existing lembur record)
            $lemburMessage = '';
            if ($absen->libur) {
                // Find the lembur record created at masuk
                $lemburLibur = Lembur::where('user_id', $user->id)
                    ->whereDate('tanggal', $today)
                    ->whereNull('jam_selesai')
                    ->first();

                if ($lemburLibur) {
                    $menitLembur = $lemburLibur->jam_mulai->diffInMinutes($now);
                    $lemburLibur->update([
                        'jam_selesai' => $now,
                        'foto_selesai' => $fotoPath,
                        'durasi_menit' => $menitLembur,
                    ]);

                    $jam = floor($menitLembur / 60);
                    $menit = $menitLembur % 60;
                    $lemburMessage = ' + Lembur Hari Libur ' . ($jam > 0 ? $jam . ' jam ' : '') . $menit . ' menit (menunggu approval)';
                }
            }
            // Check if this is marked as lembur (normal day overtime)
            elseif ($request->is_lembur == '1') {
                // Calculate lembur duration (from jam_keluar setting until now)
                $menitLembur = $jamPulangSetting->diffInMinutes($now);

                if ($menitLembur > 0) {
                    // Create lembur record
                    Lembur::create([
                        'user_id' => $user->id,
                        'tanggal' => $today,
                        'jam_mulai' => $jamPulangSetting,
                        'foto_mulai' => $fotoPath, // Use the same photo as pulang
                        'jam_selesai' => $now,
                        'foto_selesai' => $fotoPath,
                        'durasi_menit' => $menitLembur,
                        'keterangan' => $request->lembur_keterangan ?? 'Lembur otomatis dari absen pulang',
                        'status' => 'pending', // Admin can approve later
                    ]);

                    $jam = floor($menitLembur / 60);
                    $menit = $menitLembur % 60;
                    $lemburMessage = ' + Lembur ' . ($jam > 0 ? $jam . ' jam ' : '') . $menit . ' menit (menunggu approval)';
                }
            }

            return back()->with(
                'success',
                'Absen pulang berhasil dicatat pukul ' . $now->format('H:i') . $lemburMessage
            );
        }

        /* ===============================
     * IZIN
     * =============================== */
        if ($request->tipe === 'izin') {

            // Jika belum hadir, ini adalah izin tidak masuk
            if (!$absen->jam_masuk) {
                if ($absen->izin) {
                    return back()->with('error', 'Anda sudah mengajukan izin hari ini.');
                }

                // Process and save photo
                $fotoPath = $this->photoService->processPhoto($request->foto, 'izin', $user->id);

                $absen->update([
                    'izin' => true,
                    'izin_keterangan' => $request->keterangan,
                    'foto_izin' => $fotoPath,
                ]);

                return back()->with('success', 'Izin tidak masuk berhasil dicatat.');
            }

            // Jika sudah hadir, ini adalah izin pulang awal
            if ($absen->jam_pulang) {
                return back()->with('error', 'Anda sudah absen pulang hari ini.');
            }

            if ($absen->izin) {
                return back()->with('error', 'Anda sudah mengajukan izin pulang awal hari ini.');
            }

            $menitKerja = $absen->jam_masuk->diffInMinutes($now);

            // Process and save photo
            $fotoPath = $this->photoService->processPhoto($request->foto, 'izin', $user->id);

            $absen->update([
                'izin' => true,
                'izin_keterangan' => $request->keterangan,
                'foto_izin' => $fotoPath,
                'jam_pulang' => $now,
                'lat_pulang' => $request->latitude,
                'lng_pulang' => $request->longitude,
                'menit_kerja' => $menitKerja,
            ]);

            return back()->with('success', 'Izin pulang awal berhasil dicatat pukul ' . $now->format('H:i'));
        }
    }

    public function kalender(Request $request)
    {
        $bulan = $request->get('bulan', Carbon::now()->month);
        $tahun = $request->get('tahun', Carbon::now()->year);

        // Ambil semua absensi dalam bulan tersebut
        $startDate = Carbon::create($tahun, $bulan, 1)->startOfMonth();
        $endDate = Carbon::create($tahun, $bulan, 1)->endOfMonth();

        // Get public holidays for this month
        $publicHolidays = HariLibur::where(function ($query) use ($startDate, $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]);
        })->orWhere(function ($query) use ($startDate, $endDate) {
            $query->where('is_recurring', true)
                ->whereMonth('tanggal', $startDate->month);
        })->get()->keyBy(function ($item) {
            return $item->tanggal->format('m-d');
        });

        $absensiBulan = Absen::with('user')
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal')
            ->get()
            ->groupBy(function ($item) {
                return $item->tanggal->format('Y-m-d');
            });

        // Hitung statistik per hari
        $kalenderData = [];
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $tanggal = $date->format('Y-m-d');
            $monthDay = $date->format('m-d');
            $absensiHari = $absensiBulan->get($tanggal, collect());

            // Check if this day is a public holiday
            $publicHoliday = $publicHolidays->get($monthDay);

            $kalenderData[$tanggal] = [
                'tanggal' => $date,
                'total_absen' => $absensiHari->count(),
                'hadir_tepat_waktu' => $absensiHari
                    ->where('telat', 0)
                    ->where('izin', 0)
                    ->where('libur', 0)
                    ->where('tidak_hadir', 0)
                    ->whereNotNull('jam_masuk')
                    ->count(),
                'hadir_terlambat' => $absensiHari->where('telat', 1)->count(),
                'izin' => $absensiHari->where('izin', true)->count(),
                'libur' => $absensiHari->where('libur', true)->count(),
                'tidak_hadir' => $absensiHari->where('tidak_hadir', true)->count(),
                'absensi' => $absensiHari,
                'public_holiday' => $publicHoliday,
            ];
        }

        return view('absensi.kalender', compact('kalenderData', 'bulan', 'tahun'));
    }

    public function detailHari(Request $request, $tanggal)
    {
        $date = Carbon::parse($tanggal);

        // Ambil semua pegawai
        $employees = User::where('role', 'pegawai')
            ->where('is_inactive', false)
            ->get();

        // Ambil absensi hari itu
        $absensi = Absen::with('user')
            ->whereDate('tanggal', $date)
            ->get()
            ->keyBy('user_id');

        // Gabungkan data
        $absensiHari = $employees->map(function ($employee) use ($absensi) {
            if ($absensi->has($employee->id)) {
                return $absensi->get($employee->id);
            }

            // Buat objek absen kosong untuk pegawai yang belum absen
            $emptyAbsen = new Absen();
            $emptyAbsen->user = $employee; // Set relation manually
            $emptyAbsen->user_id = $employee->id;
            return $emptyAbsen;
        });

        // Sorting Logic
        $sortBy = $request->get('sort_by', 'name');
        $sortDirection = $request->get('sort_direction', 'asc');

        $absensiHari = $absensiHari->sort(function ($a, $b) use ($sortBy, $sortDirection) {
            $valA = null;
            $valB = null;

            switch ($sortBy) {
                case 'name':
                    $valA = strtolower($a->user->name);
                    $valB = strtolower($b->user->name);
                    break;
                case 'jam_masuk':
                    // For time sorting, handle nulls.
                    // If ASC, nulls last (max value). If DESC, nulls last (min value).
                    $valA = $a->jam_masuk ? $a->jam_masuk->timestamp : ($sortDirection === 'asc' ? PHP_INT_MAX : -1);
                    $valB = $b->jam_masuk ? $b->jam_masuk->timestamp : ($sortDirection === 'asc' ? PHP_INT_MAX : -1);
                    break;
                case 'jam_pulang':
                    $valA = $a->jam_pulang ? $a->jam_pulang->timestamp : ($sortDirection === 'asc' ? PHP_INT_MAX : -1);
                    $valB = $b->jam_pulang ? $b->jam_pulang->timestamp : ($sortDirection === 'asc' ? PHP_INT_MAX : -1);
                    break;
                case 'status':
                    // Weight: Tepat Waktu (1), Telat (2), Izin (3), Belum Absen (4)
                    $getStatusWeight = function ($absen) {
                        if ($absen->izin) return 3;
                        if ($absen->jam_masuk) {
                            return $absen->status === 'tepat_waktu' ? 1 : 2;
                        }
                        return 4;
                    };
                    $valA = $getStatusWeight($a);
                    $valB = $getStatusWeight($b);
                    break;
                default:
                    $valA = strtolower($a->user->name);
                    $valB = strtolower($b->user->name);
            }

            if ($valA == $valB) return 0;

            if ($sortDirection === 'asc') {
                return $valA < $valB ? -1 : 1;
            } else {
                return $valA > $valB ? -1 : 1;
            }
        });

        return view('absensi.detail-hari', compact('absensiHari', 'tanggal'));
    }

    public function absensiUser(Request $request)
    {
        $userId = $request->get('user_id');
        $bulan = $request->get('bulan', Carbon::now()->month);
        $tahun = $request->get('tahun', Carbon::now()->year);

        $users = User::where('role', 'pegawai')->orderBy('name')->get();

        $absensi = collect();
        $user = null;

        if ($userId) {
            $user = User::find($userId);

            $startDate = Carbon::create($tahun, $bulan, 1)->startOfMonth();
            $endDate = Carbon::create($tahun, $bulan, 1)->endOfMonth();

            $absensi = Absen::where('user_id', $userId)
                ->whereBetween('tanggal', [$startDate, $endDate])
                ->with('user')
                ->orderBy('tanggal', 'desc')
                ->get();
        }

        return view('absensi.user', compact('users', 'absensi', 'userId', 'user', 'bulan', 'tahun'));
    }

    public function edit(Absen $absen)
    {
        return view('absensi.edit', compact('absen'));
    }

    public function create($tanggal, User $user)
    {
        $date = Carbon::parse($tanggal);

        // Check if absen already exists for this user on this date
        $existingAbsen = Absen::where('user_id', $user->id)
            ->whereDate('tanggal', $date)
            ->first();

        if ($existingAbsen) {
            return redirect()->route('absen.edit', $existingAbsen)
                ->with('info', 'Data absensi sudah ada untuk tanggal ini. Menampilkan form edit.');
        }

        return view('absensi.create', compact('user', 'tanggal'));
    }

    public function storeManual(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'jam_masuk' => 'nullable|string',
            'jam_pulang' => 'nullable|string',
            'izin' => 'nullable',
            'izin_keterangan' => 'nullable|string|max:255',
            'telat' => 'nullable',
            'menit_telat' => 'nullable|integer|min:0',
            'tidak_hadir' => 'nullable',
            'libur' => 'nullable',
            'shift_number' => 'nullable|integer|in:1,2',
            'lat_masuk' => 'nullable|numeric',
            'lng_masuk' => 'nullable|numeric',
            'lat_pulang' => 'nullable|numeric',
            'lng_pulang' => 'nullable|numeric',
        ]);

        $tanggal = Carbon::parse($request->tanggal);

        // Check if absen already exists
        $existingAbsen = Absen::where('user_id', $request->user_id)
            ->whereDate('tanggal', $tanggal)
            ->first();

        if ($existingAbsen) {
            return redirect()->route('absen.edit', $existingAbsen)
                ->with('error', 'Data absensi sudah ada untuk tanggal ini.');
        }

        $data = [
            'user_id' => $request->user_id,
            'tanggal' => $tanggal,
            'izin' => $request->has('izin') ? (bool) $request->izin : false,
            'izin_keterangan' => $request->izin_keterangan,
            'telat' => $request->has('telat') ? (bool) $request->telat : false,
            'menit_telat' => (int) ($request->menit_telat ?? 0),
            'tidak_hadir' => $request->has('tidak_hadir') ? (bool) $request->tidak_hadir : false,
            'libur' => $request->has('libur') ? (bool) $request->libur : false,
        ];

        // Handle shift number if provided
        if ($request->filled('shift_number')) {
            $data['shift_number'] = (int) $request->shift_number;
        }

        // Parse jam masuk safely
        if ($request->filled('jam_masuk')) {
            try {
                $data['jam_masuk'] = Carbon::parse($request->jam_masuk)->setDateFrom($tanggal);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Format jam masuk tidak valid');
            }
        }

        // Parse jam pulang safely
        if ($request->filled('jam_pulang')) {
            try {
                $data['jam_pulang'] = Carbon::parse($request->jam_pulang)->setDateFrom($tanggal);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Format jam pulang tidak valid');
            }
        }

        // Handle location data
        if ($request->filled('lat_masuk')) {
            $data['lat_masuk'] = $request->lat_masuk;
        }
        if ($request->filled('lng_masuk')) {
            $data['lng_masuk'] = $request->lng_masuk;
        }
        if ($request->filled('lat_pulang')) {
            $data['lat_pulang'] = $request->lat_pulang;
        }
        if ($request->filled('lng_pulang')) {
            $data['lng_pulang'] = $request->lng_pulang;
        }

        // Calculate menit_kerja if both times exist
        if (isset($data['jam_masuk']) && isset($data['jam_pulang'])) {
            $data['menit_kerja'] = $data['jam_masuk']->diffInMinutes($data['jam_pulang'], false);
        }

        // Set status based on telat
        $data['status'] = $data['telat'] ? 'telat' : 'tepat_waktu';

        Absen::create($data);

        return redirect()->route('absen.detailHari', $tanggal->format('Y-m-d'))
            ->with('success', 'Absensi manual berhasil ditambahkan');
    }

    public function update(Request $request, Absen $absen)
    {
        $request->validate([
            'jam_masuk' => 'nullable|string',
            'jam_pulang' => 'nullable|string',
            'izin' => 'nullable',
            'izin_keterangan' => 'nullable|string|max:255',
            'telat' => 'nullable',
            'menit_telat' => 'nullable|integer|min:0',
            'tidak_hadir' => 'nullable',
            'libur' => 'nullable',
            'status' => 'nullable|string|in:tepat_waktu,telat',
            'shift_number' => 'nullable|integer|in:1,2',
            'lat_masuk' => 'nullable|numeric',
            'lng_masuk' => 'nullable|numeric',
            'lat_pulang' => 'nullable|numeric',
            'lng_pulang' => 'nullable|numeric',
        ]);

        $data = [];
        $tanggal = $absen->tanggal->format('Y-m-d');

        // Parse jam masuk safely
        if ($request->filled('jam_masuk')) {
            try {
                $jamMasuk = Carbon::parse($request->jam_masuk)->setDateFrom($absen->tanggal);
                $data['jam_masuk'] = $jamMasuk;
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Format jam masuk tidak valid');
            }
        } elseif ($request->has('jam_masuk') && $request->jam_masuk === null) {
            $data['jam_masuk'] = null;
        }

        // Parse jam pulang safely
        if ($request->filled('jam_pulang')) {
            try {
                $jamPulang = Carbon::parse($request->jam_pulang)->setDateFrom($absen->tanggal);
                $data['jam_pulang'] = $jamPulang;
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Format jam pulang tidak valid');
            }
        } elseif ($request->has('jam_pulang') && $request->jam_pulang === null) {
            $data['jam_pulang'] = null;
        }

        // Handle izin status
        $data['izin'] = $request->has('izin') ? (bool) $request->izin : false;
        $data['izin_keterangan'] = $request->izin_keterangan;

        // Handle telat status (manual override)
        if ($request->has('telat')) {
            $data['telat'] = (bool) $request->telat;
        }

        // Handle menit telat
        if ($request->has('menit_telat')) {
            $data['menit_telat'] = (int) $request->menit_telat;
        }

        // Handle tidak hadir status
        $data['tidak_hadir'] = $request->has('tidak_hadir') ? (bool) $request->tidak_hadir : false;

        // Handle libur status
        $data['libur'] = $request->has('libur') ? (bool) $request->libur : false;

        // Handle status
        if ($request->filled('status')) {
            $data['status'] = $request->status;
        }

        // Handle shift number
        if ($request->has('shift_number')) {
            $data['shift_number'] = $request->filled('shift_number') ? (int) $request->shift_number : null;
        }

        // Handle location data
        if ($request->has('lat_masuk')) {
            $data['lat_masuk'] = $request->lat_masuk;
        }
        if ($request->has('lng_masuk')) {
            $data['lng_masuk'] = $request->lng_masuk;
        }
        if ($request->has('lat_pulang')) {
            $data['lat_pulang'] = $request->lat_pulang;
        }
        if ($request->has('lng_pulang')) {
            $data['lng_pulang'] = $request->lng_pulang;
        }

        // Recalculate menit_kerja if both times exist
        $jamMasukFinal = isset($data['jam_masuk']) ? $data['jam_masuk'] : $absen->jam_masuk;
        $jamPulangFinal = isset($data['jam_pulang']) ? $data['jam_pulang'] : $absen->jam_pulang;

        if ($jamMasukFinal && $jamPulangFinal) {
            $data['menit_kerja'] = $jamMasukFinal->diffInMinutes($jamPulangFinal, false);
        }

        $absen->update($data);

        return redirect()->route('absen.detailHari', $tanggal)->with('success', 'Absensi berhasil diperbarui');
    }

    public function destroy(Absen $absen)
    {
        // Store the date for redirect
        $tanggal = $absen->tanggal->format('Y-m-d');

        // Delete the absensi record
        $absen->delete();

        return redirect()->route('absen.detailHari', $tanggal)->with('success', 'Absensi berhasil dihapus');
    }

    /**
     * Calculate distance between two coordinates using Haversine formula
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // meters

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
