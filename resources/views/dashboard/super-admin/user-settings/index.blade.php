<x-Dashboard.main-layout title="{{ $title }}">
    <div class="row g-4">
        <div class="col-12">
            <div class="mb-4">
                <h2 class="mb-2 text-center">Account User Data </h2>

                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary mb-3 btn-add-user" data-bs-toggle="modal"
                    data-bs-target="#modal-action">
                    Create New User
                </button>
                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Divisi</th>
                            <th>User Level</th>
                            <th>Status User</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->divisi?->nama_divisi ?? 'Tidak ada divisi!' }}</td>
                                <td>{{ $user->level_pengguna }}</td>
                                <td>{{ $user->status }}</td>
                                <td>
                                    <div class="d-flex flex-wrap gap-2">
                                        <button type="button" class="btn btn-success mb-3 btn-edit-user"
                                            data-bs-toggle="modal" data-bs-target="#modal-action"
                                            data-id="{{ $user->id }}">
                                            <i class='bx bxs-edit'></i>
                                        </button>
                                        <form action="/dashboard/userSettings/{{ $user->id }}" method="POST"
                                            class="delete-form">
                                            @method('delete')
                                            @csrf
                                            <button type="button" class="btn btn-danger delete-btn"><i
                                                    class='bx bxs-trash-alt'></i>
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
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="px-4">
                        <form id="userForm" action="/dashboard/userSettings" class="authentication-form"
                            method="POST">
                            @csrf
                            <input type="hidden" id="user_id" name="id"> <!-- Untuk edit -->
                            <div class="mb-3">
                                <label class="form-label" for="name">Name</label>
                                <input type="text" id="name" name="name"
                                    class="form-control @error('name') is-invalid @enderror" placeholder="Enter name"
                                    autocomplete="off" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="username">Username</label>
                                <input type="text" id="username" name="username"
                                    class="form-control @error('username') is-invalid @enderror"
                                    placeholder="Enter username" autocomplete="off" required>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="divisi_id" class="form-label">Divisi</label>
                                <select
                                    class="form-control  @error('divisi_id')
                                            is-invalid
                                        @enderror"
                                    name="divisi_id" id="divisi_id" required>
                                    <option value="">Pilih Divisi</option>
                                    @foreach ($divisions as $divisi)
                                        <option value="{{ $divisi->id }}">{{ $divisi->nama_divisi }}
                                        </option>
                                    @endforeach
                                </select>
                                <div id="error-message" style="display: none;"
                                    class="alert alert-danger alert-icon mb-0" role="alert">
                                </div>

                                @error('divisi_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3" id="oldPasswordField">
                                <label class="form-label" for="old_password">Old Password</label>
                                <div class="input-group">
                                    <input type="password" id="old_password" name="old_password"
                                        class="form-control @error('old_password') is-invalid @enderror"
                                        placeholder="Enter the old password">
                                    <span class="input-group-text"
                                        onclick="togglePasswordVisibility('old_password', 'toggleOldIcon')"
                                        style="cursor: pointer;">
                                        <iconify-icon icon="iconamoon:eye" width="15" height="15"
                                            id="toggleOldIcon" class="text-muted"></iconify-icon>
                                    </span>
                                    @error('old_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="password">Password</label>
                                <div class="input-group">
                                    <input type="password" id="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Enter your password">
                                    <span class="input-group-text"
                                        onclick="togglePasswordVisibility('password', 'toggleIcon')"
                                        style="cursor: pointer;">
                                        <iconify-icon icon="iconamoon:eye" width="15" height="15"
                                            id="toggleIcon" class="text-muted"></iconify-icon>
                                    </span>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="confirm_password">Konfirmasi Password</label>
                                <div class="input-group">
                                    <input type="password" id="confirm_password" name="confirm_password"
                                        class="form-control @error('confirm_password') is-invalid @enderror"
                                        placeholder="Confirm your password">
                                    <span class="input-group-text"
                                        onclick="togglePasswordVisibility('confirm_password', 'toggleConfirmIcon')"
                                        style="cursor: pointer;">
                                        <iconify-icon icon="iconamoon:eye" width="15" height="15"
                                            id="toggleConfirmIcon" class="text-muted"></iconify-icon>
                                    </span>
                                    @error('confirm_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="mb-3">
                                <label for="status" class="form-label">Status User</label>
                                <select
                                    class="form-control @error('status')
                                        is-invalid
                                    @enderror"
                                    id="status" name="status" required>
                                    <option value="">Select Status User</option>
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

                            <div class="mb-3">
                                <label for="level_pengguna" class="form-label">User Level</label>

                                <input type="text" class="form-control" value="Admin" readonly>

                                <input type="hidden" name="level_pengguna" value="Admin">
                            </div>


                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" id="submitButton" class="btn btn-primary">Create User</button>
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
        const formError = @json(session('form_error'));
        const formInput = @json(session('form_input'));

        const userForm = $("#userForm");
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
            }
        }

        // Reset modal saat ditutup
        $('#modal-action').on('hidden.bs.modal', function() {
            const $form = $(this).find('form')[0];
            $form.reset(); // Reset form

            $(this).find('.is-invalid').removeClass('is-invalid');
            $(this).find('.invalid-feedback').text('');
        });

        $(document).on("click", ".btn-add-user", function() {
            modalTitle.text("Add User");
            submitButton.text("Create User");

            userForm[0].reset();
            $("#user_id").val("");
            userForm.find("input[name='_method']").remove();
            $("#oldPasswordField").addClass("d-none").hide();

            userForm.attr("action", "/dashboard/userSettings").attr("method", "POST");

            modalAction.modal("show");
        });

        $(document).on("click", ".btn-edit-user", function() {
            let userId = $(this).data("id");

            modalTitle.text("Edit User");
            submitButton.text("Update User");

            userForm.attr("action", "/dashboard/userSettings/" + userId);
            userForm.find("input[name='_method']").remove();
            userForm.append('<input type="hidden" name="_method" value="PUT">');

            $.ajax({
                url: `/dashboard/userSettings/${userId}/edit`,
                type: "GET",
                success: function(data) {
                    $("#user_id").val(data.id);
                    $("#name").val(data.name);
                    $("#username").val(data.username);
                    $("#divisi_id").val(data.divisi_id);
                    $("#status").val(data.status);
                    $("#level_pengguna").val(data.level_pengguna);
                    $("#oldPasswordField").removeClass("d-none").show();
                    $("label[for='password']").text("New password");
                    $("#password").attr("placeholder", "Enter a new password");

                    oldPasswordField.show();
                    modalAction.modal("show");
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                },
            });
        });
    });

    function togglePasswordVisibility(inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        const isHidden = passwordInput.type === 'password';

        // Toggle input type
        passwordInput.type = isHidden ? 'text' : 'password';

        // Ganti ikon
        icon.setAttribute('icon', isHidden ? 'iconamoon:eye-off' : 'iconamoon:eye');

        // Ganti warna
        icon.classList.remove('text-primary', 'text-muted');
        icon.classList.add(isHidden ? 'text-primary' : 'text-muted');
    }
</script>
