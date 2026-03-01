<x-Dashboard.main-layout title="{{ $title }}">
    <div class="row g-4">
        <div class="col-12">
            <div class="mb-4">
                <h2 class="mb-2 text-center">Division</h2>

                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary mb-3 btn-add-division" data-bs-toggle="modal"
                    data-bs-target="#modal-action">
                    Create New Event
                </button>
                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Divisi</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($divisions as $division)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $division->nama_divisi }}</td>
                                <td>
                                    <div class="d-flex align-items-center flex-wrap gap-2">
                                        <button type="button" class="btn btn-success btn-edit-division d-flex"
                                            data-bs-toggle="modal" data-bs-target="#modal-action"
                                            data-id="{{ $division->id }}">
                                            <i class='bx bxs-edit'></i>
                                        </button>
                                        <form action="/dashboard/divisions/{{ $division->id }}" method="POST">
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
                        <form id="divisionForm" action="/dashboard/divisions" class="authentication-form" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="division_id" name="id"> <!-- Untuk edit -->

                            <div class="row">

                                <div class="mb-3">
                                    <label class="form-label" for="nama_divisi">Nama Divisi</label>
                                    <input type="text" id="nama_divisi" name="nama_divisi"
                                        class="form-control @error('nama_divisi') is-invalid @enderror"
                                        placeholder="Enter Nama Divisi" autocomplete="off" required>
                                    @error('nama_divisi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-sm btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" id="submitButton" class="btn btn-sm btn-primary">Create New
                                        Event
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
        const userForm = $("#divisionForm");
        const modalAction = $("#modal-action");
        const modalTitle = $("#modalTitle");
        const submitButton = $("#submitButton");
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
        }

        // Reset modal saat ditutup
        $('#modal-action').on('hidden.bs.modal', function() {
            const $form = $(this).find('form')[0];
            $form.reset(); // Reset form

            $(this).find('.is-invalid').removeClass('is-invalid');
            $(this).find('.invalid-feedback').text('');
        });


        $(document).on("click", ".btn-add-division", function() {
            modalTitle.text("Add division");
            submitButton.text("Create division");

            userForm[0].reset();
            $("#division_id").val("");
            userForm.find("input[name='_method']").remove();

            userForm.attr("action", "/dashboard/divisions").attr("method", "POST");

            modalAction.modal("show");
        });

        $(document).on("click", ".btn-edit-division", function() {
            let divisionId = $(this).data("id");

            modalTitle.text("Edit division");
            submitButton.text("Update division");

            userForm.attr("action", "/dashboard/divisions/" + divisionId);
            userForm.find("input[name='_method']").remove();
            userForm.append('<input type="hidden" name="_method" value="PUT">');

            $.ajax({
                url: `/dashboard/divisions/${divisionId}/edit`,
                type: "GET",
                success: function(data) {
                    $("#division_id").val(data.id);
                    $("#nama_divisi").val(data.nama_divisi);

                    modalAction.modal("show");
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                },
            });
        });
    });
</script>
