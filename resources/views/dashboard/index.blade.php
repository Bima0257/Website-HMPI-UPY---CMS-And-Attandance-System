<x-Dashboard.main-layout title="{{ $title }}">
    <!-- Start Dashboard Content -->
    <div class="row">

        {{-- Members --}}
        @can('super-admin')
            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-md bg-light bg-opacity-50 rounded">
                                    <iconify-icon icon="mdi:email-outline"
                                        class="fs-32 text-success avatar-title"></iconify-icon>
                                </div>
                            </div>
                            <div class="col-6 text-end">
                                <p class="text-muted mb-0 text-truncate">Pesan Masuk</p>
                                <h3 class="text-dark mt-1 mb-0">{{ $data['unreadMessages'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-0 py-2 bg-light bg-opacity-50">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-danger">{{ $data['allMessages'] }}</span>
                                <span class="text-muted ms-1 fs-12">Total Pesan</span>
                            </div>
                            <a href="/dashboard/dataMemberSections" class="text-reset fw-semibold fs-12">View More</a>
                        </div>
                    </div>
                </div>
            </div>
        @endcan


        {{-- Program Kerja (Admin/User) --}}
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="avatar-md bg-light bg-opacity-50 rounded">
                                <iconify-icon icon="ic:twotone-event"
                                    class="fs-32 text-success avatar-title"></iconify-icon>
                            </div>
                        </div>
                        <div class="col-6 text-end">
                            <p class="text-muted mb-0 text-truncate">Program Kerja</p>
                            @can('super-admin')
                                <h3 class="text-dark mt-1 mb-0">{{ $data['events'] }}</h3>
                            @endcan
                            @can('admin')
                                <h3 class="text-dark mt-1 mb-0">{{ $data['eventUser'] }}</h3>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="card-footer border-0 py-2 bg-light bg-opacity-50">
                    <a href="/dashboard/event" class="text-reset fw-semibold fs-12 ms-auto">View More</a>
                </div>
            </div>
        </div>

        {{-- Users --}}
        @can('super-admin')
            <div class="col-md-6 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="avatar-md bg-light bg-opacity-50 rounded">
                                    <iconify-icon icon="solar:users-group-two-rounded-bold-duotone"
                                        class="fs-32 text-success avatar-title"></iconify-icon>
                                </div>
                            </div>
                            <div class="col-6 text-end">
                                <p class="text-muted mb-0 text-truncate">Users Active</p>
                                <h3 class="text-dark mt-1 mb-0">{{ $data['userActive'] }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer border-0 py-2 bg-light bg-opacity-50">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="text-danger">{{ $data['userNonActive'] }}</span>
                                <span class="text-muted ms-1 fs-12">User Non Active</span>
                            </div>
                            <a href="/dashboard/userSettings" class="text-reset fw-semibold fs-12">View More</a>
                        </div>
                    </div>
                </div>
            </div>
        @endcan

        {{-- Articles --}}
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="avatar-md bg-light bg-opacity-50 rounded">
                                <iconify-icon icon="ooui:articles-rtl"
                                    class="fs-32 text-success avatar-title"></iconify-icon>
                            </div>
                        </div>
                        <div class="col-6 text-end">
                            <p class="text-muted mb-0 text-truncate">Article Published</p>
                            @can('super-admin')
                                <h3 class="text-dark mt-1 mb-0">{{ $data['articlePublished'] }}</h3>
                            @endcan
                            @can('admin')
                                <h3 class="text-dark mt-1 mb-0">{{ $data['articlePublishedUser'] }}</h3>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="card-footer border-0 py-2 bg-light bg-opacity-50">
                    <div class="d-flex align-items-center justify-content-between">
                        @can('super-admin')
                            <div>
                                <span class="text-danger">{{ $data['articleDraft'] }}</span>
                                <span class="text-muted ms-1 fs-12">Article Draft</span>
                            </div>
                        @endcan
                        @can('admin')
                            <div>
                                <span class="text-danger">{{ $data['articleDraftUser'] }}</span>
                                <span class="text-muted ms-1 fs-12">Article Draft</span>
                            </div>
                        @endcan
                        <a href="/dashboard/posts" class="text-reset fw-semibold fs-12">View More</a>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- end row -->
    {{-- Pie Charts --}}
    <div class="row mt-3 mb-3">
        <!-- Pie Chart Member Data -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h4 class="card-title mb-3 anchor" id="member_pie">Members</h4>
                    <div dir="ltr">
                        <div id="memberData_charts" class="apex-charts"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart Post Data -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h4 class="card-title mb-3 anchor" id="post_pie">Articles</h4>
                    <div dir="ltr">
                        <div id="categoryPost_charts" class="apex-charts"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-Dashboard.main-layout>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetch("{{ url('/dashboard/dataMemberSection/chart-data') }}")
            .then(res => res.json())
            .then(data => {
                const labels = data.map(item => item.divisi);
                const series = data.map(item => item.total);

                var options = {
                    chart: {
                        type: 'pie',
                    },
                    series: series,
                    labels: labels,
                    legend: {
                        position: 'bottom'
                    }
                };

                var chart = new ApexCharts(document.querySelector("#memberData_charts"), options);
                chart.render();
            });
    });

    document.addEventListener("DOMContentLoaded", function() {
        fetch("{{ url('/dashboard/posts/chart-data-post') }}")
            .then(res => res.json())
            .then(data => {
                const labels = data.map(item => item.category_name);
                const series = data.map(item => item.total);

                var options = {
                    chart: {
                        type: 'pie',
                    },
                    series: series,
                    labels: labels,
                    legend: {
                        position: 'bottom'
                    }
                };

                var chart = new ApexCharts(document.querySelector("#categoryPost_charts"), options);
                chart.render();
            });
    });
</script>
