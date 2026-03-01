<x-Dashboard.main-layout title="{{ $title }}">
    <div class="row g-4">
        <div class="col-12">
            <div class="mb-4">
                <h2 class="mb-2 text-center">Member Data</h2>

                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary mb-3 btn-add-member" data-bs-toggle="modal"
                    data-bs-target="#modal-action">
                    Create New Member
                </button>
                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NPM</th>
                            <th>Divisi</th>
                            <th>Jabatan</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto"
                                            class="rounded-circle"
                                            style="width: 40px; height: 40px; object-fit: cover;">
                                        <div>
                                            <h6 class="mb-0 fw-bold">{{ $item->nama }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">{{ $item->npm }}</td>
                                <td>{{ $item->division?->nama_divisi ?? 'Tidak Ada Divisi' }}</td>
                                <td>{{ $item->jabatan }}</td>
                                <td>
                                    <span class="badge {{ $item->status == 'aktif' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center flex-wrap gap-2">
                                        <!-- Tombol Lihat -->
                                        <a href="/dashboard/dataMemberSections/{{ $item->id }}"
                                            class="btn btn-info d-flex ">
                                            <i class='bx bx-show'></i>
                                        </a>
                                        <button type="button" class="btn btn-success btn-edit-member d-flex"
                                            data-bs-toggle="modal" data-bs-target="#modal-action"
                                            data-id="{{ $item->id }}">
                                            <i class='bx bxs-edit'></i>
                                        </button>
                                        <form action="/dashboard/dataMemberSections/{{ $item->id }}"
                                            method="POST">
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="px-4">
                        <form id="memberForm" action="/dashboard/dataMemberSections" class="authentication-form"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="member_id" name="id"> <!-- Untuk edit -->

                            <div class="row">
                                <div class="col-md-6">

                                    <div class="mb-3">
                                        <label class="form-label" for="nama">Nama</label>
                                        <input type="text" id="nama" name="nama"
                                            class="form-control @error('nama') is-invalid @enderror"
                                            placeholder="Enter your nama" autocomplete="off" required>
                                        @error('nama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="npm">NPM</label>
                                        <input type="number" id="npm" name="npm"
                                            class="form-control @error('npm') is-invalid @enderror"
                                            placeholder="Enter your npm" autocomplete="off" required>
                                        @error('npm')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <label for="foto" class="form-label">Foto</label>
                                    <div class="mb-3">
                                        <!-- Preview Image -->
                                        <p class="text-info fs-6">Ukuran Image ("Tinggi : 528px - Lebar : 470px")</p>
                                        <img class="img-preview img-fluid rounded border mb-3"
                                            style="max-width: 250px; height: auto; display: none;">
                                        <p class="file-size"></p>
                                        <p class="text-danger fs-6">Maximal Size 1 Mb !! </p>
                                        <input type="file" id="foto" name="foto"
                                            class="form-control @error('foto') is-invalid @enderror"
                                            onchange="previewImage()">

                                        @error('foto')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="mb-3">
                                        <label class="form-label" for="link_ig">Link IG</label>
                                        <input type="text" id="link_ig" name="link_ig"
                                            class="form-control @error('link_ig') is-invalid @enderror"
                                            placeholder="Enter your link_ig" autocomplete="off" required>
                                        @error('link_ig')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="division_id" class="form-label">Divisi</label>

                                        @if (Auth::user()->level_pengguna === 'Super Admin')
                                            {{-- Super Admin bisa pilih semua divisi --}}
                                            <select class="form-control @error('division_id') is-invalid @enderror"
                                                id="division_id" name="division_id" required>
                                                <option value="">Pilih Divisi</option>
                                                @foreach ($divisions as $division)
                                                    <option value="{{ $division->id }}"
                                                        {{ old('division_id') == $division->id ? 'selected' : '' }}>
                                                        {{ $division->nama_divisi }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @else
                                            {{-- Admin hanya bisa lihat divisi miliknya (readonly) --}}
                                            <input type="text" class="form-control"
                                                value="{{ Auth::user()->divisi->nama_divisi ?? '-' }}" readonly>
                                            <input type="hidden" name="division_id"
                                                value="{{ Auth::user()->divisi_id }}">
                                        @endif

                                        @error('division_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mb-3">
                                        <label for="jabatan" class="form-label">Jabatan</label>
                                        <select
                                            class="form-control @error('jabatan')
                                            is-invalid
                                        @enderror"
                                            id="jabatan" name="jabatan" required>
                                            <option value="">Select Jabatan</option>
                                            <option value="KETUA">
                                                KETUA</option>
                                            <option value="WAKIL KETUA">WAKIL KETUA
                                            </option>
                                            <option value="KETUA DIVISI">KETUA DIVISI
                                            </option>
                                            <option value="BENDAHARA">
                                                BENDAHARA
                                            </option>
                                            <option value="SEKRETARIS">
                                                SEKRETARIS
                                            </option>
                                            <option value="ANGGOTA">
                                                ANGGOTA
                                            </option>
                                        </select>
                                        @error('jabatan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select
                                    class="form-control @error('status')
                                    is-invalid
                                @enderror"
                                    id="status" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="aktif">
                                        Aktif</option>
                                    <option value="tidak aktif">Tidak Aktif
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" id="submitButton" class="btn btn-primary">Create Member Data
                                </button>
                            </div>

                        </form>

                    </div> <!-- end col -->
                </div>

            </div>
        </div>
    </div>
</x-Dashboard.main-layout>

<script>
    $(document).ready(function() {
        const userForm = $("#memberForm");
        const modalAction = $("#modal-action");
        const modalTitle = $("#modalTitle");
        const submitButton = $("#submitButton");

        const formError = @json(session('form_error', false));
        const formInput = @json(session('form_input', []));

        if (formError) {
            $('#modal-action').modal('show');

            // Isi ulang value input form
            for (const key in formInput) {
                const $input = $(`#modal-action [name="${key}"]`);

                if ($input.length) {
                    $input.val(formInput[key]);
                }
            }

            if (formInput.foto_temp_path) {
                $('.img-preview')
                    .attr('src', `/storage/${formInput.foto_temp_path}`)
                    .css('display', 'block');
            }

        }

        // Reset modal saat ditutup
        $('#modal-action').on('hidden.bs.modal', function() {
            const $form = $(this).find('form')[0];
            $form.reset(); // Reset form

            $(this).find('.is-invalid').removeClass('is-invalid');
            $(this).find('.invalid-feedback').text('');
            $('.img-preview').hide().attr('src', '');
        });

        $(".btn-add-member").click(function() {
            modalTitle.text("Add Member");
            submitButton.text("Create Data Member");

            userForm[0].reset();
            $("#member_id").val("");
            userForm.find('input[name="_method"]').remove();
            userForm.attr("action", "/dashboard/dataMemberSections").attr("method", "POST");

            // Reset image preview
            $(".img-preview").hide();

            modalAction.modal("show");
        });

        $(".btn-edit-member").click(function() {
            let memberID = $(this).data("id");

            modalTitle.text("Edit Member");
            submitButton.text("Update Member Data");

            userForm.attr("action", "/dashboard/dataMemberSections/" + memberID);

            if (!$('#memberForm input[name="_method"]').length) {
                $("#memberForm").append('<input type="hidden" name="_method" value="PUT">');
            }

            $.ajax({
                url: `/dashboard/dataMemberSections/${memberID}/edit`,
                type: "GET",
                success: function(data) {
                    $("#member_id").val(data.id);
                    $("#nama").val(data.nama);
                    $("#npm").val(data.npm);
                    $("#division_id").val(data.division_id);
                    $("#jabatan").val(data.jabatan);
                    $("#link_ig").val(data.link_ig);
                    $("#status").val(data.status);

                    // Handle image preview
                    if (data.foto) {
                        $(".img-preview")
                            .attr("src", "/storage/" + data.foto)
                            .show();
                    } else {
                        $(".img-preview").hide();
                    }

                    modalAction.modal("show");
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                },
            });
        });
    });


    function previewImage() {
        const input = document.querySelector("#foto");
        const imgPreview = document.querySelector(".img-preview");
        const fileSizeText = document.querySelector(".file-size"); // Elemen untuk ukuran file

        if (input.files && input.files[0]) {
            const file = input.files[0];
            const validExtensions = ["image/jpeg", "image/png", "image/jpg"];

            if (!validExtensions.includes(file.type)) {
                alert("Hanya file gambar yang diperbolehkan (JPEG, PNG, JPG).");
                input.value = "";
                imgPreview.style.display = "none";
                fileSizeText.textContent = ""; // Reset ukuran file
                return;
            }

            // Hitung dan tampilkan ukuran file dengan satuan yang sesuai
            const fileSizeInKB = file.size / 1024;
            if (fileSizeInKB >= 1000) {
                const fileSizeInMB = (fileSizeInKB / 1024).toFixed(2);
                fileSizeText.textContent = `Ukuran file: ${fileSizeInMB} MB`;
            } else {
                fileSizeText.textContent = `Ukuran file: ${Math.round(fileSizeInKB)} KB`;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                imgPreview.src = e.target.result;
                imgPreview.style.display = "block";
            };
            reader.readAsDataURL(file);
        } else {
            // Jika tidak ada file baru, tampilkan gambar lama (jika ada)
            const oldImage = imgPreview.getAttribute("data-old-src");
            if (oldImage) {
                imgPreview.src = oldImage;
                imgPreview.style.display = "block";
                fileSizeText.textContent = "";
            }
        }
    }
</script>
