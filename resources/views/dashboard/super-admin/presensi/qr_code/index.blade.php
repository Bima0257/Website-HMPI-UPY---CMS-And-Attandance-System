<x-Dashboard.main-layout title="{{ $title }}">
    <div class="row g-4">
        <div class="col-12">
            <div class="mb-4">
                <h2 class="mb-2 text-center mb-5">Data Qr Code Members</h2>
                <div class="d-flex gap-2 flex-wrap mb-3">
                    <!-- Create QR Code Button -->
                    <button type="button" class="btn btn-primary btn-add-qrCode" data-bs-toggle="modal"
                        data-bs-target="#modal-action">
                        <i class="bx bx-plus"></i> Create New QR Code
                    </button>

                    <!-- Download All QR Codes Button -->
                    <a href="{{ route('qrcodes.downloadAll') }}" class="btn btn-success" id="downloadAllBtn">
                        <i class="bx bx-download"></i> Download All QR Codes
                    </a>

                    <form id="delete-all-form" action="{{ route('qrcodes.deleteAll') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger delete-all-btn">
                            <i class="bx bx-trash"></i> Delete All
                        </button>
                    </form>
                </div>


                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Qr Code</th>
                            <th>Divisi</th>
                            <th>Jabatan</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ asset('storage/' . $item->qr_image) }}" alt="Foto"
                                            style="width: 40px; height: 40px; object-fit: cover;">
                                        <div>
                                            <h6 class="mb-0 fw-bold">{{ $item->nama }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">{{ $item->qr_data }}</td>
                                <td>{{ $item->divisi ?? 'Tidak Ada Divisi' }}</td>
                                <td>{{ $item->jabatan }}</td>
                                <td>
                                    <div class="d-flex align-items-center flex-wrap gap-2">
                                        <!-- Tombol Download QR Code -->
                                        <a href="{{ asset('storage/' . $item->qr_image) }}"
                                            data-filename="QR_{{ Str::slug($item->nama) }}.png"
                                            class="btn btn-primary d-flex align-items-center justify-content-center downloadQrCode"
                                            title="Download QR Code">
                                            <i class="bx bx-download"></i>
                                        </a>


                                        <form action="/dashboard/qrcodes/{{ $item->id }}" method="POST">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="btn btn-danger d-flex delete-btn ">
                                                <i class='bx bxs-trash-alt'></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div> <!-- end card -->
        </div><!-- end col-->
    </div> <!-- end row-->

    <!-- Modal -->
    <div class="modal fade" id="modal-action" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add QR Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="px-4">
                        <form id="singleQrCode" action="/dashboard/qrcodes" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="member_id" class="form-label">Pilih Member</label>
                                <select name="member_id" id="member_id" class="form-select">
                                    <option value="">-- Pilih Member --</option>
                                    @foreach ($member as $data)
                                        <option value="{{ $data->id }}">{{ $data->nama }} -
                                            {{ $data->divisi }}</option>
                                    @endforeach
                                </select>
                                <div id="memberError" class="invalid-feedback" style="display:none;"></div>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Generate Selected Member</button>
                        </form>

                        <hr>

                        <form action="{{ route('qrcodes.generate-all') }}" method="POST" id="all-generate-form">
                            @csrf
                            <button type="submit" class="btn btn-warning w-100">Generate All Members</button>
                        </form>

                    </div> <!-- end col -->
                </div>

            </div>
        </div>
    </div>
</x-Dashboard.main-layout>

<script>
    function clearValidation() {
    $("#member_id").removeClass("is-invalid");
    $("#memberError").hide().text("");
}

$(document).ready(function () {
    // Inisialisasi Choices.js pada elemen select member_id
    const memberSelect = new Choices("#member_id", {
        searchEnabled: true,
        searchPlaceholderValue: "Cari member...",
        placeholderValue: "-- Pilih Member --",
        removeItemButton: true,
        itemSelectText: "Klik untuk memilih",
        noResultsText: "Tidak ada hasil yang ditemukan",
        noChoicesText: "Tidak ada pilihan yang tersedia",
        shouldSort: true,
        renderChoiceLimit: -1,
    });

    // Optional: Reset choices ketika modal ditutup
    $("#modal-action").on("hidden.bs.modal", function () {
        memberSelect.removeActiveItems();
        memberSelect.setChoiceByValue("");
    });

    $("#all-generate-form").on("submit", function (e) {
        e.preventDefault(); // Mencegah form disubmit langsung

        Swal.fire({
            title: "Are you sure?",
            text: "Do you want to generate QR codes for all members?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, generate!",
            cancelButtonText: "Cancel",
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Generating...",
                    text: "Please wait while we generate the QR codes for all members.",
                    icon: "info",
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    willOpen: () => {
                        Swal.showLoading();
                    },
                });

                $.ajax({
                    url: $(this).attr("action"),
                    type: "POST",
                    data: $(this).serialize(),
                    success: function (response) {
                        // Menangani jika QR sudah semua dibuat atau berhasil dibuat
                        Swal.fire({
                            title: response.success ? "Success!" : "Info",
                            text: response.message,
                            icon: response.success ? "success" : "info",
                            confirmButtonText: "Ok",
                        }).then(() => {
                            if (response.redirectUrl) {
                                window.location.href = response.redirectUrl;
                            }
                        });
                    },
                    error: function (xhr) {
                        let errorMessage =
                            xhr.responseJSON?.message ||
                            "Something went wrong while generating the QR codes.";
                        Swal.fire({
                            title: "Error!",
                            text: errorMessage,
                            icon: "error",
                            confirmButtonText: "Ok",
                        });
                    },
                });
            }
        });
    });

    $("#singleQrCode").on("submit", function (e) {
        e.preventDefault(); // Hentikan submit default

        const selectedMember = memberSelect.getValue(true);

        if (!selectedMember) {
            $("#member_id").addClass("is-invalid");
            $("#memberError")
                .text("Harap pilih member terlebih dahulu!")
                .show();
            return false;
        } else {
            clearValidation();

            // Tampilkan loading
            Swal.fire({
                title: "Sedang diproses...",
                text: "Mohon tunggu sebentar",
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                },
            });

            // Submit form setelah delay singkat (cukup untuk menampilkan loading)
            setTimeout(() => {
                $("#singleQrCode")[0].submit();
            }, 100);
        }
    });

    $("#member_id").on("change", function () {
        if ($(this).val()) {
            // Jika ada pilihan member, hapus class is-invalid
            $(this).removeClass("is-invalid");
            $("#memberError").hide();
        }
    });

    $(".delete-all-btn").on("click", function (event) {
        event.preventDefault();

        Swal.fire({
            title: "Yakin ingin menghapus semua QR Code?",
            text: "Semua data dan gambar QR Code akan dihapus permanen!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, hapus semua!",
            cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {
                $("#delete-all-form").submit();
            }
        });
    });

    $("#downloadAllBtn").on("click", function (e) {
        e.preventDefault(); // Hentikan default link action

        // SweetAlert konfirmasi
        Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Ingin mengunduh semua QR Code?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, unduh!",
            cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika user memilih 'Ya, unduh!', arahkan ke link download
                window.location.href = $(this).attr("href");
            }
        });
    });

    $(".downloadQrCode").on("click", function (e) {
        e.preventDefault(); // Hentikan aksi default

        Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Ingin mengunduh QR Code ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, unduh!",
            cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {
                var downloadUrl = $(this).attr("href");
                var fileName = $(this).data("filename");

                var link = document.createElement("a");
                link.href = downloadUrl;
                link.download = fileName;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        });
    });
});

</script>