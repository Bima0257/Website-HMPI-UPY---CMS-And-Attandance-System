<x-Dashboard.main-layout title="{{ $title }}">
    <div class="col-xxl-12">
        <div class="card position-relative overflow-hidden h-100">
            <div class="card-body">
                <ul class="nav nav-tabs nav-justified mb-3">
                    <li class="nav-item">
                        <a href="/dashboard/message" data-bs-toggle="tab" class="nav-link active">
                            <i class="bx bxs-inbox fs-18 me-2"></i> Messages
                        </a>
                    </li>
                </ul>

                <div class="d-flex gap-2">
                    <form id="delete-all-form" action="{{ route('messages.destroyAll') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger mb-3 delete-all-btn">
                            <i class="bx bx-trash"></i> Delete All
                        </button>
                    </form>

                    <button type="button" class="btn btn-warning mb-3" id="delete-selected">
                        <i class="bx bx-trash"></i> Hapus Terpilih
                    </button>
                </div>

                <div class="tab-content text-muted pt-0">
                    <div class="tab-pane fade show active" id="primaryMail">
                        <div class="table-responsive">
                            <table class="table align-middle table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width:5%">
                                            <input type="checkbox" id="checkAll">
                                        </th>
                                        <th style="width:5%">No</th>
                                        <th>Nama</th>
                                        <th>Pesan</th>
                                        <th style="width:15%">Waktu</th>
                                        <th style="width:10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($messages as $index => $msg)
                                        <tr class="{{ $msg->is_read ? '' : 'fw-bold' }}">
                                            <td>
                                                <input type="checkbox" class="check-item" value="{{ $msg->id }}">
                                            </td>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $msg->name }}
                                                @if (!$msg->is_read)
                                                    <span class="badge bg-primary ms-2">Unread</span>
                                                @endif
                                            </td>
                                            <td class="text-truncate" style="max-width: 250px;">
                                                {{ Str::limit($msg->message, 50) }}
                                            </td>
                                            <td>{{ $msg->created_at->format('d M Y - H:i') }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <button type="button" class="btn btn-sm btn-primary show-message"
                                                        data-id="{{ $msg->id }}" data-bs-toggle="modal"
                                                        data-bs-target="#messageModal">
                                                        <i class="bx bx-show"></i>
                                                    </button>
                                                    <form action="{{ route('messages.destroy', $msg->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger btn-delete">
                                                            <i class="bx bx-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                Menampilkan {{ $messages->firstItem() }} sampai {{ $messages->lastItem() }} dari
                                {{ $messages->total() }} pesan
                            </div>
                            <div>
                                {{ $messages->links('pagination::bootstrap-5') }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="messageModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Pesan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modalContent">Loading...</div>
            </div>
        </div>
    </div>


</x-Dashboard.main-layout>

<script>
    // Show detail pesan
    $(document).on('click', '.show-message', function() {
        let id = $(this).data('id');
        let url = "/dashboard/messages/" + id;


        // tampilkan spinner sebelum data muncul
        $('#modalContent').html(`
                <div class="d-flex justify-content-center align-items-center" style="height:150px;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
         `);


        $.get(url, function(data) {
            let content = `
            <p><strong>Nama:</strong> ${data.name}</p>
            <p><strong>Email:</strong> ${data.email}</p>
            <p><strong>Asal:</strong> ${data.asal}</p>
            <p><strong>Pesan:</strong><br>${data.message}</p>
            <p class="text-muted"><em>Dikirim: ${data.created_at}</em></p>
        `;
            $('#modalContent').html(content);

            // update status pesan jadi read
            $.post("/dashboard/messages/" + id + "/read", {
                _token: "{{ csrf_token() }}"
            }).done(function() {
                let row = $('button.show-message[data-id="' + id + '"]').closest('tr');
                row.removeClass('fw-bold');
                row.find('.badge.bg-primary').remove(); // hapus badge Unread

                // Kurangi badge di sidebar dengan animasi
                let badge = $(".nav-link[href='/dashboard/message'] .badge");
                if (badge.length) {
                    let count = parseInt(badge.text()) - 1;
                    if (count > 0) {
                        badge.fadeOut(200, function() {
                            badge.text(count).fadeIn(200);
                        });
                    } else {
                        badge.fadeOut(300, function() {
                            $(this).remove();
                        });
                    }
                }
            });

        }).fail(function() {
            $('#modalContent').html('<p class="text-danger">Gagal memuat data.</p>');
        });
    });


    // Hapus pesan
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        let form = $(this).closest("form");

        Swal.fire({
            title: 'Yakin hapus data?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); // langsung submit form bawaan Laravel
            }
        });
    });

    $(document).on('click', '.delete-all-btn', function(event) {
        event.preventDefault();

        Swal.fire({
            title: "Yakin ingin menghapus semua Pesan?",
            text: "Semua data Pesan akan dihapus permanen!",
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


    // Check All
    $(document).on('change', '#checkAll', function() {
        $('.check-item').prop('checked', $(this).prop('checked'));
    });

    // Delete Selected
    $(document).on('click', '#delete-selected', function() {
        let ids = [];
        $('.check-item:checked').each(function() {
            ids.push($(this).val());
        });

        if (ids.length === 0) {
            Swal.fire('Oops!', 'Tidak ada pesan yang dipilih.', 'warning');
            return;
        }

        Swal.fire({
            title: "Yakin ingin menghapus pesan terpilih?",
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('messages.destroySelected') }}",
                    type: "DELETE",
                    data: {
                        ids: ids,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        Swal.fire('Berhasil!', res.message, 'success')
                            .then(() => location.reload());
                    },
                    error: function(xhr) {
                        let msg = xhr.responseJSON?.message ||
                            'Terjadi kesalahan pada server.';
                        Swal.fire('Gagal!', msg, 'error');
                    }
                });
            }
        });
    });
</script>
