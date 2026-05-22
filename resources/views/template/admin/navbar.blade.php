<nav class="navbar">
    <div class="navbar-content">
        {{-- <div class="logo-mini-wrapper">
            <img src="{{ asset('assets/admin/images/logo-mini-light.png') }}" class="logo-mini logo-mini-light"
                alt="logo" />
            <img src="{{ asset('assets/admin/images/logo-mini-dark.png') }}" class="logo-mini logo-mini-dark"
                alt="logo" />
        </div> --}}

        <ul class="navbar-nav">
            <li class="theme-switcher-wrapper nav-item">
                <input type="checkbox" value="" id="theme-switcher" />
                <label for="theme-switcher">
                    <div class="box">
                        <div class="ball"></div>
                        <div class="icons">
                            <i data-lucide="sun"></i>
                            <i data-lucide="moon"></i>
                        </div>
                    </div>
                </label>
            </li>

            @php
                $user = auth()->user();
            @endphp

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="w-30px h-30px ms-1 rounded-circle"
                        src="{{ $user->gambar ? asset('storage/' . $user->gambar) : asset('assets/admin/images/favicon.png') }}"
                        alt="">
                </a>

                <div class="dropdown-menu p-0" aria-labelledby="profileDropdown">
                    <div class="d-flex flex-column align-items-center border-bottom px-5 py-3">
                        <div class="mb-3">
                            <img class="w-80px h-80px rounded-circle"
                                src="{{ $user->gambar ? asset('storage/' . $user->gambar) : asset('assets/admin/images/favicon.png') }}"
                                alt="">
                        </div>
                        <div class="text-center">
                            <p class="fs-16px fw-bolder">{{ $user->name }}</p>
                            <p class="fs-12px text-secondary">
                                {{ $user->email }}
                            </p>
                        </div>
                    </div>
                    <ul class="list-unstyled p-1">
                        {{-- <li>
                            <a href="pages/general/profile.html" class="dropdown-item py-2 text-body ms-0">
                                <i class="me-2 icon-md" data-lucide="user"></i>
                                <span>Profile</span>
                            </a>
                        </li> --}}
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf

                                <button type="submit"
                                    class="dropdown-item py-2 text-body ms-0 border-0 bg-transparent w-100 text-start">
                                    <i class="me-2 icon-md" data-lucide="log-out"></i>
                                    <span>Log Out</span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>

        <a href="#" class="sidebar-toggler">
            <i data-lucide="menu"></i>
        </a>
    </div>
</nav>
