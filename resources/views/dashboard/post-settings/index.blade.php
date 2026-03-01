<x-Dashboard.main-layout title="{{ $title }}">
    <div class="row g-4">
        <div class="col-12">
            <div class="mb-4">
                <h2 class="mb-2 text-center">Data Article</h2>
                <div class="d-flex gap-2 flex-wrap mb-3">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary mb-3 btn-add-content" data-bs-toggle="modal"
                        data-bs-target="#modal-action">
                        Create New Post
                    </button>

                    @if (Auth::user()->level_pengguna === 'Super Admin')
                        <form action="{{ route('posts.deleteAll') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger delete-all-btn">
                                <i class="bx bx-trash"></i> Delete All
                            </button>
                        </form>
                    @else
                        <form action="{{ route('posts.deleteOwnPost') }}" method="POST">
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
                            <th>Penulis</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($posts as $post)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $post->judul }}</td>
                                <td>{{ $post->author->name ?? 'Unknown' }}</td>
                                <td>{{ $post->category?->name ?? 'Tidak Ada Category' }}</td>
                                <td>
                                    <span class="badge {{ $post->status == 'published' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $post->status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center flex-wrap gap-2">
                                        <!-- Tombol Lihat -->
                                        <a href="/dashboard/posts/{{ $post->slug }}" class="btn btn-info d-flex ">
                                            <i class='bx bx-show'></i>
                                        </a>

                                        <!-- Tombol Edit -->
                                        <button type="button" class="btn btn-success btn-edit-content d-flex "
                                            data-bs-toggle="modal" data-bs-target="#modal-action"
                                            data-id="{{ $post->slug }}">
                                            <i class='bx bxs-edit'></i>
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <form action="/dashboard/posts/{{ $post->slug }}" method="POST"
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
                    <h5 class="modal-title" id="modalTitle">Add Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="px-4">
                        <form id="contentForm" action="/dashboard/posts" class="authentication-form" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="post_id" name="id">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="judul">Judul</label>
                                        <input type="text" id="judul" name="judul"
                                            class="form-control @error('judul') is-invalid @enderror"
                                            placeholder="Enter judul" autocomplete="off" required>
                                        @error('judul')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="slug">Slug</label>
                                        <input type="text" id="slug" name="slug"
                                            class="form-control @error('slug') is-invalid @enderror"
                                            placeholder="Enter slug" required>
                                        @error('slug')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <!-- Image Section -->
                                    <label for="image" class="form-label">Image</label>
                                    <div class="mb-3">
                                        <p class="text-info fs-6">Ukuran Image ("Tinggi : 240px - Lebar : 370px")</p>
                                        <!-- Preview Image -->
                                        <img id="image-preview" class="img-fluid rounded border mb-3"
                                            style="max-width: 250px; height: auto; display: none;"
                                            data-old-src="{{ isset($post) ? asset('storage/' . $post->image) : '' }}">
                                        <p id="image-size-info" class="text-muted fs-6"></p>
                                        <p class="text-warning fs-6">Maximal Size 1 Mb !! </p>
                                        <input type="file" id="image" name="image"
                                            class="form-control @error('image') is-invalid @enderror"
                                            onchange="previewImage()">
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>


                                <div class="col-md-6">

                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">Category</label>
                                        <select class="form-control @error('category_id') is-invalid @enderror"
                                            id="category_id" name="category_id" required>
                                            <option value="">Select Category Post</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Background Image Section -->
                                    <label for="background_image" class="form-label">Background Image</label>
                                    <div class="mb-3">
                                        <p class="text-info fs-6">Ukuran Image ("Tinggi : 397px - Lebar : 770px")</p>
                                        <!-- Preview Background Image -->
                                        <img id="background_image-preview" class="img-fluid rounded border mb-3"
                                            style="max-width: 250px; height: auto; display: none;"
                                            data-old-src="{{ isset($post) ? asset('storage/' . $post->background_image) : '' }}">
                                        <p id="background_image-size-info" class="text-muted fs-6"></p>
                                        <p class="text-warning fs-6">Maximal Size 1 Mb !! </p>
                                        <input type="file" id="background_image" name="background_image"
                                            class="form-control @error('background_image') is-invalid @enderror"
                                            onchange="previewImage()">

                                        @error('background_image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-control @error('status') is-invalid @enderror"
                                            id="status" name="status" required>
                                            <option value="">Select Status Post</option>
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
                            </div>


                            <div class="mb-3">
                                <!-- Quill Editors -->
                                <label class="form-label" for="body">Body</label>
                                @error('body')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                                <div id="snow-editor" style="height: 300px;"></div>
                                <input type="hidden" name="body" id="body"required>
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
    const judul = document.querySelector('#judul');
    const slug = document.querySelector('#slug');
    judul.addEventListener('change', function() {
        fetch('/dashboard/posts/checkSlug?judul=' + judul.value)
            .then(response => response.json())
            .then(data => slug.value = data.slug)
    });

    document.addEventListener("DOMContentLoaded", function() {
        // Ambil instance Quill yang sudah diinisialisasi di template
        var quillContainer = document.querySelector("#snow-editor");

        if (quillContainer) {
            // Dapatkan instance Quill yang sudah ada
            var quill = Quill.find(quillContainer);

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


    $(document).ready(function() {

        const formError = @json(session('form_error'));
        const formInput = @json(session('form_input'));

        if (formError) {
            $('#modal-action').modal('show');

            // Isi ulang value input form
            for (const key in formInput) {
                const $input = $(`#modal-action [name="${key}"]`);

                if ($input.length) {
                    $input.val(formInput[key]);
                }
            }

            if (formInput.image_temp_path) {
                $('#image-preview')
                    .attr('src', `/storage/${formInput.image_temp_path}`)
                    .css('display', 'block');
            }

            if (formInput.background_image_temp_path) {
                $('#background_image-preview')
                    .attr('src', `/storage/${formInput.background_image_temp_path}`)
                    .css('display', 'block');
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
            $('#image-preview').hide().attr('src', '');
            $('#background_image-preview').hide().attr('src', '');
        });

        // Handle Create New Content
        $(document).on("click", ".btn-add-content", function() {
            $("#modalTitle").text("Add Post");
            $("#contentForm")[0].reset();
            $("#contentForm input[name='_method']").remove();
            $("#contentForm").attr("action", "/dashboard/posts");
            $("#submitButton").text("Create Post");

            var quillEditor = Quill.find(document.querySelector("#snow-editor"));
            if (quillEditor) {
                quillEditor.root.innerHTML = '';
                $("#body").val('');
            }

            // Reset image preview
            $("#image-preview").hide();
            $("#background_image-preview").hide();
        });

        // Handle Edit Content
        $(document).on("click", ".btn-edit-content", function() {
            var postId = $(this).data("id");

            $("#modalTitle").text("Edit Post");
            $("#submitButton").text("Update Post");
            $("#contentForm").attr("action", "/dashboard/posts/" + postId);

            if (!$('#contentForm input[name="_method"]').length) {
                $("#contentForm").append('<input type="hidden" name="_method" value="PUT">');
            }

            $.ajax({
                url: "/dashboard/posts/" + postId + "/edit",
                type: "GET",
                success: function(data) {
                    $("#post_id").val(data.id);
                    $("#judul").val(data.judul);
                    $("#slug").val(data.slug);
                    $("#category_id").val(data.category_id);
                    $("#status").val(data.status);

                    // Set Quill editor content dengan instance yang sudah ada di template
                    var quillEditor = Quill.find(document.querySelector("#snow-editor"));
                    if (quillEditor && data.body) {
                        quillEditor.root.innerHTML = data.body;
                        $("#body").val(data.body);
                    }

                    // Handle image preview
                    if (data.image) {
                        $("#image-preview")
                            .attr("src", "/storage/" + data.image)
                            .show();
                    }

                    if (data.background_image) {
                        $("#background_image-preview")
                            .attr("src", "/storage/" + data.background_image)
                            .show();
                    } else {
                        $("#background_image-preview").hide();
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

    function previewImage() {
        const inputId = event.target.id;
        const input = document.getElementById(inputId);
        const imgPreviewId = inputId + "-preview";
        const imgPreview = document.querySelector(`#${imgPreviewId}`);
        const sizeInfoId = inputId + "-size-info";
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
