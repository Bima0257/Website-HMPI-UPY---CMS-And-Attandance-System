<x-Dashboard.main-layout title="{{ $title }}">
    <x-Landingpage.layoutShowContent>
        <!-- Project Section Start -->
        <section class="Project-details-section fix">
            <div class="container position-relative">
                <!-- Tombol Back -->
                <div class="position-absolute" style="z-index: 10;">
                    <a href="/dashboard/event" class="btn btn-primary shadow-sm text-white">
                        <i class='bx bx-arrow-back me-2'></i>Back
                    </a>
                </div>
                <div class="project-details-wrapper pt-5 mt-4">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="project-details-items">
                                <div class="details-image mb-4">
                                    <img src="{{ asset('storage/' . $event->background_image) }}" class="img-fluid"
                                        alt="img">
                                </div>
                                <div class="row g-4 justify-content-between">
                                    <div class="col-lg-7">
                                        <div class="details-content pt-5">
                                            <h3>{{ $event->judul }}</h3>
                                            <p>
                                                {!! $event->deskripsi !!}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="project-catagory">
                                            <h3>Project Info: </h3>
                                            <ul>
                                                <li>
                                                    Nama Proker:
                                                    <span>{{ $event->judul }}</span>
                                                </li>
                                                <li>
                                                    Divisi:
                                                    <span>{{ $event->divisi?->nama_divisi ?? 'Tidak ada divisi!' }}</span>
                                                </li>
                                                <li>
                                                    Ketua Pelaksana:
                                                    <span>{{ $event->ketuaPelaksana?->nama ?? 'Tidak ada ketua pelaksana!' }}</span>
                                                </li>
                                                <li>
                                                    Tanggal Pelaksanaan:
                                                    <span>{{ $event->tgl_pelaksanaan }}</span>
                                                </li>
                                                <li>
                                                    Status:
                                                    <span>
                                                        {{ $event->status }}
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </x-Landingpage.layoutShowContent>
</x-Dashboard.main-layout>
