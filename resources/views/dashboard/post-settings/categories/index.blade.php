<x-Dashboard.main-layout title="{{ $title }}">
    <div class="row g-4">
        <div class="col-12">
            <div class="mb-4">
                <h2 class="mb-2 text-center">Category Post</h2>

                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary mb-3 btn-add-content" data-bs-toggle="modal"
                    data-bs-target="#modal-action">
                    Create New Category
                </button>
                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>name</th>
                            <th>Slug</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->slug }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="about-img" width="100"
                                        height="60" style="object-fit: cover; border-radius: 5px;">
                                </td>
                                <td>
                                    <span class="badge {{ $category->status == 'Aktif' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $category->status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center flex-wrap gap-2">

                                        <!-- Tombol Edit -->
                                        <button type="button" class="btn btn-success btn-edit-content d-flex "
                                            data-bs-toggle="modal" data-bs-target="#modal-action"
                                            data-id="{{ $category->id }}">
                                            <i class='bx bxs-edit'></i>
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <form action="/dashboard/categories/{{ $category->id }}" method="POST"
                                            class="m-0">
                                            @method('delete')
                                            @csrf
                                            <button type="button" class="btn btn-danger delete-btn"
                                                data-id="{{ $category->id }}">
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
                    <h5 class="modal-title" id="modalTitle">Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="px-4">
                        <form id="contentForm" action="/dashboard/categories" class="authentication-form" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="category_id" name="id">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="name">Category Name</label>
                                        <input type="text" id="name" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            placeholder="Enter category name">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="slug">Slug</label>
                                        <input type="text" id="slug" name="slug"
                                            class="form-control @error('slug') is-invalid @enderror"
                                            placeholder="Enter slug category">
                                        @error('slug')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-control @error('status') is-invalid @enderror"
                                            id="status" name="status">
                                            <option value="">Select Status Category</option>
                                            <option value="Aktif">
                                                Aktif</option>
                                            <option value="Tidak Aktif">
                                                Tidak Aktif
                                            </option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>


                                <div class="col-md-6">


                                    <!-- Image Section -->
                                    <label for="image" class="form-label">Image</label>
                                    <div class="mb-3">
                                        <!-- Preview Image -->
                                        <p class="text-info fs-6">Ukuran Image ("Tinggi : 528px - Lebar : 470px")</p>
                                        <img id="image-preview" class="img-fluid rounded border mb-3"
                                            style="max-width: 250px; height: auto; display: none;">
                                        <p id="file-size" class="text-muted fs-6"></p>
                                        <p class="text-danger fs-6">Maximal Size 1 Mb !! </p>
                                        <input type="file" id="image" name="image"
                                            class="form-control @error('image') is-invalid @enderror"
                                            onchange="previewImage()">

                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


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
    const name = document.querySelector('#name');
    const slug = document.querySelector('#slug');
    name.addEventListener('change', function() {
        fetch('/dashboard/categories/checkSlug?name=' + name.value)
            .then(response => response.json())
            .then(data => slug.value = data.slug)
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

            if (formInput.image_temp_path) {
                $('#image-preview')
                    .attr('src', `/storage/${formInput.image_temp_path}`)
                    .css('display', 'block');
            }

        }

        // Reset modal saat ditutup
        $('#modal-action').on('hidden.bs.modal', function() {
            const $form = $(this).find('form')[0];
            $form.reset(); // Reset form

            $(this).find('.is-invalid').removeClass('is-invalid');
            $(this).find('.invalid-feedback').text('');
            $('#image-preview').hide().attr('src', '');
        });

        // Handle Create New Content
        $(".btn-add-content").on("click", function() {
            $("#modalTitle").text("Add Content");
            $("#contentForm")[0].reset();
            $("#contentForm input[name='_method']").remove();
            $("#contentForm").attr("action", "/dashboard/prokerSections");
            $("#submitButton").text("Create Content");

            // Reset image preview
            $(".img-preview").hide();
        });

        // Handle Create New Content
        $(document).on("click", ".btn-add-content", function() {
            $("#modalTitle").text("Add Category");
            $("#contentForm")[0].reset();
            $("#contentForm input[name='_method']").remove();
            $("#contentForm").attr("action", "/dashboard/categories");
            $("#submitButton").text("Create Category");

            // Reset image preview
            $(".img-preview").hide();
        });

        // Handle Edit Content
        $(document).on("click", ".btn-edit-content", function() {
            var categoryId = $(this).data("id");

            $("#modalTitle").text("Edit Category");
            $("#submitButton").text("Update Category");
            $("#contentForm").attr("action", "/dashboard/categories/" + categoryId);

            if (!$('#contentForm input[name="_method"]').length) {
                $("#contentForm").append('<input type="hidden" name="_method" value="PUT">');
            }

            $.ajax({
                url: "/dashboard/categories/" + categoryId + "/edit",
                type: "GET",
                success: function(data) {
                    $("#category_id").val(data.id);
                    $("#name").val(data.name);
                    $("#slug").val(data.slug);
                    $("#status").val(data.status);

                    // Handle image preview
                    if (data.image) {
                        $("#image-preview")
                            .attr("src", "/storage/" + data.image)
                            .show();
                    } else {
                        $("image-preview").hide();
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
        const input = document.querySelector("#image");
        const imgPreview = document.querySelector("#image-preview"); // Sesuaikan dengan ID yang benar
        const fileSizeDisplay = document.querySelector("#file-size"); // Elemen untuk menampilkan ukuran file

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

            // Tampilkan ukuran file dalam KB atau MB
            const fileSize = file.size / 1024; // Konversi ke KB
            fileSizeDisplay.textContent = `Ukuran file: ${fileSize.toFixed(2)} KB`;

            if (fileSize > 1024) {
                fileSizeDisplay.textContent = `Ukuran file: ${(fileSize / 1024).toFixed(2)} MB`;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                imgPreview.src = e.target.result;
                imgPreview.style.display = "block";
            };
            reader.readAsDataURL(file);
        } else {
            // Jika tidak ada file baru, kembalikan ke gambar lama jika ada
            const oldImage = imgPreview.getAttribute("data-old-src");
            if (oldImage) {
                imgPreview.src = oldImage;
                imgPreview.style.display = "block";
            } else {
                imgPreview.style.display = "none";
            }
            fileSizeDisplay.textContent = "";
        }
    }
</script>
