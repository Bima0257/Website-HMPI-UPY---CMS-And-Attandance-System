<x-Dashboard.main-layout title="{{ $title }}">
    <div class="row g-4">
        <div class="col-12">
            <div class="mb-4">
                <h2 class="mb-2 text-center">About Setting</h2>

                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary mb-3 btn-add-content" data-bs-toggle="modal"
                    data-bs-target="#modal-action">
                    Create Data About
                </button>
                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Small Logo</th>
                            <th>Large Logo</th>
                            <th>Background</th>
                            <th>Email</th>
                            <th>Contact Phone</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($abouts as $about)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $about->title }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $about->small_logo) }}" alt="about-img"
                                        width="100" height="60" style="object-fit: cover; border-radius: 5px;">
                                </td>
                                <td>
                                    <img src="{{ asset('storage/' . $about->large_logo) }}" alt="about-img"
                                        width="100" height="60" style="object-fit: cover; border-radius: 5px;">
                                </td>
                                <td>
                                    <img src="{{ asset('storage/' . $about->background_image) }}" alt="about-img"
                                        width="100" height="60" style="object-fit: cover; border-radius: 5px;">
                                </td>
                                <td>{{ $about->contact_email }}</td>
                                <td>{{ $about->contact_phone }}</td>
                                <td>
                                    <span
                                        class="badge {{ $about->status == 'published' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $about->status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center flex-wrap gap-2">
                                        <!-- Tombol Lihat -->
                                        <a href="/dashboard/about/{{ $about->id }}" class="btn btn-info d-flex ">
                                            <i class='bx bx-show'></i>
                                        </a>

                                        <!-- Tombol Edit -->
                                        <button type="button" class="btn btn-success btn-edit-content d-flex "
                                            data-bs-toggle="modal" data-bs-target="#modal-action"
                                            data-id="{{ $about->id }}">
                                            <i class='bx bxs-edit'></i>
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <form action="/dashboard/about/{{ $about->id }}" method="POST"
                                            class="m-0 delete-btn">
                                            @method('delete')
                                            @csrf
                                            <button type="button" class="btn btn-danger d-flex ">
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
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add Content</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="px-4">
                        <form id="contentForm" action="/dashboard/about" class="authentication-form" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="about_id" name="id">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="title">Title</label>
                                        <input type="text" id="title" name="title"
                                            class="form-control @error('title') is-invalid @enderror"
                                            value="{{ old('title') }}" placeholder="Enter title" autocomplete="off"
                                            required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="video_url">Video URL</label>
                                        <input type="text" id="video_url" name="video_url"
                                            class="form-control @error('video_url') is-invalid @enderror"
                                            placeholder="Enter video url" autocomplete="off" required>
                                        @error('video_url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="youtube_url">Youtube URL</label>
                                        <input type="text" id="youtube_url" name="youtube_url"
                                            class="form-control @error('youtube_url') is-invalid @enderror"
                                            placeholder="Enter youtube url" autocomplete="off" required>
                                        @error('youtube_url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="tiktok_url">Tiktok URL</label>
                                        <input type="text" id="tiktok_url" name="tiktok_url"
                                            class="form-control @error('tiktok_url') is-invalid @enderror"
                                            placeholder="Enter tiktok url" autocomplete="off" required>
                                        @error('tiktok_url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="contact_email">Contact email</label>
                                        <input type="email" id="contact_email" name="contact_email"
                                            class="form-control @error('contact_email') is-invalid @enderror"
                                            placeholder="Enter contact_email" autocomplete="off" required>
                                        @error('contact_email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="alamat">Alamat</label>
                                        <input type="text" id="alamat" name="alamat"
                                            class="form-control @error('alamat') is-invalid @enderror"
                                            placeholder="Enter Address" autocomplete="off" required>
                                        @error('alamat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-md-6">

                                    <div class="mb-3">
                                        <label class="form-label" for="instagram_url">Instagram URL</label>
                                        <input type="text" id="instagram_url" name="instagram_url"
                                            class="form-control @error('instagram_url') is-invalid @enderror"
                                            placeholder="Enter instagram url" autocomplete="off" required>
                                        @error('instagram_url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <label for="small_logo" class="form-label">Small Logo</label>
                                    <div class="mb-3">
                                        <p class="text-info fs-6">Ukuran Image ("Tinggi : 528px - Lebar : 470px")</p>
                                        <img id="preview_small_logo" class="img-fluid rounded border mb-3"
                                            style="max-width: 250px; height: auto; display: none;">
                                        <p id="file-size-small_logo" class="text-muted fs-6"></p>
                                        <p class="text-danger fs-6">Maximal Size 1 Mb !! </p>
                                        <input type="file" id="small_logo" name="small_logo"
                                            class="form-control @error('small_logo') is-invalid @enderror"
                                            onchange="previewImage(this, 'preview_small_logo', 'file-size-small_logo')">
                                        @error('small_logo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <label for="large_logo" class="form-label">Large Logo</label>
                                    <div class="mb-3">
                                        <p class="text-info fs-6">Ukuran Image ("Tinggi : 528px - Lebar : 470px")</p>
                                        <img id="preview_large_logo" class="img-fluid rounded border mb-3"
                                            style="max-width: 250px; height: auto; display: none;">
                                        <p id="file-size-large_logo" class="text-muted fs-6"></p>
                                        <p class="text-danger fs-6">Maximal Size 1 Mb !! </p>
                                        <input type="file" id="large_logo" name="large_logo"
                                            class="form-control @error('large_logo') is-invalid @enderror"
                                            onchange="previewImage(this, 'preview_large_logo', 'file-size-large_logo')">
                                        @error('large_logo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <label for="background_image" class="form-label">Background Image</label>
                                    <div class="mb-3">
                                        <p class="text-info fs-6">Ukuran Image ("Tinggi : 528px - Lebar : 470px")</p>
                                        <img id="preview_background_image" class="img-fluid rounded border mb-3"
                                            style="max-width: 250px; height: auto; display: none;">
                                        <p id="file-size-background_image" class="text-muted fs-6"></p>
                                        <p class="text-danger fs-6">Maximal Size 1 Mb !! </p>
                                        <input type="file" id="background_image" name="background_image"
                                            class="form-control @error('background_image') is-invalid @enderror"
                                            onchange="previewImage(this, 'preview_background_image', 'file-size-background_image')">
                                        @error('background_image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mb-3">
                                        <label class="form-label" for="contact_phone">Contact Phone</label>
                                        <input type="text" id="contact_phone" name="contact_phone"
                                            class="form-control @error('contact_phone') is-invalid @enderror"
                                            placeholder="Enter contact phone" autocomplete="off" required>
                                        @error('contact_phone')
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

                            <div class="mb-3">
                                <!-- Quill Editors -->
                                <label class="form-label" for="body">Body</label>
                                @error('body')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                <div id="snow-editor" style="height: 300px;"></div>
                                <input type="hidden" name="body" id="body" required>
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
        const quill = new Quill("#snow-editor", {
            theme: "snow"
        });

        const form = document.querySelector("#contentForm");
        const bodyInput = document.querySelector("#body");

        if (bodyInput) {
            bodyInput.value = `{!! old('body') !!}`;
            if (bodyInput.value) {
                quill.root.innerHTML = bodyInput.value;
            }

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
    });

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
                $('#preview_background_image')
                    .attr('src', `/storage/${formInput.background_image_temp_path}`)
                    .css('display', 'block');
            }
            if (formInput.small_logo_temp_path) {
                $('#preview_small_logo')
                    .attr('src', `/storage/${formInput.small_logo_temp_path}`)
                    .css('display', 'block');
            }
            if (formInput.large_logo_temp_path) {
                $('#preview_large_logo')
                    .attr('src', `/storage/${formInput.large_logo_temp_path}`)
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
            $("#contentForm").attr("action", "/dashboard/about");
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
            var contentId = $(this).data("id");

            $("#modalTitle").text("Edit Content");
            $("#submitButton").text("Update Content");
            $("#contentForm").attr("action", "/dashboard/about/" + contentId);

            if (!$('#contentForm input[name="_method"]').length) {
                $("#contentForm").append('<input type="hidden" name="_method" value="PUT">');
            }

            $.ajax({
                url: "/dashboard/about/" + contentId + "/edit",
                type: "GET",
                success: function(data) {
                    $("#about_id").val(data.id);
                    $("#title").val(data.title);
                    $("#video_url").val(data.video_url);
                    $("#instagram_url").val(data.instagram_url);
                    $("#youtube_url").val(data.youtube_url);
                    $("#tiktok_url").val(data.tiktok_url);
                    $("#contact_email").val(data.contact_email);
                    $("#contact_phone").val(data.contact_phone);
                    $("#status").val(data.status);
                    $("#alamat").val(data.alamat);

                    // Set Quill editor content dengan instance yang sudah ada di template
                    var quillEditor = Quill.find(document.querySelector("#snow-editor"));
                    if (quillEditor && data.body) {
                        quillEditor.root.innerHTML = data.body;
                        $("#body").val(data.body);
                    }

                    // Handle image preview
                    if (data.background_image) {
                        $("#preview_background_image")
                            .attr("src", "/storage/" + data.background_image)
                            .show();
                    } else {
                        $("#preview_background_image").hide();
                    }
                    // Handle image preview
                    if (data.small_logo) {
                        $("#preview_small_logo")
                            .attr("src", "/storage/" + data.small_logo)
                            .show();
                    } else {
                        $("#preview_small_logo").hide();
                    }
                    // Handle image preview
                    if (data.large_logo) {
                        $("#preview_large_logo")
                            .attr("src", "/storage/" + data.large_logo)
                            .show();
                    } else {
                        $("#preview_large_logo").hide();
                    }

                    $("#modal-action").modal("show");
                },
                error: function(xhr, status, error) {
                    console.error("Detail error:", {
                        status: xhr.status,
                        responseText: xhr.responseText,
                        error: error
                    });
                    alert("Terjadi kesalahan saat mengambil data: " + xhr.status + " " +
                        error);
                }
            });
        });
    });

    function previewImage(input, previewId, fileSizeId) {
        const imgPreview = document.getElementById(previewId);
        const fileSizeDisplay = document.getElementById(fileSizeId);

        if (input.files && input.files[0]) {
            const file = input.files[0];
            const validExtensions = ["image/jpeg", "image/png", "image/jpg"];

            if (!validExtensions.includes(file.type)) {
                alert("Hanya file gambar yang diperbolehkan (JPEG, PNG, JPG).");
                input.value = "";
                imgPreview.style.display = "none";
                fileSizeDisplay.textContent = "";
                return;
            }

            // Tampilkan ukuran file
            const fileSizeKB = file.size / 1024;
            fileSizeDisplay.textContent = fileSizeKB > 1024 ?
                `Ukuran file: ${(fileSizeKB / 1024).toFixed(2)} MB` :
                `Ukuran file: ${fileSizeKB.toFixed(2)} KB`;

            const reader = new FileReader();
            reader.onload = function(e) {
                imgPreview.src = e.target.result;
                imgPreview.style.display = "block";
            };
            reader.readAsDataURL(file);
        } else {
            imgPreview.style.display = "none";
            fileSizeDisplay.textContent = "";
        }
    }
</script>
