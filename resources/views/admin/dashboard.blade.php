@extends('admin.layouts.master')
@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid p-4 ">

        {{--  COMMON HEADER  --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 class="mb-0 title fw-bold">Welcome Back, {{ Auth::user()->name }}!</h2>
                <p class="text-muted sub mb-0">
                    @role('Admin')
                        Overview of repository activity and performance
                    @endrole
                    @role('Author')
                        Your publications overview and analytics
                    @endrole
                    @role('User')
                        Your research activity and reading summary
                    @endrole
                </p>
            </div>
            @php
                $unreadCount = \App\Models\Notification::where('user_id', Auth::id())->where('is_read', false)->count();
            @endphp
            @if ($unreadCount > 0)
                <div>
                    <a href="{{ route('admin.notifications.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-bell"></i> {{ $unreadCount }} Notification{{ $unreadCount > 1 ? 's' : '' }}
                    </a>
                </div>
            @endif
        </div>

        {{--  ADMIN DASHBOARD  --}}
        @role('Admin')
            @if (isset($totalPublications))
                <div class="row stats-row gx-3 gy-3 my-3">
                    @php
                        $stats = [
                            [
                                'label' => 'Total Publications',
                                'number' => $totalPublications ?? 0,
                                'icon' => 'bi-journal-text',
                                'color' => 'primary',
                            ],
                            [
                                'label' => 'Pending Approvals',
                                'number' => $pendingApprovals ?? 0,
                                'icon' => 'bi-clock-history',
                                'color' => 'warning',
                            ],
                            [
                                'label' => 'Total Downloads',
                                'number' => number_format($totalDownloads ?? 0),
                                'icon' => 'bi-download',
                                'color' => 'success',
                            ],
                            [
                                'label' => 'Total Views',
                                'number' => number_format($totalViews ?? 0),
                                'icon' => 'bi-eye',
                                'color' => 'info',
                            ],
                            [
                                'label' => 'Active Authors',
                                'number' => $activeAuthors ?? 0,
                                'icon' => 'bi-people',
                                'color' => 'secondary',
                            ],
                            [
                                'label' => 'Total Users',
                                'number' => $totalUsers ?? 0,
                                'icon' => 'bi-person-check',
                                'color' => 'dark',
                            ],
                        ];
                    @endphp
                    @foreach ($stats as $item)
                        <div class="col-md-4 col-lg-2">
                            <div class="card stat-card shadow-sm border-0 h-100">
                                <div class="card-body text-center">
                                    <i class="bi {{ $item['icon'] }} fs-2 text-{{ $item['color'] }} mb-2"></i>
                                    <div class="stat-number fw-bold">{{ $item['number'] }}</div>
                                    <div class="stat-label text-muted small">{{ $item['label'] }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Charts Row --}}
                <div class="row gx-3 gy-3 align-items-stretch mb-4">
                    <div class="col-lg-8">
                        <div class="card chart-card p-4 shadow-sm border-0 h-100">
                            <h6 class="card-title mb-3 fw-bold"><i class="bi bi-graph-up me-2"></i>Research Submissions Trend
                                (Last 6 Months)</h6>
                            <div style="height:280px"><canvas id="monthlyTrendChart"></canvas></div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card chart-card p-4 shadow-sm border-0 h-100">
                            <h6 class="card-title mb-3 fw-bold"><i class="bi bi-pie-chart me-2"></i>Research by Status</h6>
                            <div style="height:280px"><canvas id="statusPieChart"></canvas></div>
                        </div>
                    </div>
                </div>

                {{-- Second Charts Row --}}
                <div class="row gx-3 gy-3 align-items-stretch mb-4">
                    <div class="col-lg-6">
                        <div class="card chart-card p-4 shadow-sm border-0 h-100">
                            <h6 class="card-title mb-3 fw-bold"><i class="bi bi-bar-chart me-2"></i>Top 5 Categories</h6>
                            <div style="height:280px"><canvas id="categoryBarChart"></canvas></div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card chart-card p-4 shadow-sm border-0 h-100">
                            <h6 class="card-title mb-3 fw-bold"><i class="bi bi-trophy me-2"></i>Most Downloaded Research</h6>
                            <div style="height:280px"><canvas id="downloadBarChart"></canvas></div>
                        </div>
                    </div>
                </div>

                {{-- Recent Submissions Table --}}
                <div class="card p-4 shadow-sm border-0">
                    <h6 class="mb-3 fw-bold"><i class="bi bi-clock-history me-2"></i>Recent Submissions</h6>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Status</th>
                                    <th>Downloads</th>
                                    <th>Views</th>
                                    <th>Published Date</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentSubmissions ?? [] as $item)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold">{{ Str::limit($item->title, 50) }}</div>
                                        </td>

                                        <td>{{ $item->user->name ?? 'N/A' }}</td>
                                        <td>
                                            @php
                                                $statusColors = [
                                                    'published' => 'success',
                                                    'draft' => 'secondary',
                                                    'submitted' => 'warning',
                                                    'rejected' => 'danger',
                                                ];
                                                $statusColor = $statusColors[$item->status] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $statusColor }}">{{ ucfirst($item->status) }}</span>
                                        </td>
                                        <td><span class="badge bg-light text-dark"><i class="bi bi-download"></i>
                                                {{ number_format($item->downloads ?? 0) }}</span></td>
                                        <td><span class="badge bg-light text-dark"><i class="bi bi-eye"></i>
                                                {{ number_format($item->views ?? 0) }}</span></td>
                                        <td class="text-muted small">{{ $item->created_at->format('M d, Y') }}</td>
                                        {{-- <td>
                                            <a href="{{ route('admin.researches.show', encrypt($item->id)) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i> View
                                            </a>
                                        </td> --}}
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-3">No submissions found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Most Viewed Research --}}
                {{-- <div class="card p-4 shadow-sm border-0 mt-4">
                    <h6 class="mb-3 fw-bold"><i class="bi bi-eye-fill me-2"></i>Most Viewed Research Papers</h6>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Views</th>
                                    <th>Downloads</th>
                                    <th>Viewed Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mostViewed ?? [] as $index => $paper)
                                    <tr>
                                        <td class="fw-bold">{{ $index + 1 }}</td>
                                        <td>{{ Str::limit($paper->title, 60) }}</td>
                                        <td>{{ $item->user->name ?? 'N/A' }}</td>
                                        <td><span class="badge bg-info"><i class="bi bi-eye"></i>
                                                {{ number_format($paper->views ?? 0) }}</span></td>
                                        <td><span class="badge bg-success"><i class="bi bi-download"></i>
                                                {{ number_format($paper->downloads ?? 0) }}</span></td>
                                        <td class="text-muted small">{{ $paper->created_at->format('M d, Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-3">No data available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div> --}}
            @else
                <div class="alert alert-warning">
                    <strong>No data available.</strong> Admin statistics are not loading. Please check that you're logged in as
                    an Admin user.
                </div>
            @endif
        @endrole


        {{--  AUTHOR DASHBOARD  --}}
        @role('Author')
            <section class="mt-4">

                {{-- Notification Alert --}}
                <div class="alert alert-info d-flex justify-content-between align-items-center mt-3">
                    <span>You have <strong>{{ $unreadCount }}</strong> unread notifications.</span>
                    <a href="{{ route('admin.notifications.index') }}" class="btn btn-sm btn-outline-primary">View</a>
                </div>

                {{-- Analytics Cards --}}
                <div class="row g-3 mt-4">
                    <div class="col-md-4">
                        <div class="card p-3 text-center shadow-sm border-0">
                            <h4 class="fw-bold mb-0">{{ $analytics['allPublications'] ?? 0 }}</h4>
                            <p class="text-muted mb-0">All Publications</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card p-3 text-center shadow-sm border-0">
                            <h4 class="fw-bold mb-0">{{ $analytics['totalViews'] ?? 0 }}</h4>
                            <p class="text-muted mb-0">Total Views</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card p-3 text-center shadow-sm border-0">
                            <h4 class="fw-bold mb-0">{{ $analytics['totalCitations'] ?? 0 }}</h4>
                            <p class="text-muted mb-0">Total Citations</p>
                        </div>
                    </div>
                </div>

                {{-- Charts Row --}}
                <div class="row mt-4 d-flex flex-wrap">
                    <div class="col-lg-7 col-md-12 mb-3">
                        <div class="card p-3 shadow-sm border-0" style="height:300px">
                            <h6 class="mb-3 fw-semibold">Bar Chart Overview</h6>
                            <canvas id="analyticsBarChart"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-12 mb-3">
                        <div class="card p-3 shadow-sm border-0" style="height:300px">
                            <h6 class="mb-3 fw-semibold">Category Overview</h6>
                            <canvas id="analyticsDonutChart"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Most Viewed Papers --}}
                <div class="card shadow-sm border-0 p-3">
                    <div
                        class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-3">
                        <h5 class="fw-semibold mb-2 mb-sm-0">Most Viewed Papers</h5>
                        <select class="form-select w-auto">
                            <option>Last week</option>
                            <option>Last month</option>
                            <option>Last quarter</option>
                        </select>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Title</th>
                                    <th>Views</th>
                                    <th>Citations</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mostViewedPapers ?? [] as $paper)
                                    <tr>
                                        <td>{{ $paper->title }}</td>
                                        <td>{{ $paper->views ?? rand(100, 400) }}</td>
                                        <td>{{ $paper->citations ?? rand(5, 35) }}</td>
                                        <td>{{ $paper->created_at->format('M d, Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </section>
        @endrole



        {{-- USER DASHBOARD --}}
        @role('User')
            <div class="my-4">

                {{-- Stats Cards --}}
                <div class="row g-3 mb-4">
                    <div class="col-sm-6 col-lg-4">
                        <div class="card stat-card shadow-sm border-0 h-100">
                            <div class="card-body text-center p-4">
                                <i class="bi bi-bookmark-fill fs-2 text-primary mb-3"></i>
                                <div class="stat-number fw-bold">{{ $bookmarks ?? 0 }}</div>
                                <div class="stat-label text-muted">Bookmarks</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="card stat-card shadow-sm border-0 h-100">
                            <div class="card-body text-center p-4">
                                <i class="bi bi-download fs-2 text-success mb-3"></i>
                                <div class="stat-number fw-bold">{{ $downloads ?? 0 }}</div>
                                <div class="stat-label text-muted">Total Downloads</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="card stat-card shadow-sm border-0 h-100">
                            <div class="card-body text-center p-4">
                                <i class="bi bi-eye-fill fs-2 text-info mb-3"></i>
                                <div class="stat-number fw-bold">{{ $papersViewed ?? 0 }}</div>
                                <div class="stat-label text-muted">Papers Viewed</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Search Bar --}}
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-body p-4">
                        <h6 class="mb-3 fw-bold"><i class="bi bi-search me-2"></i>Search Research Papers</h6>
                        <form method="GET" action="{{ route('admin.dashboard') }}" class="row g-3 align-items-end">
                            <div class="col-md-5">
                                <label for="search" class="form-label small text-muted">Search Query</label>
                                <input type="text" id="search" name="search" value="{{ request('search') }}"
                                    class="form-control" placeholder="Search by title, author, or keyword">
                            </div>
                            <div class="col-md-5">
                                <label for="category" class="form-label small text-muted">Category</label>
                                <select id="category" name="category" class="form-select">
                                    <option value="">All Categories</option>
                                    @foreach ($categories ?? [] as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ request('category') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn w-100 text-white" style="background-color:#066187;">
                                    <i class="bi bi-search me-1"></i>Search
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Most Viewed Papers --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-light border-0 py-3">
                        <h6 class="mb-0 fw-bold"><i class="bi bi-eye-fill me-2"></i>My Recently Viewed Papers</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="px-4">Title</th>
                                        <th>Author</th>
                                        <th>Category</th>
                                        <th>My Views</th>
                                        <th>Last Viewed</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($chartData['mostViewed'] ?? [] as $paper)
                                        <tr>
                                            <td class="px-4">
                                                <div class="fw-semibold text-dark">
                                                    {{ Str::limit($paper->title ?? 'Untitled', 50) }}</div>
                                            </td>
                                            <td>
                                                <span class="text-muted">{{ $paper->user->name ?? 'N/A' }}</span>
                                            </td>
                                            <td>
                                                @if (isset($paper->categories) && $paper->categories->count() > 0)
                                                    <span class="badge bg-light text-dark border">
                                                        {{ $paper->categories->first()->name }}
                                                    </span>
                                                    @if ($paper->categories->count() > 1)
                                                        <span
                                                            class="badge bg-light text-dark border">+{{ $paper->categories->count() - 1 }}</span>
                                                    @endif
                                                @else
                                                    <span class="text-muted small">No category</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-info">
                                                    <i class="bi bi-eye me-1"></i>{{ $paper->user_views ?? 1 }}
                                                </span>
                                            </td>
                                            <td class="text-muted small">
                                                {{ isset($paper->last_viewed_at) ? \Carbon\Carbon::parse($paper->last_viewed_at)->format('M d, Y H:i') : 'N/A' }}
                                            </td>
                                            <td>
                                                <a href="{{ route('front.publication.show', ['research' => $paper->slug ?? $paper->id]) }}"
                                                    class="btn btn-sm btn-outline-primary" target="_blank">
                                                    <i class="bi bi-eye me-1"></i>View
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">
                                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                                No viewed papers yet. Start exploring research papers!
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                {{-- Bookmarks & Downloads --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-light border-0 py-3">
                        <h6 class="mb-0 fw-bold"><i class="bi bi-download me-2"></i>My Downloaded Papers</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Category</th>
                                        <th>Times Downloaded</th>
                                        <th>Last Downloaded</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($chartData['myDownloads'] ?? [] as $paper)
                                        <tr>
                                            <td>{{ Str::limit($paper->title ?? 'Untitled', 50) }}</td>
                                            <td>{{ $paper->user->name ?? 'N/A' }}</td>
                                            <td>
                                                @if ($paper->categories->count() > 0)
                                                    <span
                                                        class="badge bg-light text-dark border">{{ $paper->categories->first()->name }}</span>
                                                    @if ($paper->categories->count() > 1)
                                                        <span
                                                            class="badge bg-light text-dark border">+{{ $paper->categories->count() - 1 }}</span>
                                                    @endif
                                                @else
                                                    <span class="text-muted small">No category</span>
                                                @endif
                                            </td>
                                            <td>{{ $paper->download_count ?? 1 }}</td>
                                            <td>{{ $paper->last_downloaded_at ? \Carbon\Carbon::parse($paper->last_downloaded_at)->format('M d, Y H:i') : 'N/A' }}
                                            </td>
                                            <td>
                                                <button class="btn btn-sm bookmark-btn" data-id="{{ $paper->id }}"
                                                    style="border:none;background:transparent;">
                                                    @if (auth()->user()->bookmarks()->where('research_id', $paper->id)->exists())
                                                        <i class="bi bi-bookmark-fill text-primary fs-5"></i>
                                                    @else
                                                        <i class="bi bi-bookmark text-muted fs-5"></i>
                                                    @endif
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">
                                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>No papers found!
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endrole

        </div>
    @endsection

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Bookmark toggle
                document.querySelectorAll('.bookmark-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.dataset.id;
                        const icon = this.querySelector('i');
                        fetch("{{ url('admin/bookmark/toggle') }}/" + id, {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Accept": "application/json"
                            }
                        }).then(res => res.json()).then(data => {
                            if (icon.classList.contains('bi-bookmark')) {
                                icon.classList.remove('bi-bookmark', 'text-muted');
                                icon.classList.add('bi-bookmark-fill', 'text-primary');
                            } else {
                                icon.classList.remove('bi-bookmark-fill', 'text-primary');
                                icon.classList.add('bi-bookmark', 'text-muted');
                            }
                            console.log(data.message);
                        });
                    });
                });
                @role('Admin')
                    const monthlyTrendCtx = document.getElementById("monthlyTrendChart");
                    if (monthlyTrendCtx) {
                        new Chart(monthlyTrendCtx, {
                            type: "line",
                            data: {
                                labels: @json($monthlyData->pluck('month')->toArray() ?? []),
                                datasets: [{
                                    label: "Research Submissions",
                                    data: @json($monthlyData->pluck('count')->toArray() ?? []),
                                    backgroundColor: "rgba(46, 123, 214, 0.1)",
                                    borderColor: "#2e7bd6",
                                    borderWidth: 3,
                                    fill: true,
                                    tension: 0.4,
                                    pointBackgroundColor: "#2e7bd6",
                                    pointBorderColor: "#fff",
                                    pointBorderWidth: 2,
                                    pointRadius: 5,
                                    pointHoverRadius: 7
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: true,
                                        position: 'top'
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        grid: {
                                            color: 'rgba(0,0,0,0.05)'
                                        }
                                    },
                                    x: {
                                        grid: {
                                            display: false
                                        }
                                    }
                                }
                            }
                        });
                    }

                    const statusPieCtx = document.getElementById("statusPieChart");
                    if (statusPieCtx) {
                        new Chart(statusPieCtx, {
                            type: "doughnut",
                            data: {
                                labels: ['Published', 'Draft', 'Submitted', 'Rejected'],
                                datasets: [{
                                    data: [
                                        {{ $researchByStatus['published'] ?? 0 }},
                                        {{ $researchByStatus['draft'] ?? 0 }},
                                        {{ $researchByStatus['submitted'] ?? 0 }},
                                        {{ $researchByStatus['rejected'] ?? 0 }}
                                    ],
                                    backgroundColor: ['#28a745', '#6c757d', '#ffc107', '#dc3545'],
                                    borderColor: '#fff',
                                    borderWidth: 2
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false
                            }
                        });
                    }

                    const categoryBarCtx = document.getElementById("categoryBarChart");
                    if (categoryBarCtx) {
                        new Chart(categoryBarCtx, {
                            type: "bar",
                            data: {
                                labels: @json($topCategories->pluck('name')->toArray() ?? []),
                                datasets: [{
                                    label: "Number of Research Papers",
                                    data: @json($topCategories->pluck('researches_count')->toArray() ?? []),
                                    backgroundColor: [
                                        'rgba(46, 123, 214, 0.8)',
                                        'rgba(31, 180, 138, 0.8)',
                                        'rgba(244, 162, 97, 0.8)',
                                        'rgba(255, 99, 132, 0.8)',
                                        'rgba(153, 102, 255, 0.8)'
                                    ],
                                    borderColor: [
                                        '#2e7bd6',
                                        '#1fb48a',
                                        '#f4a261',
                                        '#ff6384',
                                        '#9966ff'
                                    ],
                                    borderWidth: 2,
                                    borderRadius: 8,
                                    barThickness: 50
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false
                            }
                        });
                    }

                    const downloadBarCtx = document.getElementById("downloadBarChart");
                    if (downloadBarCtx) {
                        new Chart(downloadBarCtx, {
                            type: "bar",
                            data: {
                                labels: @json($mostDownloaded->map(fn($r) => Str::limit($r->title, 25))->toArray() ?? []),
                                datasets: [{
                                    label: "Downloads",
                                    data: @json($mostDownloaded->pluck('downloads')->toArray() ?? []),
                                    backgroundColor: 'rgba(40, 167, 69, 0.8)',
                                    borderColor: '#28a745',
                                    borderWidth: 2,
                                    borderRadius: 8,
                                    barThickness: 40
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                indexAxis: 'y'
                            }
                        });
                    }
                @endrole

                // Author Dashboard Charts (keeping existing)
                @role('Author')
                    const analyticsBarCtx = document.getElementById("analyticsBarChart");
                    const analyticsDonutCtx = document.getElementById("analyticsDonutChart");

                    if (analyticsBarCtx) {
                        new Chart(analyticsBarCtx, {
                            type: "bar",
                            data: {
                                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                                datasets: [{
                                    label: "Publications",
                                    data: [12, 19, 15, 25, 22, 30],
                                    backgroundColor: "#2e7bd6",
                                    borderRadius: 8
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: false
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            precision: 0
                                        }
                                    }
                                }
                            }
                        });
                    }

                    if (analyticsDonutCtx) {
                        new Chart(analyticsDonutCtx, {
                            type: "doughnut",
                            data: {
                                labels: ["IT", "Medicine", "Environment"],
                                datasets: [{
                                    data: [50, 30, 20],
                                    backgroundColor: ["#2e7bd6", "#1fb48a", "#f4a261"]
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'bottom'
                                    }
                                }
                            }
                        });
                    }
                @endrole
            });
        </script>
    @endpush
