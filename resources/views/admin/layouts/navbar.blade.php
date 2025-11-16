<nav class="navbar header bg-white shadow-sm">
    <div class="container-fluid">
        <!-- Sidebar toggle button (for small screens) -->
        <button class="btn btn-link d-md-none" id="menu-toggle">
            <i class="bi bi-list" style="font-size:1.25rem"></i>
        </button>

        <!-- Right side -->
        <div class="ms-auto d-flex align-items-center">
            <!-- Notification icon -->
           <!-- 🔔 Notification Bell -->
@php
    use App\Models\Notification;
    use Illuminate\Support\Facades\Auth;

    $user = Auth::user();
    $unreadCount = Notification::where('user_id', $user->id)->where('is_read', false)->count();
    $notifications = Notification::where('user_id', $user->id)->latest()->take(5)->get();
@endphp

<div class="dropdown me-3">
    <a class="text-dark position-relative" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-bell fs-5"></i>
        @if($unreadCount > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ $unreadCount }}
            </span>
        @endif
    </a>

    <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="notificationDropdown" style="width:320px;">
        <li class="dropdown-header fw-bold">Notifications</li>
        @forelse($notifications as $notify)
            <li>
                <a href="{{ route('admin.notifications.index', $notify->id) }}" class="dropdown-item small {{ !$notify->is_read ? 'fw-bold' : '' }}">
                    {{ Str::limit($notify->title, 50) }}
                    <br>
                    <small class="text-muted">{{ $notify->created_at->diffForHumans() }}</small>
                </a>
            </li>
            <li><hr class="dropdown-divider"></li>
        @empty
            <li><p class="dropdown-item text-muted mb-0">No notifications yet</p></li>
        @endforelse

        <li><a class="dropdown-item text-center fw-semibold text-primary" href="{{ route('admin.notifications.index') }}">View All</a></li>
    </ul>
</div>


            <!-- User avatar and name -->
            <div class="d-flex align-items-center">
                <div class="avatar bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-2" style="width:40px; height:40px;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <span class="fw-semibold">{{ Auth::user()->name }}</span>
            </div>
        </div>
    </div>
</nav>
