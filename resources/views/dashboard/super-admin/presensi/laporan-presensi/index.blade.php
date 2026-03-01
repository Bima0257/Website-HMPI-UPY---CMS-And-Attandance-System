<x-Dashboard.main-layout title="{{ $title }}">
    <div class="row g-4">
        <!-- Kolom untuk tabel presensi -->
        <div class="col-lg-12">
            <div class="mb-4">
                <h2 class="mb-5 text-center">Data Arsip Presensi</h2>

                <div class="d-flex gap-2 flex-wrap mb-3">
                    <form action="{{ route('laporan.destroyAll') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger delete-btn"><i class='bx bxs-trash'></i> Hapus Semua
                            Data</button>
                    </form>
                </div>

                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Presensi</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody id="t-body">
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->tanggal_presensi }}</td>
                                <td>
                                    <div class="d-flex align-items-center flex-wrap gap-2">
                                        <!-- Tombol Show -->
                                        <a href="/laporan-presensi/{{ $item->tanggal_presensi }}"
                                            class="btn btn-info show-btn d-flex align-items-center justify-content-center"
                                            style="width: 40px; height: 40px;">
                                            <i class='bx bx-show'></i>
                                        </a>

                                        <form action="{{ route('laporan.destroyByTanggal', $item->tanggal_presensi) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger delete-btn"><i
                                                    class='bx bxs-trash'></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

</x-Dashboard.main-layout>
