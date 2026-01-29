{{-- Absensi Page Script Component --}}
@props([
    'officeLatitude',
    'officeLongitude',
    'allowedRadius',
    'sudahHadir' => null,
    'sudahIzin' => null,
    'sudahPulang' => null,
    'liburOrNot' => false,
    'jamPulangHour' => 20,
    'jamPulangMinute' => 0,
])

<script>
    let userLatitude = null;
    let userLongitude = null;
    let cameraStream = null;
    let capturedPhotoData = null;
    let currentTipe = null;
    let isOutsideLocation = false;
    let currentDistance = 0;

    // Office coordinates
    const officeLatitude = {{ $officeLatitude }};
    const officeLongitude = {{ $officeLongitude }};
    const allowedRadius = {{ $allowedRadius }};

    // Calculate distance using Haversine formula
    function calculateDistance(lat1, lon1, lat2, lon2) {
        const earthRadius = 6371000; // meters
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
            Math.sin(dLon / 2) * Math.sin(dLon / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return earthRadius * c;
    }

    // Update current datetime
    function updateDateTime() {
        const now = new Date();
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };
        const el = document.getElementById('current-datetime');
        if (el) el.textContent = now.toLocaleDateString('id-ID', options);
    }
    updateDateTime();
    setInterval(updateDateTime, 1000);

    // Get user location
    function getLocation() {
        const statusEl = document.getElementById('location-status');
        if (!statusEl) return;

        if (!navigator.geolocation) {
            statusEl.innerHTML = `
                <div class="flex items-center gap-3 text-red-600">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <span>Browser tidak mendukung Geolocation</span>
                </div>
            `;
            return;
        }

        navigator.geolocation.getCurrentPosition(
            (position) => {
                userLatitude = position.coords.latitude;
                userLongitude = position.coords.longitude;
                currentDistance = calculateDistance(userLatitude, userLongitude, officeLatitude, officeLongitude);
                isOutsideLocation = currentDistance > allowedRadius;

                if (isOutsideLocation) {
                    statusEl.innerHTML = `
                        <div class="flex items-center gap-3 text-yellow-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <span>Di luar area kantor (${Math.round(currentDistance)}m dari kantor)</span>
                            <button onclick="getLocation()" class="ml-auto text-sm bg-yellow-100 px-3 py-1 rounded-lg hover:bg-yellow-200 transition-colors">Refresh</button>
                        </div>
                    `;
                    statusEl.className = 'mb-6 p-4 rounded-2xl shadow-sm bg-yellow-50 border border-yellow-200';
                } else {
                    statusEl.innerHTML = `
                        <div class="flex items-center gap-3 text-green-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Lokasi berhasil diambil (Dalam area kantor)</span>
                            <button onclick="getLocation()" class="ml-auto text-sm bg-green-100 px-3 py-1 rounded-lg hover:bg-green-200 transition-colors">Refresh</button>
                        </div>
                    `;
                    statusEl.className = 'mb-6 p-4 rounded-2xl shadow-sm bg-green-50 border border-green-200';
                }
            },
            (error) => {
                let errorMessage = 'Gagal mengambil lokasi';
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        errorMessage = 'Izin lokasi ditolak. Mohon aktifkan GPS.';
                        break;
                    case error.POSITION_UNAVAILABLE:
                        errorMessage = 'Informasi lokasi tidak tersedia.';
                        break;
                    case error.TIMEOUT:
                        errorMessage = 'Waktu pengambilan lokasi habis.';
                        break;
                }
                statusEl.innerHTML = `
                    <div class="flex items-center gap-3 text-red-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <span>${errorMessage}</span>
                        <button onclick="getLocation()" class="ml-auto text-sm bg-red-100 px-3 py-1 rounded-lg hover:bg-red-200 transition-colors">Coba Lagi</button>
                    </div>
                `;
                statusEl.className = 'mb-6 p-4 rounded-2xl shadow-sm bg-red-50 border border-red-200';
            }, {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    }
    getLocation();

    // Camera functions
    async function openCameraModal(tipe) {
        currentTipe = tipe;
        capturedPhotoData = null;

        const titleEl = document.getElementById('camera-title');
        const submitTextEl = document.getElementById('btn-submit-text');
        const izinWrapper = document.getElementById('izin-keterangan-wrapper');
        const izinLabel = document.getElementById('izin-label');
        const diluarLokasiWrapper = document.getElementById('diluar-lokasi-wrapper');

        diluarLokasiWrapper.classList.add('hidden');
        document.getElementById('diluar-lokasi-input').value = '';

        if (tipe === 'hadir') {
            titleEl.textContent = 'Foto Absen Hadir';
            submitTextEl.textContent = 'Kirim Absen Hadir';
            izinWrapper.classList.add('hidden');
            if (isOutsideLocation) {
                diluarLokasiWrapper.classList.remove('hidden');
                document.getElementById('diluar-lokasi-jarak').textContent = 'Jarak Anda: ' + Math.round(
                        currentDistance) +
                    ' meter dari kantor. Silakan masukkan alasan untuk absen dari luar lokasi.';
            }
        } else if (tipe === 'pulang') {
            titleEl.textContent = 'Foto Absen Pulang';
            submitTextEl.textContent = 'Kirim Absen Pulang';
            izinWrapper.classList.add('hidden');
            if (isOutsideLocation) {
                diluarLokasiWrapper.classList.remove('hidden');
                document.getElementById('diluar-lokasi-jarak').textContent = 'Jarak Anda: ' + Math.round(
                        currentDistance) +
                    ' meter dari kantor. Silakan masukkan alasan untuk absen dari luar lokasi.';
            }
        } else if (tipe === 'izin') {
            @if ($sudahHadir)
                titleEl.textContent = 'Foto Izin Pulang Awal';
                submitTextEl.textContent = 'Kirim Izin Pulang Awal';
                izinLabel.textContent = 'Alasan Pulang Awal';
            @else
                titleEl.textContent = 'Foto Izin Tidak Masuk';
                submitTextEl.textContent = 'Kirim Izin';
                izinLabel.textContent = 'Alasan Izin';
            @endif
            izinWrapper.classList.remove('hidden');
        }

        // Reset UI
        document.getElementById('camera-preview').classList.remove('hidden');
        document.getElementById('photo-preview').classList.add('hidden');
        document.getElementById('photo-result').classList.add('hidden');
        document.getElementById('btn-capture').classList.remove('hidden');
        document.getElementById('btn-retake').classList.add('hidden');
        document.getElementById('btn-submit').classList.add('hidden');

        document.getElementById('camera-modal').classList.remove('hidden');

        try {
            cameraStream = await navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: 'user',
                    width: {
                        ideal: 640
                    },
                    height: {
                        ideal: 480
                    }
                },
                audio: false
            });
            document.getElementById('camera-preview').srcObject = cameraStream;
        } catch (error) {
            alert('Tidak dapat mengakses kamera. Pastikan izin kamera telah diberikan.');
            closeCameraModal();
        }
    }

    function closeCameraModal() {
        if (cameraStream) {
            cameraStream.getTracks().forEach(track => track.stop());
            cameraStream = null;
        }
        document.getElementById('camera-modal').classList.add('hidden');
        currentTipe = null;
        capturedPhotoData = null;
    }

    function capturePhoto() {
        const video = document.getElementById('camera-preview');
        const canvas = document.getElementById('camera-canvas');
        const ctx = canvas.getContext('2d');

        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;

        ctx.save();
        ctx.scale(-1, 1);
        ctx.drawImage(video, -canvas.width, 0);
        ctx.restore();

        capturedPhotoData = canvas.toDataURL('image/jpeg', 0.7);

        document.getElementById('captured-photo').src = capturedPhotoData;
        document.getElementById('photo-result').classList.remove('hidden');
        document.getElementById('camera-preview').classList.add('hidden');
        document.getElementById('btn-capture').classList.add('hidden');
        document.getElementById('btn-retake').classList.remove('hidden');
        document.getElementById('btn-submit').classList.remove('hidden');
    }

    function retakePhoto() {
        capturedPhotoData = null;
        document.getElementById('camera-preview').classList.remove('hidden');
        document.getElementById('photo-result').classList.add('hidden');
        document.getElementById('btn-capture').classList.remove('hidden');
        document.getElementById('btn-retake').classList.add('hidden');
        document.getElementById('btn-submit').classList.add('hidden');
    }

    function submitWithPhoto() {
        if (!capturedPhotoData) {
            alert('Silakan ambil foto terlebih dahulu.');
            return;
        }

        if (!userLatitude || !userLongitude) {
            alert('Lokasi belum tersedia. Mohon tunggu atau aktifkan GPS.');
            return;
        }

        document.getElementById('camera-tipe').value = currentTipe;
        document.getElementById('camera-lat').value = userLatitude;
        document.getElementById('camera-lng').value = userLongitude;
        document.getElementById('camera-foto').value = capturedPhotoData;

        if (currentTipe === 'izin') {
            const keterangan = document.getElementById('izin-keterangan-input').value;
            if (!keterangan.trim()) {
                alert('Silakan masukkan alasan izin.');
                return;
            }
            document.getElementById('camera-keterangan').value = keterangan;
        }

        if ((currentTipe === 'hadir' || currentTipe === 'pulang') && isOutsideLocation) {
            document.getElementById('camera-diluar-lokasi-alasan').value = document.getElementById(
                'diluar-lokasi-input').value;
        }

        if (isLemburLibur && currentTipe === 'hadir') {
            document.getElementById('camera-is-lembur').value = '1';
            document.getElementById('camera-lembur-keterangan').value = lemburKeteranganPrefilled;
            isLemburLibur = false;
            lemburKeteranganPrefilled = '';
        }

        @if (!$liburOrNot)
            if (currentTipe === 'pulang') {
                const lemburMenit = checkLemburEligibility();
                if (lemburMenit > 0) {
                    document.getElementById('lembur-menit').textContent = lemburMenit;
                    document.getElementById('lembur-modal').classList.remove('hidden');
                    return;
                }
            }
        @endif

        if (cameraStream) {
            cameraStream.getTracks().forEach(track => track.stop());
        }

        document.getElementById('camera-form').submit();
    }

    function checkLemburEligibility() {
        @if ($sudahHadir && !$sudahIzin && !$sudahPulang)
            const jamPulang = new Date();
            jamPulang.setHours({{ $jamPulangHour }}, {{ $jamPulangMinute }}, 0);
            const now = new Date();
            const diffMins = Math.floor((now - jamPulang) / 60000);
            return diffMins >= 30 ? diffMins : 0;
        @else
            return 0;
        @endif
    }

    function showLemburKeterangan() {
        document.getElementById('lembur-keterangan-wrapper').classList.remove('hidden');
        document.getElementById('btn-submit-lembur').classList.remove('hidden');
    }

    function confirmLembur(isLembur) {
        if (isLembur) {
            document.getElementById('camera-is-lembur').value = '1';
            document.getElementById('camera-lembur-keterangan').value = document.getElementById(
                'lembur-keterangan-input').value;
        } else {
            document.getElementById('camera-is-lembur').value = '0';
            document.getElementById('camera-lembur-keterangan').value = '';
        }

        document.getElementById('lembur-modal').classList.add('hidden');
        if (cameraStream) {
            cameraStream.getTracks().forEach(track => track.stop());
        }
        document.getElementById('camera-form').submit();
    }

    // Lembur Hari Libur Functions
    let lemburLiburType = 'hadir';
    let isLemburLibur = false;
    let lemburKeteranganPrefilled = '';

    function openLemburLiburModal(type) {
        lemburLiburType = type;
        document.getElementById('lembur-libur-modal').classList.remove('hidden');
        document.getElementById('lembur-libur-keterangan-input').value = '';
    }

    function closeLemburLiburModal() {
        document.getElementById('lembur-libur-modal').classList.add('hidden');
    }

    function confirmLemburLibur() {
        const keterangan = document.getElementById('lembur-libur-keterangan-input').value.trim();
        if (!keterangan) {
            alert('Mohon masukkan keterangan lembur');
            return;
        }
        lemburKeteranganPrefilled = keterangan;
        isLemburLibur = true;
        closeLemburLiburModal();
        openCameraModal(lemburLiburType);
    }

    // Update working hours
    @if ($sudahHadir && !$sudahIzin && !$sudahPulang)
        let checkInTime = '{{ $sudahHadir->jam_masuk->format('H:i:s') }}';
        setInterval(updateWorkingHours, 60000);
        updateWorkingHours();
    @endif

    function updateWorkingHours() {
        if (typeof checkInTime === 'undefined') return;
        const now = new Date();
        const checkIn = new Date();
        const [hours, minutes, seconds] = checkInTime.split(':');
        checkIn.setHours(parseInt(hours), parseInt(minutes), parseInt(seconds));

        const diffMins = Math.floor((now - checkIn) / 60000);
        const hoursWorked = Math.floor(diffMins / 60);
        const minsWorked = diffMins % 60;

        const el = document.getElementById('working-hours');
        if (el) el.textContent = hoursWorked + ' jam ' + minsWorked + ' menit';
    }
</script>
