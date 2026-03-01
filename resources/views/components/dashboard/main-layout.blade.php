@props(['title' => 'Dashbooard'])
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Title Meta -->
    <meta charset="utf-8" />
    <title>{{ $title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully responsive premium admin dashboard template" />
    <meta name="author" content="Techzaa" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon"
        href="{{ asset('assets/img/favicon.svg') }}">

    <!-- Vendor css (Require in all Page) -->
    <link href="{{ asset('assets_dashboard/css/vendor.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Icons css (Require in all Page) -->
    <link href="{{ asset('assets_dashboard/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- App css (Require in all Page) -->
    <link href="{{ asset('assets_dashboard/css/app.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Theme Config js (Require in all Page) -->
    <script src="{{ asset('assets_dashboard/js/config.min.js') }}"></script>

    <!-- DataTables Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

</head>

<body>

    <!-- START Wrapper -->
    <div class="wrapper">

        <x-Dashboard.navbar></x-Dashboard.navbar>
        <x-Dashboard.sidebar></x-Dashboard.sidebar>
        <div class="page-content">
            <div class="container-fluid">
                {{ $slot }}
            </div>
            <x-Dashboard.footer></x-Dashboard.footer>
        </div>

    </div>
    <!-- END Wrapper -->

    <!-- jQuery (Wajib untuk DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Vendor Javascript (Require in all Page) -->
    <script src="{{ asset('assets_dashboard/js/vendor.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>



    <!-- App Javascript (Require in all Page) -->
    <script src="{{ asset('assets_dashboard/js/app.js') }}"></script>

    <!-- Dashboard Js -->
    <script src="{{ asset('assets_dashboard/js/pages/dashboard.js') }}"></script>

    <!-- Vector Map Js -->
    <script src="{{ asset('assets_dashboard/vendor/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('assets_dashboard/vendor/jsvectormap/maps/world-merc.js') }}"></script>
    <script src="{{ asset('assets_dashboard/vendor/jsvectormap/maps/world.js') }}"></script>


    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>


    <!-- Quill Editor js -->
    <script src="{{ asset('assets_dashboard/js/components/form-quilljs.js') }}"></script>


    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>


    <!-- Apex Chart Pie Demo js -->
    <script src="{{ asset('assets_dashboard/js/components/apexchart-pie.js') }}"></script>


    <script>
        $(document).ready(function() {
            $('#basic-datatable').DataTable();

            @if ($errors->any())

                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    html: `
                <div style="text-align:left;">
                    @foreach ($errors->all() as $error)
                        <p class="text-danger text-center">{{ $error }}</p>
                    @endforeach
                </div>
            `
                });
            @endif

            // sweet allert
            @if (session('success'))
                const messageId = 'success_message_{{ time() }}';
                if (!sessionStorage.getItem(messageId)) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: '{{ session('success') }}',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                    sessionStorage.setItem(messageId, '1');
                }
            @endif

            @if (session('error'))
                const messageId = 'success_message_{{ time() }}';
                if (!sessionStorage.getItem(messageId)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: '{{ session('error') }}',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK'
                    });
                    sessionStorage.setItem(messageId, '1');
                }
            @endif

            $('.delete-btn').on('click', function(event) {
                event.preventDefault();
                var form = $(this).closest("form");

                Swal.fire({
                    title: "Apakah Anda yakin?",
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Ya, Hapus!",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
            // end sweet allert

        });
    </script>


</body>

</html>
