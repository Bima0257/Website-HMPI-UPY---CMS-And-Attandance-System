<x-Dashboard.main-layout title="{{ $title }}">
    <div class="row g-4">
        <div class="col-12">
            <div class="mb-4">
                <h2 class="mb-2 text-center">Background Breadcrumb Setting</h2>

                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary mb-3 btn-add-content" data-bs-toggle="modal"
                    data-bs-target="#modal-action">
                    Create New Content
                </button>
                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>About</th>
                            <th>All Program</th>
                            <th>Program Detail</th>
                            <th>Our Team</th>
                            <th>All Article</th>
                            <th>Detail Article</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($backgrounds as $background)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $background->about) }}" alt="background-img"
                                        width="100" height="60" style="object-fit: cover; border-radius: 5px;">
                                </td>
                                <td>
                                    <img src="{{ asset('storage/' . $background->all_programs) }}" alt="background-img"
                                        width="100" height="60" style="object-fit: cover; border-radius: 5px;">
                                </td>
                                <td>
                                    <img src="{{ asset('storage/' . $background->program_detail) }}"
                                        alt="background-img" width="100" height="60"
                                        style="object-fit: cover; border-radius: 5px;">
                                </td>
                                <td>
                                    <img src="{{ asset('storage/' . $background->our_teams) }}" alt="background-img"
                                        width="100" height="60" style="object-fit: cover; border-radius: 5px;">
                                </td>
                                <td>
                                    <img src="{{ asset('storage/' . $background->all_articles) }}" alt="background-img"
                                        width="100" height="60" style="object-fit: cover; border-radius: 5px;">
                                </td>
                                <td>
                                    <img src="{{ asset('storage/' . $background->detail_article) }}"
                                        alt="background-img" width="100" height="60"
                                        style="object-fit: cover; border-radius: 5px;">
                                </td>
                                <td>
                                    <span
                                        class="badge {{ $background->status == 'published' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $background->status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center flex-wrap gap-2">
                                        <!-- Tombol Edit -->
                                        <button type="button" class="btn btn-success btn-edit-content d-flex "
                                            data-bs-toggle="modal" data-bs-target="#modal-action"
                                            data-id="{{ $background->id }}">
                                            <i class='bx bxs-edit'></i>
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <form action="/dashboard/background/{{ $background->id }}" method="POST"
                                            id="delete-form-{{ $background->id }}" class="m-0">
                                            @method('delete')
                                            @csrf
                                            <button type="button" class="btn btn-danger d-flex delete-btn"
                                                data-id="{{ $background->id }}">
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
                    <h5 class="modal-title" id="modalTitle">Add Background</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="px-4">
                        <form id="contentForm" action="/dashboard/background" class="authentication-form" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="background_id" name="id">
                            <div class="row">
                                <div class="col-md-4">

                                    <label for="about" class="form-label">Background About</label>
                                    <div class="mb-3">
                                        <!-- Preview Image -->
                                        <img class="about_img-preview img-fluid rounded border mb-3"
                                            style="max-width: 250px; max-height: 150px; object-fit: cover; display: none;">
                                        <p class="text-danger fs-6">Maximal Size 1 Mb !! </p>
                                        <input type="file" id="about" name="about"
                                            class="form-control @error('about') is-invalid @enderror"
                                            onchange="previewImage(this)">

                                        @error('about')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <label for="all_programs" class="form-label">Background All Programs</label>
                                    <div class="mb-3">
                                        <!-- Preview Image -->
                                        <img class="all_programs_img-preview img-fluid rounded border mb-3"
                                            style="max-width: 250px; max-height: 150px; object-fit: cover; display: none;">
                                        <p class="text-danger fs-6">Maximal Size 1 Mb !! </p>
                                        <input type="file" id="all_programs" name="all_programs"
                                            class="form-control @error('all_programs') is-invalid @enderror"
                                            onchange="previewImage(this)">

                                        @error('all_programs')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <label for="program_detail" class="form-label">Background Program Detail</label>
                                    <div class="mb-3">
                                        <!-- Preview Image -->
                                        <img class="program_detail_img-preview img-fluid rounded border mb-3"
                                            style="max-width: 250px; max-height: 150px; object-fit: cover; display: none;">
                                        <p class="text-danger fs-6">Maximal Size 1 Mb !! </p>
                                        <input type="file" id="program_detail" name="program_detail"
                                            class="form-control @error('program_detail') is-invalid @enderror"
                                            onchange="previewImage(this)">

                                        @error('program_detail')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-md-4">

                                    <label for="our_teams" class="form-label">Background Our Teams</label>
                                    <div class="mb-3">
                                        <!-- Preview Image -->
                                        <img class="our_teams_img-preview img-fluid rounded border mb-3"
                                            style="max-width: 250px; max-height: 150px; object-fit: cover; display: none;">
                                        <p class="text-danger fs-6">Maximal Size 1 Mb !! </p>
                                        <input type="file" id="our_teams" name="our_teams"
                                            class="form-control @error('our_teams') is-invalid @enderror"
                                            onchange="previewImage(this)">

                                        @error('our_teams')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <label for="all_articles" class="form-label">Background All Articles</label>
                                    <div class="mb-3">
                                        <!-- Preview Image -->
                                        <img class="all_articles_img-preview img-fluid rounded border mb-3"
                                            style="max-width: 250px; max-height: 150px; object-fit: cover; display: none;">
                                        <p class="text-danger fs-6">Maximal Size 1 Mb !! </p>
                                        <input type="file" id="all_articles" name="all_articles"
                                            class="form-control @error('all_articles') is-invalid @enderror"
                                            onchange="previewImage(this)">

                                        @error('all_articles')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                </div>

                                <div class="col-md-4">

                                    <label for="detail_article" class="form-label">Background Detail Article</label>
                                    <div class="mb-3">
                                        <!-- Preview Image -->
                                        <img class="detail_article_img-preview img-fluid rounded border mb-3"
                                            style="max-width: 250px; max-height: 150px; object-fit: cover; display: none;">
                                        <p class="text-danger fs-6">Maximal Size 1 Mb !! </p>
                                        <input type="file" id="detail_article" name="detail_article"
                                            class="form-control @error('detail_article') is-invalid @enderror"
                                            onchange="previewImage(this)">

                                        @error('detail_article')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <label for="category" class="form-label">Background Category</label>
                                    <div class="mb-3">
                                        <!-- Preview Image -->
                                        <img class="category_img-preview img-fluid rounded border mb-3"
                                            style="max-width: 250px; max-height: 150px; object-fit: cover; display: none;">
                                        <p class="text-danger fs-6">Maximal Size 1 Mb !! </p>
                                        <input type="file" id="category" name="category"
                                            class="form-control @error('category') is-invalid @enderror"
                                            onchange="previewImage(this)">

                                        @error('category')
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
                                    <option value="">Select Status Content</option>
                                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>
                                        Draft</option>
                                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>
                                        Published
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" id="submitButton" class="btn btn-primary">Create
                                    Background</button>
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
        const previewFields = [
            'about', 'all_programs', 'our_teams',
            'program_detail', 'all_articles', 'detail_article', 'category'
        ];

        const formError = @json(session('form_error'));
        const formInput = @json(session('form_input'));

        if (formError) {
            $('#modal-action').modal('show');

            // Isi ulang input
            for (const key in formInput) {
                const $input = $(`#modal-action [name="${key}"]`);
                if ($input.length) $input.val(formInput[key]);
            }

            // Tampilkan gambar preview sementara
            previewFields.forEach(field => {
                const tempPath = formInput[`${field}_temp_path`];
                if (tempPath) {
                    $(`.${field}_img-preview`)
                        .attr('src', `/storage/${tempPath}`)
                        .css('display', 'block');
                }
            });
        }

        // Reset modal saat ditutup
        $('#modal-action').on('hidden.bs.modal', function() {
            const $form = $(this).find('form');
            $form.trigger('reset');
            $form.find('.is-invalid').removeClass('is-invalid');
            $form.find('.invalid-feedback').text('');

            previewFields.forEach(field => {
                $(`.${field}_img-preview`).hide().attr('src', '');
                $(`.${field}_size`).remove();
            });
        });

        // Tombol Add Content
        $(document).on("click", ".btn-add-content", function() {
            $("#modalTitle").text("Add background");
            $("#contentForm").trigger('reset');
            $("#contentForm input[name='_method']").remove();
            $("#contentForm").attr("action", "/dashboard/background");
            $("#submitButton").text("Create background");

            previewFields.forEach(field => {
                $(`.${field}_img-preview`).hide().attr('src', '');
                $(`.${field}_size`).remove();
            });
        });

        // Tombol Edit
        $(document).on("click", ".btn-edit-content", function() {
            const id = $(this).data("id");

            $("#modalTitle").text("Edit Background");
            $("#submitButton").text("Update Background");
            $("#contentForm").attr("action", "/dashboard/background/" + id);

            if (!$('#contentForm input[name="_method"]').length) {
                $("#contentForm").append('<input type="hidden" name="_method" value="PUT">');
            }

            $.get("/dashboard/background/" + id + "/edit", function(data) {
                $("#background_id").val(data.id);
                $("#status").val(data.status);

                previewFields.forEach(field => {
                    setPreviewImage(`.${field}_img-preview`, data[field]);
                });

                $('#modal-action').modal('show');
            }).fail(function(xhr) {
                console.error("Detail error:", xhr.responseText);
                alert("Terjadi kesalahan saat mengambil data: " + xhr.status);
            });
        });

        // Fungsi preview gambar baru
        window.previewImage = function(input) {
            const file = input.files[0];
            if (!file) return;

            const maxSize = 3 * 1024 * 1024; // 3MB
            const validExtensions = ["image/jpeg", "image/png", "image/jpg"];
            const previewClass = "." + input.id + "_img-preview";
            const sizeClass = "." + input.id + "_size";
            const $preview = $(previewClass);

            // Hapus ukuran sebelumnya (jika ada)
            $(sizeClass).remove();

            // Cek ekstensi dan ukuran
            if (!validExtensions.includes(file.type)) {
                alert("Hanya file gambar JPEG, PNG, atau JPG yang diperbolehkan.");
                input.value = "";
                $preview.hide();
                return;
            }

            if (file.size > maxSize) {
                alert("Ukuran gambar maksimal 3MB.");
                input.value = "";
                $preview.hide();
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                $preview.attr('src', e.target.result).show();

                const fileSizeKB = (file.size / 1024).toFixed(2);
                const readableSize = fileSizeKB > 1024 ?
                    (fileSizeKB / 1024).toFixed(2) + ' MB' :
                    fileSizeKB + ' KB';

                $preview.after(
                    `<span class="${input.id}_size" style="display: block;">Ukuran File: ${readableSize}</span>`
                );
            };
            reader.readAsDataURL(file);
        };

        // Fungsi bantuan untuk set gambar lama
        function setPreviewImage(selector, path) {
            if (path) {
                $(selector).attr("src", "/storage/" + path).show();
            } else {
                $(selector).hide().attr("src", '');
            }
        }
    });
</script>
