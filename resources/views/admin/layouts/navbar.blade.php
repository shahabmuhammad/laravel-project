<nav class="navbar header bg-white shadow-sm">
    <div class="container-fluid">
        <!-- Sidebar toggle button (for mobile) -->
        <button class="btn btn-link d-lg-none" 
                id="menu-toggle" 
                aria-label="Toggle sidebar navigation">
            <i class="bi bi-list" style="font-size:1.5rem"></i>
        </button>

        <!-- Right side -->
        <div class="ms-auto d-flex align-items-center gap-3">
            <!-- Notification icon -->
           <!-- 🔔 Notification Bell -->
@php
    use App\Models\Notification;
    use Illuminate\Support\Facades\Auth;

    $user = Auth::user();
    $unreadCount = Notification::where('user_id', $user->id)->where('is_read', false)->count();
    $notifications = Notification::where('user_id', $user->id)->latest()->take(5)->get();
@endphp

<div class="dropdown">
    <a class="text-dark position-relative" 
       href="#" 
       id="notificationDropdown" 
       role="button" 
       data-bs-toggle="dropdown" 
       aria-expanded="false"
       aria-label="View notifications">
        <i class="bi bi-bell fs-5"></i>
        @if($unreadCount > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ $unreadCount }}
                <span class="visually-hidden">unread notifications</span>
            </span>
        @endif
    </a>

    <ul class="dropdown-menu dropdown-menu-end shadow-sm" 
        aria-labelledby="notificationDropdown" 
        style="width:min(320px, 90vw);">
        <li class="dropdown-header fw-bold">Notifications</li>
        @forelse($notifications as $notify)
            <li>
                <a href="{{ route('admin.notifications.index', $notify->id) }}" 
                   class="dropdown-item small {{ !$notify->is_read ? 'fw-bold' : '' }}">
                    {{ Str::limit($notify->title, 50) }}
                    <br>
                    <small class="text-muted">{{ $notify->created_at->diffForHumans() }}</small>
                </a>
            </li>
            @if(!$loop->last)
            <li><hr class="dropdown-divider"></li>
            @endif
        @empty
            <li><p class="dropdown-item text-muted mb-0">No notifications yet</p></li>
        @endforelse
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item text-center fw-semibold text-primary" href="{{ route('admin.notifications.index') }}">View All</a></li>
    </ul>
</div>


            <!-- User avatar and name -->
            <div class="d-flex align-items-center gap-2">
                <div class="avatar bg-primary text-white rounded-circle d-flex justify-content-center align-items-center" 
                     style="width:40px; height:40px;">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <span class="fw-semibold d-none d-md-inline">{{ Auth::user()->name }}</span>
            </div>
        </div>
    </div>
</nav>

<!-- Add this script at the bottom for sidebar toggle -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');
        
        if (menuToggle && sidebar) {
            menuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('show');
            });
            
            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                if (window.innerWidth < 992) {
                    if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                        sidebar.classList.remove('show');
                    }
                }
            });
        }
    });
</script>
