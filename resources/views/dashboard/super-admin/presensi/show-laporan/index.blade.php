<x-Dashboard.main-layout title="{{ $title }}">
    <div class="row g-4">
        <!-- Kolom untuk tabel presensi -->
        <div class="col-lg-12">
            <div class="mb-4">
                <h2 class="mb-5 text-center">Data Arsip Presensi Tanggal : {{ $tanggal }}</h2>

                <div class="d-flex gap-2 flex-wrap mb-3">
                    <a class="btn btn-primary" href="/dashboard/laporan-presensi">Back</a>
                    <a href="{{ route('laporan.exportPdf', $tanggal) }}" class="btn btn-danger">
                        <i class='bx bxs-file-pdf'></i> Download PDF
                    </a>
                    <a href="{{ route('laporan.exportXls', $tanggal) }}" class="btn btn-success ">
                        <i class='bx bxs-file-export'></i> Export ke Excel
                        (.xls)
                    </a>

                    <form action="{{ route('laporan.destroyByTanggal', $tanggal) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger delete-btn"><i class='bx bxs-trash'></i> Hapus
                            Semua</button>
                    </form>
                </div>

                <table id="basic-datatable" class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Divisi</th>
                            <th>Jam Presensi</th>
                            <th>Mulai Presensi</th>
                            <th>Batas Telat</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody id="t-body">
                        @foreach ($laporan as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->qrCode?->nama ?? 'Unknown' }}</td>
                                <td>{{ $item->qrCode?->divisi ?? 'Tidak ada divisi' }}</td>
                                <td>{{ $item->jam_presensi }}</td>
                                <td>{{ $item->waktu_mulai }}</td>
                                <td>{{ $item->batas_telat }}</td>
                                <td>
                                    <span
                                        class="badge 
                                        {{ $item->status == 'Hadir'
                                            ? 'bg-success'
                                            : ($item->status == 'Alpha'
                                                ? 'bg-danger'
                                                : ($item->status == 'Izin'
                                                    ? 'bg-primary'
                                                    : ($item->status == 'Telat'
                                                        ? 'bg-warning text-dark'
                                                        : 'bg-secondary'))) }}">
                                        {{ $item->status }}
                                    </span>
                                <td>
                                    <div class="d-flex align-items-center flex-wrap gap-2">

                                        <form action="{{ route('laporan.destroy', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm delete-btn"><i
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
