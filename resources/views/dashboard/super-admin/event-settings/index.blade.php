<x-Dashboard.main-layout title="{{ $title }}">
    <div class="row g-4">
        <div class="col-12">
            <div class="mb-4">
                <h2 class="mb-2 text-center">Work Programs</h2>
                <div class="d-flex gap-2 flex-wrap mb-3">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary mb-3 btn-add-event" data-bs-toggle="modal"
                        data-bs-target="#modal-action">
                        Create New Event
                    </button>

                    @if (Auth::user()->level_pengguna === 'Super Admin')
                        <form action="{{ route('events.deleteAll') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger delete-all-btn">
                                <i class="bx bx-trash"></i> Delete All
                            </button>
                        </form>
                    @else
                        <form action="{{ route('events.deleteOwnEvent') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger delete-all-btn">
                                <i class="bx bx-trash"></i> Delete All
                            </button>
                        </form>
                    @endif
                </div>
                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Ketua Pelaksana</th>
                            <th>Tanggal Pelaksanaan</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($events as $event)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $event->judul }}</td>
                                <td>{{ $event->ketuaPelaksana?->nama ?? 'Tidak ada ketua pelaksana!' }}</td>
                                <td>{{ $event->tgl_pelaksanaan }}</td>
                                <td>
                                    <span
                                        class="badge 
                                        {{ $event->status == 'pending' ? 'bg-danger' : ($event->status == 'ongoing' ? 'bg-warning' : 'bg-success') }}">
                                        {{ ucfirst($event->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center flex-wrap gap-2">
                                        <!-- Tombol Lihat -->
                                        <a href="/dashboard/event/{{ $event->judul }}" class="btn btn-info d-flex ">
                                            <i class='bx bx-show'></i>
                                        </a>
                                        <button type="button" class="btn btn-success btn-edit-event d-flex"
                                            data-bs-toggle="modal" data-bs-target="#modal-action"
                                            data-id="{{ $event->judul }}">
                                            <i class='bx bxs-edit'></i>
                                        </button>
                                        <form action="/dashboard/event/{{ $event->judul }}" method="POST">
                                            @method('delete')
                                            @csrf
                                            <button type="button" class="btn btn-danger d-flex delete-btn">
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
                    <h5 class="modal-title" id="modalTitle">Add Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="px-4">
                        <form id="eventForm" action="/dashboard/event" class="authentication-form" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="event_id" name="id"> <!-- Untuk edit -->

                            <div class="row">
                                <div class="col-md-6">

                                    <div class="mb-3">
                                        <label class="form-label" for="judul">Judul</label>
                                        <input type="text" id="judul" name="judul"
                                            class="form-control @error('judul') is-invalid @enderror"
                                            placeholder="Masukan judul" autocomplete="off" required>
                                        @error('judul')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="ketua_pelaksana_id" class="form-label">Ketua Pelaksana</label>
                                        <select class="form-control @error('ketua_pelaksana_id') is-invalid @enderror"
                                            name="ketua_pelaksana_id" id="ketua_pelaksana_id" required>
                                            <option value="">Pilih Ketua Pelaksana</option>
                                            @foreach ($dataMembers as $member)
                                                <option value="{{ $member->id }}">
                                                    {{ $member->nama }} - {{ $member->division->nama_divisi }}
                                                </option>
                                            @endforeach
                                        </select>

                                        {{-- error bawaan validator --}}
                                        @error('ketua_pelaksana_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                        {{-- custom error message kalau mau pakai js --}}
                                        <div id="error-message" style="display: none;"
                                            class="alert alert-danger alert-icon mb-0" role="alert">
                                        </div>
                                    </div>


                                    <div class="mb-3">
                                        <label for="division_id" class="form-label">Divisi</label>

                                        @if (Auth::user()->level_pengguna === 'Super Admin')
                                            {{-- Super Admin bisa pilih divisi --}}
                                            <select class="form-control @error('division_id') is-invalid @enderror"
                                                id="division_id" name="division_id" required>
                                                <option value="">Select Divisi</option>
                                                @foreach ($divisions as $division)
                                                    <option value="{{ $division->id }}"
                                                        {{ old('division_id') == $division->id ? 'selected' : '' }}>
                                                        {{ $division->nama_divisi }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @else
                                            {{-- Admin: divisi otomatis dari user, readonly --}}
                                            <input type="text" class="form-control"
                                                value="{{ Auth::user()->divisi->nama_divisi }}" readonly>

                                            {{-- hidden supaya tetap terkirim ke backend --}}
                                            <input type="hidden" name="division_id"
                                                value="{{ Auth::user()->divisi_id }}">
                                        @endif

                                        @error('division_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <!-- Foto Section -->
                                    <label for="foto" class="form-label">Image</label>
                                    <div class="mb-3">
                                        <p class="text-info fs-6">Ukuran Image ("Tinggi : 450px - Lebar : 465px")
                                        </p>
                                        <!-- Preview Image -->
                                        <img id="foto-preview" class="img-preview img-fluid rounded border mb-3"
                                            style="max-width: 250px; height: auto; display: none;">
                                        <p id="foto-preview-size-info" class="text-muted fs-6"></p>
                                        <p class="text-warning fs-6">Maximal Size 1 Mb !! </p>
                                        <input type="file" id="foto" name="foto"
                                            class="form-control @error('foto') is-invalid @enderror"
                                            onchange="previewImage(event)" data-preview="foto-preview">

                                        @error('foto')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="mb-3">
                                        <label for="category" class="form-label">Event Category</label>
                                        <select
                                            class="form-control @error('category')
                                            is-invalid
                                        @enderror"
                                            id="category" name="category" required>
                                            <option value="">Select Category</option>
                                            <option value="Small Event">
                                                Small Event</option>
                                            <option value="Normal Event">
                                                Normal Event
                                            </option>
                                            <option value="Big Event">
                                                Big Event
                                            </option>
                                        </select>
                                        @error('divisi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="tgl_pelaksanaan">Tanggal
                                            Pelaksanaan</label>
                                        <input type="date" id="tgl_pelaksanaan" name="tgl_pelaksanaan"
                                            class="form-control @error('tgl_pelaksanaan') is-invalid @enderror"
                                            placeholder="Enter tgl_pelaksanaan" required>
                                        @error('tgl_pelaksanaan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Background Image Section -->
                                    <label for="background_image" class="form-label">Background Image</label>
                                    <div class="mb-3">
                                        <p class="text-info fs-6">Ukuran Image ("Tinggi : 550px - Lebar : 1170px")
                                        </p>
                                        <!-- Preview Background Image -->
                                        <img id="background_image-preview" class="img-fluid rounded border mb-3"
                                            style="max-width: 250px; height: auto; display: none;"
                                            data-old-src="{{ isset($post) ? asset('storage/' . $post->background_image) : '' }}">
                                        <p id="background_image-preview-size-info" class="text-muted fs-6"></p>
                                        <p class="text-warning fs-6">Maximal Size 1 Mb !! </p>
                                        <input type="file" id="background_image" name="background_image"
                                            class="form-control @error('background_image') is-invalid @enderror"
                                            onchange="previewImage(event)" data-preview="background_image-preview">

                                        @error('background_image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status Event</label>
                                <select
                                    class="form-control @error('status')
                                    is-invalid
                                @enderror"
                                    id="status" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="pending">
                                        pending</option>
                                    <option value="ongoing">ongoing
                                    </option>
                                    <option value="completed">
                                        completed
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <!-- Quill Editors -->
                                <label class="form-label" for="deskripsi">Deskripsi</label>
                                @error('deskripsi')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                <div id="snow-editor" style="height: 300px;"></div>
                                <input type="hidden" name="deskripsi" id="deskripsi" required>
                            </div>



                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" id="submitButton" class="btn btn-primary">Create New Event
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
    // Tambahkan event listener untuk tombol submit
    document.getElementById('submitButton').addEventListener('click', function(event) {
        var selectElement = document.getElementById('ketua_pelaksana_id');
        var errorMessage = document.getElementById('error-message');
        var selectContainer = selectElement.closest('.mb-3'); // Ambil container dari select

        // Reset pesan kesalahan
        errorMessage.style.display = 'none';

        if (selectElement.value === "") {
            event.preventDefault(); // Mencegah pengiriman form
            errorMessage.style.display = 'block'; // Tampilkan pesan kesalahan
            errorMessage.textContent = 'Silakan pilih Ketua Pelaksana !!';

            // Coba scroll ke container dari select, bukan elemen select itu sendiri
            selectContainer.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });

            // Tunggu animasi scroll selesai baru fokus
            setTimeout(function() {
                // Coba fokus ke elemen Choices.js jika ada
                var choicesInput = selectContainer.querySelector('.choices__input');
                if (choicesInput) {
                    choicesInput.focus();
                } else {
                    selectElement.focus();
                }
            }, 500); // Tunggu 500ms untuk animasi scroll
        }
    });

    // Tambahkan event listener untuk select ketua_pelaksana_id
    document.getElementById('ketua_pelaksana_id').addEventListener('change', function() {
        var errorMessage = document.getElementById('error-message');

        // Jika user sudah memilih value (tidak kosong)
        if (this.value !== "") {
            // Sembunyikan pesan error
            errorMessage.style.display = 'none';
        }
    });

    document.addEventListener("DOMContentLoaded", function() {

        // Ambil instance Quill yang sudah diinisialisasi di template
        var quillContainer = document.querySelector("#snow-editor");

        if (quillContainer) {
            // Dapatkan instance Quill yang sudah ada
            var quill = Quill.find(quillContainer);

            if (quill) {
                var form = document.querySelector("#eventForm");
                var bodyInput = document.querySelector("#deskripsi");

                // Set nilai awal jika ada (untuk edit mode)
                if (bodyInput) {
                    bodyInput.value = `{!! old('deskripsi') !!}`;
                    if (bodyInput.value) {
                        quill.root.innerHTML = bodyInput.value;
                    }

                    // Update input hidden setiap kali ada perubahan di Quill
                    quill.on("text-change", function() {
                        bodyInput.value = quill.root.innerHTML;
                    });
                }

                // Blok paste & drop gambar
                quill.getModule('clipboard').addMatcher(Node.ELEMENT_NODE, function(node, delta) {
                    delta.ops = delta.ops.filter(function(op) {
                        return !(op.insert && op.insert.image);
                    });
                    return delta;
                });

                quill.root.addEventListener("drop", function(e) {
                    e.preventDefault();
                });

                quill.root.addEventListener("paste", function(e) {
                    const items = (e.clipboardData || e.originalEvent.clipboardData).items;
                    for (const item of items) {
                        if (item.type.indexOf("image") !== -1) {
                            e.preventDefault();
                            break;
                        }
                    }
                });

                // Validasi form sebelum submit
                if (form) {
                    form.addEventListener("submit", function(event) {
                        if (bodyInput) {
                            bodyInput.value = quill.root.innerHTML;
                            if (bodyInput.value.trim() === "") {
                                event.preventDefault();
                                alert("Konten tidak boleh kosong!");
                            }
                        }
                    });
                }
            }
        }
    });

    const formError = @json(session('form_error'));
    const formInput = @json(session('form_input'));

    $(document).ready(function() {
        const choicesKetuaPelaksana = new Choices('#ketua_pelaksana_id', {
            shouldSort: false,
            placeholder: true,
            placeholderValue: 'Pilih Ketua Pelaksana',
        });

        const userForm = $("#eventForm");
        const modalAction = $("#modal-action");
        const modalTitle = $("#modalTitle");
        const submitButton = $("#submitButton");

        if (formError) {
            $('#modal-action').modal('show');

            // Isi ulang value input form
            for (const key in formInput) {
                const $input = $(`#modal-action [name="${key}"]`);

                if ($input.length) {
                    $input.val(formInput[key]);
                }


                if (formInput.foto_temp_path) {
                    $('#foto-preview')
                        .attr('src', `/storage/${formInput.foto_temp_path}`)
                        .css('display', 'block');
                }

                if (formInput.background_image_temp_path) {
                    $('#background_image-preview')
                        .attr('src', `/storage/${formInput.background_image_temp_path}`)
                        .css('display', 'block');
                }
            }
        }

        $(".delete-all-btn").on("click", function(event) {
            event.preventDefault();

            const form = $(this).closest("form");

            Swal.fire({
                title: "Yakin ingin menghapus semua data?",
                text: "Semua data dan gambar akan dihapus permanen!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, hapus semua!",
                cancelButtonText: "Batal",
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        // Reset modal saat ditutup
        $('#modal-action').on('hidden.bs.modal', function() {
            const $form = $(this).find('form')[0];
            $form.reset(); // Reset form

            $(this).find('.is-invalid').removeClass('is-invalid');
            $(this).find('.invalid-feedback').text('');

            $('#foto-preview').hide().attr('src', '');
            $('#background_image-preview').hide().attr('src', '');
        });


        $(document).on("click", ".btn-add-event", function() {
            modalTitle.text("Add event");
            submitButton.text("Create event");

            userForm[0].reset();
            $("#event_id").val("");
            userForm.find("input[name='_method']").remove();

            userForm.attr("action", "/dashboard/event").attr("method", "POST");

            // Reset Quill editor yang sudah ada di template
            var quillEditor = Quill.find(document.querySelector("#snow-editor"));
            if (quillEditor) {
                quillEditor.root.innerHTML = '';
                $("#deskripsi").val('');
            }

            // Reset image preview
            $(".img-preview").hide();
            $("#background_image-preview").hide();

            modalAction.modal("show");
        });

        $(document).on("click", ".btn-edit-event", function() {
            let eventId = $(this).data("id");


            modalTitle.text("Edit event");
            submitButton.text("Update event");

            userForm.attr("action", "/dashboard/event/" + eventId);
            userForm.find("input[name='_method']").remove();
            userForm.append('<input type="hidden" name="_method" value="PUT">');

            $.ajax({
                url: `/dashboard/event/${eventId}/edit`,
                type: "GET",
                success: function(data) {
                    $("#event_id").val(data.id);
                    $("#judul").val(data.judul);
                    $("#deskripsi").val(data.deskripsi);
                    $("#division_id").val(data.division_id);
                    $("#tgl_pelaksanaan").val(data.tgl_pelaksanaan);
                    $("#category").val(data.category);
                    $("#status").val(data.status);

                    choicesKetuaPelaksana.setChoiceByValue(data.ketua_pelaksana_id
                        .toString());


                    // Set Quill editor content dengan instance yang sudah ada di template
                    var quillEditor = Quill.find(document.querySelector("#snow-editor"));
                    if (quillEditor && data.deskripsi) {
                        quillEditor.root.innerHTML = data.deskripsi;
                        $("#deskripsi").val(data.deskripsi);
                    }

                    // Handle image preview
                    if (data.foto) {
                        $(".img-preview")
                            .attr("src", "/storage/" + data.foto)
                            .show();
                    }
                    if (data.background_image) {
                        $("#background_image-preview")
                            .attr("src", "/storage/" + data.background_image)
                            .show();
                    } else {
                        $("#background_image-preview").hide();
                    }

                    modalAction.modal("show");
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                },
            });
        });
    });

    function previewImage(event) {
        const input = event.target;
        const imgPreviewId = input.getAttribute("data-preview"); // Ambil ID dari atribut data-preview
        const imgPreview = document.getElementById(imgPreviewId);
        const sizeInfoId = imgPreviewId + "-size-info";
        let sizeInfo = document.getElementById(sizeInfoId);

        // Jika elemen ukuran belum ada, buat elemen baru
        if (!sizeInfo) {
            sizeInfo = document.createElement("p");
            sizeInfo.id = sizeInfoId;
            sizeInfo.className = "text-muted fs-6";
            imgPreview.parentNode.appendChild(sizeInfo);
        }

        if (input.files && input.files[0]) {
            const file = input.files[0];
            const validExtensions = ["image/jpeg", "image/png", "image/jpg"];

            if (!validExtensions.includes(file.type)) {
                alert("Hanya file gambar yang diperbolehkan (JPEG, PNG, JPG).");
                input.value = "";
                imgPreview.style.display = "none";
                sizeInfo.textContent = "";
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                imgPreview.src = e.target.result;
                imgPreview.style.display = "block";
            };
            reader.readAsDataURL(file);

            // Menampilkan ukuran file dalam KB atau MB
            const fileSize = (file.size / 1024).toFixed(2); // Konversi ke KB
            sizeInfo.textContent =
                `Ukuran File: ${fileSize > 1024 ? (fileSize / 1024).toFixed(2) + ' MB' : fileSize + ' KB'}`;
        } else {
            const oldImage = imgPreview.getAttribute("data-old-src");
            if (oldImage) {
                imgPreview.src = oldImage;
                imgPreview.style.display = "block";
                sizeInfo.textContent = ""; // Kosongkan ukuran jika menggunakan gambar lama
            } else {
                imgPreview.style.display = "none";
                sizeInfo.textContent = "";
            }
        }
    }
</script>
