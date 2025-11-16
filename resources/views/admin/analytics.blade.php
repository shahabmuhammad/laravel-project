@extends('admin.layouts.master')

@section('title', 'Analytics')

@section('content')
<div class="container-fluid  pt-2 px-4 pb-4">
    <h3 class="mb-3">Analytics Overview</h3>
    <p class="text-muted">Insights into publications, authors, and downloads.</p>

    {{-- ==================== CARDS ==================== --}}
    <div class="row gy-3">
        @if($user->hasRole('Admin'))
            <div class="col-md-4">
                <div class="card p-3 text-center">
                    <h4>{{ $analytics['totalPublications'] }}</h4>
                    <p>Total Publications</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 text-center">
                    <h4>{{ $analytics['totalReads'] }}</h4>
                    <p>Total Reads</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 text-center">
                    <h4>{{ $analytics['totalCitations'] }}</h4>
                    <p>Total Citations</p>
                </div>
            </div>
        @elseif($user->hasRole('Author'))
            <div class="col-md-4">
                <div class="card p-3 text-center">
                    <h4>{{ $analytics['allPublications'] }}</h4>
                    <p>All Publications</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 text-center">
                    <h4>{{ $analytics['totalViews'] }}</h4>
                    <p>Total Views</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 text-center">
                    <h4>{{ $analytics['totalCitations'] }}</h4>
                    <p>Total Citations</p>
                </div>
            </div>
        @else
            <div class="col-md-4">
                <div class="card p-3 text-center">
                    <h4>{{ $analytics['papersViewed'] }}</h4>
                    <p>Papers Viewed</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 text-center">
                    <h4>{{ $analytics['downloads'] }}</h4>
                    <p>Papers Downloaded</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 text-center">
                    <h4>{{ $analytics['bookmarked'] }}</h4>
                    <p>Papers Bookmarked</p>
                </div>
            </div>
        @endif
    </div>

    {{-- ==================== CHARTS ==================== --}}
    <div class="row mt-4">
        <div class="col-lg-7">
            <div class="card p-3">
                <h6 class="mb-3">Bar Chart Overview</h6>
                <canvas id="analyticsBarChart" height="120"></canvas>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card p-3">
                <h6 class="mb-3">Category Overview</h6>
                <canvas id="analyticsDonutChart" height="120"></canvas>
            </div>
        </div>
    </div>

    {{-- ==================== MOST VIEWED TABLE FOR USER ==================== --}}
    @if($user->hasRole('User'))
    <div class="card p-3 mt-4">
        <h6 class="mb-3">Most Viewed Papers</h6>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Last Viewed</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($chartData['mostViewed'] as $paper)
                    <tr>
                        <td>{{ $paper->title }}</td>
                        <td>{{ $paper->author->name ?? 'N/A' }}</td>
                        <td>{{ implode(', ', $paper->category_names ?? []) }}</td>
                        <td>{{ $paper->updated_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const role = "{{ $user->getRoleNames()->first() }}";

    const barCtx = document.getElementById('analyticsBarChart').getContext('2d');
    const donutCtx = document.getElementById('analyticsDonutChart').getContext('2d');

    if(role === 'Admin'){
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartData['months']) !!},
                datasets: [{label: 'Reads', data: {!! json_encode($chartData['readsPerMonth']) !!}, backgroundColor: '#2e7bd6'}]
            },
            options: { responsive:true }
        });
        donutCtx.parentNode.style.display = 'none';
    }
    else if(role === 'Author'){
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartData['months']) !!},
                datasets: [{label: 'Views per Month', data: {!! json_encode($chartData['viewsPerMonth']) !!}, backgroundColor: '#2e7bd6'}]
            },
            options: { responsive:true }
        });
        donutCtx.parentNode.style.display = 'none';
    }
    else if(role === 'User'){
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartData['papers']) !!},
                datasets: [{label:'Paper Views', data:{!! json_encode($chartData['views']) !!}, backgroundColor:'#2e7bd6'}]
            },
            options:{ responsive:true }
        });
        new Chart(donutCtx, {
            type:'doughnut',
            data:{
                labels:{!! json_encode($chartData['topCategories']) !!},
                datasets:[{
                    data:{!! json_encode($chartData['categoryCounts']) !!},
                    backgroundColor:['#2e7bd6','#1fb48a','#f4a261','#f94144','#f3722c','#90be6d','#577590']
                }]
            },
            options:{ responsive:true }
        });
    }
});
</script>
@endpush
