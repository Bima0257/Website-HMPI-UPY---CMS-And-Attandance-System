<x-Dashboard.main-layout title="{{ $title }}">
    <div class="row g-4">
        <!-- Kolom untuk tabel presensi -->
        <div class="col-lg-8">
            <div class="mb-4">
                <h2 class="mb-5 text-center">Data Presensi</h2>

                <div class="d-flex gap-2 flex-wrap mb-3">
                    <!-- Create QR Code Button -->
                    <button type="button" class="btn btn-primary btn-add-qrCode" data-bs-toggle="modal"
                        data-bs-target="#modal-action">
                        <i class="bx bx-plus"></i> Manual Presence
                    </button>

                    <!-- Download All QR Codes Button -->
                    <form method="POST" action="{{ route('presences.arsipkan') }}" id="arsipForm">
                        @csrf
                        <button type="button" id="arsipBtn" class="btn btn-warning">Arsipkan Presensi</button>
                    </form>


                    <form id="delete-all-presences" action="{{ route('presences.deleteAll') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger delete-btn">
                            <i class="bx bx-trash"></i> Delete All Presences
                        </button>
                    </form>
                </div>

                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Divisi</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody id="t-body">
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->qrCode?->nama ?? 'Unknown' }}</td>
                                <td>{{ $item->qrCode?->divisi ?? 'Tidak ada divisi' }}</td>
                                <td>{{ $item->status }}</td>
                                <td>
                                    <div class="d-flex align-items-center flex-wrap gap-2">
                                        <a href="#"
                                            class="btn btn-warning edit-btn d-flex align-items-center justify-content-center"
                                            data-id="{{ $item->id }}" style="width: 40px; height: 40px;">
                                            <i class='bx bx-edit'></i>
                                        </a>

                                        <form action="/dashboard/presences/{{ $item->id }}" method="POST">
                                            @method('delete')
                                            @csrf
                                            <button type="submit"
                                                class="btn btn-danger delete-btn d-flex align-items-center justify-content-center"
                                                style="width: 40px; height: 40px;">
                                                <i class='bx bxs-trash-alt'></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        <!-- Kolom untuk kamera scanner -->
        <div class="col-lg-4 mt-5">
            <div class="card shadow-lg rounded-4 border-0">
                <div class="card-header bg-gradient bg-info text-center rounded-top-4 py-3">
                    <h5 class="card-title mb-0 fw-semibold text-white">Scanner QR Code</h5>
                </div>
                <div class="card-body d-flex flex-column align-items-center">
                    <form id="presensi-setting" class="w-100 mb-4">
                        <div class="mb-2">
                            <label for="waktu_mulai" class="form-label small">Waktu Mulai Presensi</label>
                            <input type="time" name="waktu_mulai" id="waktu_mulai"
                                class="form-control form-control-sm" required>
                        </div>

                        <div class="mb-2">
                            <label for="batas_telat" class="form-label small">Toleransi Telat (menit)</label>
                            <select name="batas_telat" id="batas_telat" class="form-select form-select-sm" required>
                                @foreach ([5, 10, 15, 20, 30] as $menit)
                                    <option value="{{ $menit }}">{{ $menit }} menit</option>
                                @endforeach
                            </select>
                        </div>
                    </form>


                    <!-- Area kamera -->

                    <div id="reader" class=" rounded-4 shadow-sm"
                        style="width: 100%; max-width: 300px; margin: auto;"></div>

                    <!-- Pesan hasil -->
                    <p id="qr-result" class="mt-3 text-secondary small fst-italic">
                        Arahkan QR ke kamera untuk melakukan scan.
                    </p>

                    <!-- Tombol kontrol -->
                    <div class="d-flex justify-content-center gap-3 mt-3">
                        <button id="start-scan" class="btn btn-success px-4">
                            <i class="bx bx-play-circle fs-5 me-1"></i> Mulai
                        </button>
                        <button id="stop-scan" class="btn btn-danger px-4" disabled>
                            <i class="bx bx-stop-circle fs-5 me-1"></i> Berhenti
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal-action" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add Presence</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="px-4">
                        <form id="presenceform" action="{{ route('presences.manual.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" id="presence_id">
                            <div class="mb-3">
                                <label for="qr_code_id" class="form-label">Pilih Anggota</label>
                                <select class="form-select" name="qr_code_id" id="qr_code_id" required>
                                    <option value="">-- Pilih Anggota --</option>
                                    @foreach ($qrcode as $qr)
                                        <option value="{{ $qr->id }}">
                                            {{ $qr->nama ?? 'Nama Tidak Diketahui' }}
                                            - {{ $qr->divisi ?? 'Divisi Tidak Diketahui' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status Presensi</label>
                                <select class="form-select" name="status" id="status" required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="Hadir">Hadir</option>
                                    <option value="Izin">Izin</option>
                                    <option value="Telat">Telat</option>
                                    <option value="Alpha">Alpha</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="tanggal_presensi" class="form-label">Tanggal Presensi</label>
                                <input type="date" class="form-control" name="tanggal_presensi"
                                    id="tanggal_presensi" value="{{ date('Y-m-d') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="jam_presensi" class="form-label">Jam Presensi</label>
                                <input type="time" class="form-control" name="jam_presensi" id="jam_presensi"
                                    required>
                            </div>

                            <button type="submit" id="submitButton" class="btn btn-success w-100">Simpan
                                Presensi</button>
                        </form>

                    </div> <!-- end col -->
                </div>

            </div>
        </div>
    </div>

    <audio id="success-sound" preload="auto">
        <source src="/assets_dashboard/sound/success2.mp3" type="audio/mpeg">
    </audio>

    <audio id="error-sound" preload="auto">
        <source src="/assets_dashboard/sound/error.mp3" type="audio/mpeg">
    </audio>


</x-Dashboard.main-layout>
<script>
    document.getElementById('arsipBtn').addEventListener('click', function() {
        // Cek apakah ada data presensi
        @if ($data->isEmpty())
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Data presensi kosong, tidak bisa diarsipkan!'
            });
        @else
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Semua data presensi akan dipindahkan ke laporan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, arsipkan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('arsipForm').submit();
                }
            });
        @endif
    });

    $('#modal-action').on('shown.bs.modal', function() {
        const date = new Date();

        // Dapatkan jam dan menit dalam format yang diperlukan untuk input type="time"
        const hours = date.getHours().toString().padStart(2, '0');
        const minutes = date.getMinutes().toString().padStart(2, '0');

        // Format waktu sebagai "HH:MM" yang sesuai untuk input type="time"
        const timeString = `${hours}:${minutes}`;

        // Isi input jam_presensi dengan waktu otomatis
        $('#jam_presensi').val(timeString);
    });

    $('.edit-btn').on('click', function() {
        const id = $(this).data('id');

        $("#modalTitle").text("Edit Presensi");
        $("#submitButton").text("Update Presensi");

        if (!$('#presenceform input[name="_method"]').length) {
            $("#presenceform").append('<input type="hidden" name="_method" value="PUT">');
        }

        $.get(`/dashboard/presences/${id}/edit`, function(data) {
            $('#presence_id').val(data.id);
            $('#qr_code_id').val(data.qr_code_id);
            $('#tanggal_presensi').val(data.tanggal_presensi);

            // Menangani jam_presensi dengan lebih robust
            if (data.jam_presensi) {
                // Memotong string waktu menjadi HH:MM saja (menghilangkan detik jika ada)
                let timeParts = data.jam_presensi.split(':');
                let formattedTime = `${timeParts[0]}:${timeParts[1]}`;

                $('#jam_presensi').val(formattedTime);
            }

            $('#status').val(data.status);

            $('#presenceform').attr('action', `/dashboard/presences/${data.id}`);

            // Modal akan ditampilkan, dan event 'shown.bs.modal' akan dipicu
            // yang akan mengisi jam otomatis, sehingga perlu nonaktifkan itu sementara
            const originalJam = $('#jam_presensi').val();
            $('#modal-action').modal('show');

            // Pastikan nilai jam_presensi tidak diubah oleh event 'shown.bs.modal'
            $('#modal-action').on('shown.bs.modal', function() {
                $('#jam_presensi').val(originalJam);
                // Hapus event handler setelah digunakan sekali
                $(this).off('shown.bs.modal');
            });
        });
    });


    // Konstanta global
    const html5QrCode = new Html5Qrcode("reader");
    let waktuMulai = null;
    let batasTelat = null;

    const scannerState = {
        isScanning: false,
        loadingInterval: null,
        isErrorShown: false,
        isCooldown: false,
        debounceTimeout: null,
    };


    const startBtn = document.getElementById("start-scan");
    const stopBtn = document.getElementById("stop-scan");
    const resultText = document.getElementById("qr-result");
    const successSound = document.getElementById("success-sound");
    const errorSound = document.getElementById("error-sound");

    const DEBOUNCE_TIME = 100;
    const COOLDOWN_TIME = 300;
    const RESET_DELAY = 3000;


    scannerState.isSwalOpen = false;

    function showSwal(options) {
        if (scannerState.isSwalOpen) return Promise.resolve();

        scannerState.isSwalOpen = true;
        return Swal.fire(options).then((result) => {
            scannerState.isSwalOpen = false;
            return result;
        });
    }

    let isSoundPlaying = false;

    function playSound(sound) {
        if (!sound || isSoundPlaying) return; // cegah overlap
        isSoundPlaying = true;

        sound.currentTime = 0; // mulai dari awal
        sound.play().catch(() => {
            isSoundPlaying = false; // reset kalau gagal play
        });

        sound.onended = () => {
            isSoundPlaying = false; // reset setelah selesai
        };
    }




    function onScanSuccess(qrMessage) {
        clearTimeout(scannerState.debounceTimeout);
        if (scannerState.isCooldown) return;

        scannerState.debounceTimeout = setTimeout(() => {
            scannerState.isCooldown = true;
            setTimeout(() => scannerState.isCooldown = false, COOLDOWN_TIME);

            // Tampilkan status loading
            resultText.className = "mt-3 text-primary small fst-italic";
            resultText.innerText = "Memproses presensi...";

            fetch("/dashboard/presences", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        qr_data: qrMessage,
                        waktu_mulai: waktuMulai,
                        batas_telat: batasTelat
                    })
                })
                .then(res => {
                    if (!res.ok) {
                        return res.json().then(error => {
                            if (!scannerState.isErrorShown) {
                                scannerState.isErrorShown = true;

                                const title = res.status === 404 ? "QR Code tidak valid!" :
                                    res.status === 409 ? "Sudah Presensi!" :
                                    "Presensi Gagal!";
                                const text = error.message || "Terjadi kesalahan saat presensi.";

                                if (errorSound) playSound(errorSound);;
                                showSwal({
                                    icon: "error",
                                    title,
                                    text,
                                    confirmButtonColor: "#dc3545"
                                }).then(() => scannerState.isErrorShown = false);

                                resultText.className = "mt-3 text-danger small fst-italic";
                                resultText.innerText = text;

                                // reset pesan setelah beberapa detik
                                setTimeout(() => {
                                    resultText.className =
                                        "mt-3 text-muted small fst-italic";
                                    resultText.innerText =
                                        "Arahkan QR ke kamera untuk melakukan scan.";
                                }, RESET_DELAY);
                            }
                            throw new Error(error.message || "Presensi gagal");
                        });
                    }
                    return res.json();
                })
                .then(res => {
                    if (res.data) {
                        const table = $('#basic-datatable').DataTable();
                        table.row.add([
                            table.rows().count() + 1,
                            res.data.nama,
                            res.data.divisi ?? '-',
                            res.data.status,
                            `<div class="d-flex align-items-center flex-wrap gap-2">
                        <a href="/dashboard/presences/${res.data.presence_id}/edit" 
                           class="btn btn-warning d-flex align-items-center justify-content-center edit-btn" 
                           data-id="${res.data.presence_id}" 
                           style="width: 40px; height: 40px;" 
                           title="Edit">
                           <i class='bx bx-edit'></i>
                        </a>
                        <form action="/dashboard/presences/${res.data.presence_id}" method="POST">
                            <input type="hidden" name="_method" value="delete">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" 
                                    class="btn btn-danger d-flex align-items-center justify-content-center delete-btn" 
                                    style="width: 40px; height: 40px;">
                                <i class='bx bxs-trash-alt'></i>
                            </button>
                        </form>
                    </div>`
                        ]).draw(false);
                    }

                    if (successSound) playSound(successSound);

                    showSwal({
                        icon: 'success',
                        title: 'Presensi Berhasil',
                        text: 'Data presensi kamu sudah tersimpan',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#198754'
                    }).then(() => {
                        resultText.className = "mt-3 text-muted small fst-italic";
                        resultText.innerText = "Arahkan QR ke kamera untuk melakukan scan.";
                    });
                })
                .catch(err => {
                    console.error("Catch Error:", err.message);
                    if (!scannerState.isErrorShown) {
                        scannerState.isErrorShown = true;
                        showSwal({
                            icon: "error",
                            title: "Kesalahan Jaringan",
                            text: "Tidak bisa terhubung ke server.",
                            confirmButtonColor: "#dc3545"
                        }).then(() => scannerState.isErrorShown = false);

                        resultText.className = "mt-3 text-danger small fst-italic";
                        resultText.innerText = "Terjadi kesalahan jaringan.";
                    }
                });
        }, DEBOUNCE_TIME);
    }


    // Fungsi untuk mengurangi error spam dan meningkatkan performa
    function onScanFailure(error) {
        // Hanya log error penting, abaikan error scanning normal
        if (!error.includes("No MultiFormat Readers") &&
            !error.includes("not found") &&
            !error.includes("NotFoundException")) {
            console.debug("QR Scan:", error);
        }
    }

    startBtn.addEventListener("click", () => {
        const waktuMulaiInput = document.getElementById("waktu_mulai").value;
        const batasTelatInput = document.getElementById("batas_telat").value;

        if (!waktuMulaiInput || !batasTelatInput) {
            Swal.fire({
                icon: "warning",
                title: "Data belum lengkap",
                text: "Isi waktu mulai dan toleransi terlebih dahulu."
            });
            return;
        }

        waktuMulai = waktuMulaiInput;
        batasTelat = parseInt(batasTelatInput);

        // Disable input saat scan berjalan
        document.getElementById("waktu_mulai").disabled = true;
        document.getElementById("batas_telat").disabled = true;

        // Mulai scanner seperti biasa
        if (scannerState.isScanning) return;
        scannerState.isErrorShown = false;
        resultText.innerText = "Scanning...";
        resultText.className = "mt-3 text-muted small fst-italic";

        Html5Qrcode.getCameras()
            .then(devices => {
                if (devices.length === 0) {
                    alert("Kamera tidak tersedia.");
                    return;
                }

                // Ambil kamera pertama (default webcam laptop/PC)
                const cameraId = devices[0].id;

                const settings = getOptimalCameraSettings();

                html5QrCode.start(cameraId, settings, onScanSuccess, onScanFailure)
                    .then(() => {
                        scannerState.isScanning = true;
                        startBtn.disabled = true;
                        stopBtn.disabled = false;
                        startLoadingAnimation();
                    })
                    .catch(err => {
                        console.error("Start error:", err);
                        alert("Gagal memulai kamera.");
                        // Re-enable inputs jika gagal
                        document.getElementById("waktu_mulai").disabled = false;
                        document.getElementById("batas_telat").disabled = false;
                    });
            })
            .catch(err => {
                console.error("Camera error:", err);
                alert("Kamera tidak ditemukan.");
                // Re-enable inputs jika gagal
                document.getElementById("waktu_mulai").disabled = false;
                document.getElementById("batas_telat").disabled = false;
            });

    });

    stopBtn.addEventListener("click", () => {
        if (!scannerState.isScanning) return;

        html5QrCode.stop().then(() => {
            scannerState.isScanning = false;
            startBtn.disabled = false;
            stopBtn.disabled = true;
            stopLoadingAnimation();
            resultText.innerText = "Scan dihentikan";
            resultText.className = "mt-3 text-warning small fst-italic";

            // Re-enable inputs
            document.getElementById("waktu_mulai").disabled = false;
            document.getElementById("batas_telat").disabled = false;

            location.reload();
        }).catch(err => {
            console.error("Stop error:", err);
        });
    });

    function getOptimalCameraSettings() {
        return {
            fps: 25,
            qrbox: {
                width: 250,
                height: 300
            },
            aspectRatio: 1.777,
            videoConstraints: {
                width: {
                    ideal: 640
                },
                height: {
                    ideal: 480
                },
                facingMode: "user"
            },
            experimentalFeatures: {
                useBarCodeDetectorIfSupported: true
            }
        };
    }



    function startLoadingAnimation() {
        const dots = ["", ".", "..", "..."];
        let i = 0;

        if (scannerState.loadingInterval) clearInterval(scannerState.loadingInterval);
        scannerState.loadingInterval = setInterval(() => {
            setResultText("Scanning" + dots[i % dots.length], "loading");
            i++;
        }, 300); // Kurangi dari 500ms
    }


    function stopLoadingAnimation() {
        if (scannerState.loadingInterval) clearInterval(scannerState.loadingInterval);
        scannerState.loadingInterval = null;
        setResultText("");
    }

    // Cleanup saat page akan ditutup
    window.addEventListener('beforeunload', () => {
        if (scannerState.isScanning && html5QrCode) {
            html5QrCode.stop().catch(console.error);
        }
        stopLoadingAnimation();
    });

    function setResultText(message, type = "default") {
        resultText.className = ""; // reset semua class

        switch (type) {
            case "success":
                resultText.classList.add("text-success", "fw-bold");
                break;
            case "error":
                resultText.classList.add("text-danger", "fw-bold");
                break;
            case "loading":
                resultText.classList.add("text-muted", "fst-italic");
                break;
            default:
                resultText.classList.add("text-dark");
        }

        resultText.innerText = message;
    }
</script>
