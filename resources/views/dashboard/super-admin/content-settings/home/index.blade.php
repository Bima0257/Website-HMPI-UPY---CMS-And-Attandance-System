<x-Dashboard.main-layout title="{{ $title }}">
    <div class="row g-4">
        <div class="col-12">
            <div class="mb-4">
                <h2 class="mb-2 text-center">Home Carousel</h2>

                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary mb-3 btn-add-content" data-bs-toggle="modal"
                    data-bs-target="#modal-action">
                    Create New Content
                </button>
                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Subtitle</th>
                            <th>Background Image</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($carousels as $carousel)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $carousel->title }}</td>
                                <td>{{ $carousel->subtitle }}</td>
                                <td><img src="{{ asset('storage/' . $carousel->background_image) }}" alt="about-img"
                                        width="100" height="60" style="object-fit: cover; border-radius: 5px;">
                                </td>
                                <td>
                                    <span
                                        class="badge {{ $carousel->status == 'published' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $carousel->status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center flex-wrap gap-2">
                                        <!-- Tombol Lihat -->
                                        <a href="/dashboard/homeSections/{{ $carousel->id }}"
                                            class="btn btn-info d-flex ">
                                            <i class='bx bx-show'></i>
                                        </a>

                                        <!-- Tombol Edit -->
                                        <button type="button" class="btn btn-success btn-edit-content d-flex "
                                            data-bs-toggle="modal" data-bs-target="#modal-action"
                                            data-id="{{ $carousel->id }}">
                                            <i class='bx bxs-edit'></i>
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <form action="/dashboard/homeSections/{{ $carousel->id }}" method="POST"
                                            class="m-0">
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-danger d-flex delete-btn">
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
    <div class="modal fade" id="modal-action" tabindex="-1" aria-labelledby="exampleModalLgLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add Content</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="px-4">
                        <form id="contentForm" action="/dashboard/homeSections" class="authentication-form"
                            method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <input type="hidden" id="carousel_id" name="id">
                            <div class="row">
                                <div class="mb-3">
                                    <label class="form-label" for="title">Title</label>
                                    <input type="text" id="title" name="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        placeholder="Enter title" required autocomplete="off">
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="subtitle">Subtitle</label>
                                    <input type="text" id="subtitle" name="subtitle"
                                        class="form-control @error('subtitle') is-invalid @enderror"
                                        placeholder="Enter subtitle" required autocomplete="off">
                                    @error('subtitle')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>



                                <label for="background_image" class="form-label">Background Image</label>
                                <p class="text-info fs-6">Ukuran Image ("Tinggi : 900px - Lebar : 1920px")</p>
                                <div class="mb-3">
                                    <!-- Preview Image -->
                                    <img class="img-preview img-fluid rounded border mb-3"
                                        style="max-width: 250px; height: auto; display: none;">
                                    <p id="file-size" class="text-muted fs-6"></p>
                                    <p class="text-danger fs-6">Maximal Size 1 Mb !! </p>

                                    <input type="file" id="background_image" name="background_image"
                                        class="form-control @error('background_image') is-invalid @enderror"
                                        onchange="previewImage()">

                                    @error('background_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="mb-3">
                                    <!-- Quill Editors -->
                                    <label class="form-label" for="body">Body</label>
                                    @error('body')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <div id="snow-editor" style="height: 246px;"></div>
                                    <input type="hidden" name="body" id="body" required>
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select
                                        class="form-control @error('status')
                                            is-invalid
                                        @enderror"
                                        id="status" name="status">
                                        <option value="">Select Status Content</option>
                                        <option value="draft">
                                            Draft</option>
                                        <option value="published">
                                            Published
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" id="submitButton" class="btn btn-primary">Create
                                    Content</button>
                            </div>

                        </form>

                    </div> <!-- end col -->
                </div>

            </div>
        </div>
    </div>

</x-Dashboard.main-layout>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Ambil instance Quill yang sudah diinisialisasi di template
        var quillContainer = document.querySelector("#snow-editor");

        if (quillContainer) {


            // Buat ulang instance Quill dengan toolbar kustom (tanpa tombol image)
            const quill = new Quill("#snow-editor", {
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline'],
                        ['link'],
                        [{
                            list: 'ordered'
                        }, {
                            list: 'bullet'
                        }]
                        // Tidak ada 'image' di sini
                    ]
                },
                theme: "snow"
            });

            if (quill) {
                var form = document.querySelector("#contentForm");
                var bodyInput = document.querySelector("#body");

                // Set nilai awal jika ada (untuk edit mode)
                if (bodyInput) {
                    bodyInput.value = `{!! old('body') !!}`;
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

    // jQuery document ready
    $(document).ready(function() {
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

            if (formInput.background_image_temp_path) {
                $('.img-preview')
                    .attr('src', `/storage/${formInput.background_image_temp_path}`)
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

        // Handle Create New Content
        $(document).on("click", ".btn-add-content", function() {
            $("#modalTitle").text("Add Content");
            $("#contentForm")[0].reset();
            $("#contentForm input[name='_method']").remove();
            $("#contentForm").attr("action", "/dashboard/homeSections");
            $("#submitButton").text("Create Content");

            var quillEditor = Quill.find(document.querySelector("#snow-editor"));
            if (quillEditor) {
                quillEditor.root.innerHTML = '';
                $("#body").val('');
            }

            // Reset image preview
            $(".img-preview").hide();
        });

        // Handle Edit Content
        $(document).on("click", ".btn-edit-content", function() {
            var carId = $(this).data("id");

            $("#modalTitle").text("Edit content");
            $("#submitButton").text("Update content");
            $("#contentForm").attr("action", "/dashboard/homeSections/" + carId);


            if (!$('#contentForm input[name="_method"]').length) {
                $("#contentForm").append('<input type="hidden" name="_method" value="PUT">');
            }

            $.ajax({
                url: "/dashboard/homeSections/" + carId + "/edit",
                type: "GET",
                success: function(data) {
                    $("#carousel_id").val(data.id);
                    $("#title").val(data.title);
                    $("#subtitle").val(data.subtitle);
                    $("#status").val(data.status);

                    // Set Quill editor content dengan instance yang sudah ada di template
                    var quillEditor = Quill.find(document.querySelector("#snow-editor"));
                    if (quillEditor && data.body) {
                        quillEditor.root.innerHTML = data.body;
                        $("#body").val(data.body);
                    }

                    // Handle image preview
                    if (data.background_image) {
                        $(".img-preview")
                            .attr("src", "/storage/" + data.background_image)
                            .show();
                    } else {
                        $(".img-preview").hide();
                    }

                    $("#modal-action").modal("show");
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", error);
                    alert("Terjadi kesalahan saat mengambil data");
                },
            });
        });
    });


    function previewImage() {
        const input = document.querySelector("#background_image");
        const imgPreview = document.querySelector(".img-preview");
        const fileSizeText = document.querySelector("#file-size");

        if (input.files && input.files[0]) {
            const file = input.files[0];

            // Validasi format file
            const validExtensions = ["image/jpeg", "image/png", "image/jpg"];
            if (!validExtensions.includes(file.type)) {
                alert("Hanya file gambar yang diperbolehkan (JPEG, PNG, JPG).");
                input.value = ""; // Reset input file
                imgPreview.style.display = "none";
                fileSizeText.textContent = "";
                return;
            }

            const fileSizeKB = file.size / 1024;
            let displaySize;

            if (fileSizeKB >= 1000) {
                const fileSizeMB = (fileSizeKB / 1024).toFixed(2);
                displaySize = `Ukuran file: ${fileSizeMB} MB`;
            } else {
                displaySize = `Ukuran file: ${fileSizeKB.toFixed(2)} KB`;
            }

            fileSizeText.textContent = displaySize;

            const reader = new FileReader();
            reader.onload = function(e) {
                imgPreview.src = e.target.result;
                imgPreview.style.display = "block";
            };
            reader.readAsDataURL(file);
        }
    }
</script>
