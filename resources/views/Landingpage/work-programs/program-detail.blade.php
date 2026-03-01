<x-Landingpage.layout title="{{ $title }}">
    @if ($backgrounds)
        <!--<< Breadcrumb Section Start >>-->
        <div class="breadcrumb-wrapper bg-cover"
            style="background-image: url('{{ asset('storage/' . $backgrounds->program_detail) }}');">
            <div class="border-shape">
                <img src="{{ asset('assets/img/element.png') }}" alt="shape-img">
            </div>
            <div class="line-shape">
                <img src="{{ asset('assets/img/line-element.png') }}" alt="shape-img">
            </div>
            <div class="container">
                <div class="page-heading">
                    <h1 class="wow fadeInUp" data-wow-delay=".3s">PROGRAM DETAIL</h1>
                    <ul class="breadcrumb-items wow fadeInUp" data-wow-delay=".5s">
                        <li>
                            <a href="/">
                                Home
                            </a>
                        </li>
                        <li>
                            <i class="fas fa-chevron-right"></i>
                        </li>
                        <li>
                            <a href="/workPrograms">
                                All Programs
                            </a>
                        </li>
                        <li>
                            <i class="fas fa-chevron-right"></i>
                        </li>
                        <li>
                            Project Detail
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    @else
        <!--<< Breadcrumb Section Start >>-->
        <div class="breadcrumb-wrapper bg-cover"
            style="background-image: url('{{ asset('assets/img/default-img/workPrograms-default-bg.jpg') }}');">
            <div class="border-shape">
                <img src="{{ asset('assets/img/element.png') }}" alt="shape-img">
            </div>
            <div class="line-shape">
                <img src="{{ asset('assets/img/line-element.png') }}" alt="shape-img">
            </div>
            <div class="container">
                <div class="page-heading">
                    <h1 class="wow fadeInUp" data-wow-delay=".3s">PROGRAM DETAIL</h1>
                    <ul class="breadcrumb-items wow fadeInUp" data-wow-delay=".5s">
                        <li>
                            <a href="/">
                                Home
                            </a>
                        </li>
                        <li>
                            <i class="fas fa-chevron-right"></i>
                        </li>
                        <li>
                            <a href="/workPrograms">
                                All Programs
                            </a>
                        </li>
                        <li>
                            <i class="fas fa-chevron-right"></i>
                        </li>
                        <li>
                            Project Detail
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    @endif


    <!-- Project Section Start -->
    <section class="Project-details-section fix section-padding">
        <div class="container">
            <div class="project-details-wrapper">
                <div class="row">
                    @if ($detail)
                        <div class="col-lg-12">
                            <div class="project-details-items">
                                <div class="details-image">
                                    <img src="{{ asset('storage/' . $detail->background_image) }}" alt="img">
                                </div>
                                <div class="row g-4 justify-content-between">
                                    <div class="col-lg-7">
                                        <div class="details-content pt-5">
                                            <h3>{{ $detail->judul }}</h3>
                                            <p>{!! $detail->deskripsi !!}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="project-catagory">
                                            <h3>Project Info: </h3>
                                            <ul>
                                                <li>
                                                    Nama Proker:
                                                    <span>{{ $detail->judul }}</span>
                                                </li>
                                                <li>
                                                    Divisi:
                                                    <span>{{ $detail->divisi?->nama_divisi ?? 'Divisi tidak ditemukan' }}</span>
                                                </li>
                                                <li>
                                                    Ketua Pelaksana:
                                                    <span>{{ $detail->ketuaPelaksana?->nama ?? 'Tidak ada ketua pelakasana' }}</span>
                                                </li>
                                                <li>
                                                    Tanggal Pelaksanaan:
                                                    <span>{{ \Carbon\Carbon::parse($detail->tgl_pelaksanaan)->translatedFormat('d F Y') }}</span>
                                                </li>
                                                <li>
                                                    Status:
                                                    <span>{{ $detail->status }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column align-items-center mt-3">
                                <a href="/workPrograms" class="btn btn-outline-primary">Back to All Programs</a>
                            </div>
                        </div>
                    @else
                        <div class="text-center text-warning fw-bold">
                            <i class='bx bx-error'></i> Detail program tidak ditemukan !!
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </section>

</x-Landingpage.layout>
