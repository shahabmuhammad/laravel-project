<nav id="sidebar" class="bg-sidebar d-flex flex-column justify-content-between">
   
    <div class="flex-grow-1 d-flex flex-column overflow-auto">
   
     <div class="d-flex align-items-center px-3 py-3" style="background-color: #066187; border: none;">
    <!-- 🔹 Logo -->
    <div class="flex-shrink-0 d-flex align-items-center justify-content-center"
         style="width: 34px; height: 48px; ">
        <img src="{{ asset('build/admin/assets/img/logo.png') }}" 
             alt="logo" 
             class="logo-img" 
             style="width: 28px; height: auto;">
    </div>

    <!--  Text -->
    <div class="ms-3 text-start">
        <div class="fw-bold text-white lh-sm" style="font-size: 12px; line-height: 1.3;">
            <small class="text-white fw-semibold">
                RESEARCH REPOSITORY<br>
                &amp; SCIENTIST DIRECTORY
            </small>
        </div>
    </div>
</div>


        <!-- Menu -->
        <ul class="list-unstyled components px-2 pt-2 mb-2 flex-grow-1">

            {{--COMMON DASHBOARD--}}
            <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-grid-fill me-2"></i><span>Dashboard</span>
                </a>
            </li>

            {{--ADMIN MENU--}}
            @role('Admin')
                {{-- User Management --}}
                <li>
                    <a href="#userSubmenu" data-bs-toggle="collapse" aria-expanded="false"
                       class="dropdown-toggle">
                        <i class="bi bi-people-fill me-2"></i><span>User Management</span>
                    </a>
                    <ul class="collapse list-unstyled ms-4" id="userSubmenu">
                        <li><a href="{{ route('admin.users.index') }}"><i class="bi bi-person-lines-fill me-2"></i>Manage Users</a></li>
                        <li><a href="{{ route('admin.roles.index') }}"><i class="bi bi-person-badge-fill me-2"></i>Manage Roles</a></li>
                    </ul>
                </li>

                {{-- Research Settings --}}
                <li>
                    <a href="#researchSettings" data-bs-toggle="collapse" aria-expanded="false"
                       class="dropdown-toggle">
                        <i class="bi bi-sliders me-2"></i><span>Research Settings</span>
                    </a>
                    <ul class="collapse list-unstyled ms-4" id="researchSettings">
                        <li><a href="{{ route('admin.researches.index') }}"><i class="bi bi-journal-text me-2"></i>Researches</a></li>
                        {{-- <li><a href="{{ route('admin.authors.index') }}"><i class="bi bi-person-badge me-2"></i>Authors</a></li> --}}
                        <li><a href="{{ route('admin.publishers.index') }}"><i class="bi bi-building me-2"></i>Publishers</a></li>
                        <li><a href="{{ route('admin.categories.index') }}"><i class="bi bi-tags-fill me-2"></i>Categories</a></li>
                        <li><a href="{{ route('admin.types.index') }}"><i class="bi bi-ui-checks me-2"></i>Research Types</a></li>
                    </ul>
                </li>
<li>
    <a href="{{ route('admin.contacts.index') }}"> <i class="bi bi-envelope"></i> Contact Messages
    </a>
</li>

                <li><a href="{{ route('admin.analytics') }}"><i class="bi bi-bar-chart-fill me-2"></i>Analytics</a></li>
                <li><a href="{{ route('admin.profiles.index') }}"><i class="bi bi-person-circle me-2"></i>Profiles</a></li>
                      <li class="{{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}">
                <a href="{{ route('admin.notifications.index') }}">
                    <i class="bi bi-bell-fill me-2"></i>Notifications
                    @php
                        $unread = \App\Models\Notification::where('user_id', Auth::id())->where('is_read', false)->count();
                    @endphp
                    @if($unread > 0)
                        <span class="badge bg-danger ms-2">{{ $unread }}</span>
                    @endif
                </a>
            </li>
            @endrole

            {{--AUTHOR MENU--}}
            @role('Author')
                <li><a href="{{ route('admin.researches.index') }}"><i class="bi bi-journal-text me-2"></i>My Publications</a></li>
                <li><a href="{{ route('admin.researches.create') }}"><i class="bi bi-upload me-2"></i>Upload New Paper</a></li>
                <li><a href="{{ route('admin.analytics') }}"><i class="bi bi-bar-chart-line-fill me-2"></i>Analytics</a></li>
                <li><a href="{{ route('admin.profile.index') }}"><i class="bi bi-person-circle me-2"></i>Profile</a></li>
            @endrole

            {{--USER MENU--}}
            @role('User')
                <li><a href="{{route('front.home')}}"><i class="bi bi-house-fill me-2"></i>Home</a></li>
                <li class="{{ request()->routeIs('admin.bookmark.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.bookmark.index') }}">
                        <i class="bi bi-bookmark-fill me-2"></i>Bookmarks
                    </a>
                </li>
                
                <li><a href="{{ route('admin.profile.index') }}"><i class="bi bi-person-circle me-2"></i>Profile</a></li>
            @endrole

            {{--  COMMON MENU  --}}
      
            <li><a href="{{ route('admin.help') }}"><i class="bi bi-question-circle-fill me-2"></i>Help / Support</a></li>
         

          
            
        </ul>
    </div>

    <!-- Logout  -->
    <div class="px-3 pb-4 border-top border-secondary">
        <a href="{{ route('logout') }}"
           class="text-white text-decoration-none d-flex align-items-center"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-right me-2 fs-5"></i><span>Logout</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </div>
</nav>
