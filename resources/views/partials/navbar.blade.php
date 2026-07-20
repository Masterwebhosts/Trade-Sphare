<nav class="navbar">

    <div class="nav-container">


        <!-- Logo -->

        <a href="{{ url('/') }}" class="brand">

            <img src="{{ asset('assets/images/logo.png') }}" 
                 alt="أعلاني">

        </a>



        <!-- Mobile Menu Button -->

        <button 
            type="button"
            class="menu-toggle"
            onclick="toggleMenu()"
            aria-label="فتح القائمة">

            ☰

        </button>



        <!-- Navigation Links -->

        <div class="nav-links" id="navLinks">


            <a href="#features">
                المميزات
            </a>


            <a href="#advertisers">
                المعلنون
            </a>


            <a href="#publishers">
                الناشرون
            </a>


            <a href="#api">
                API
            </a>



            @auth


            <a href="{{ url('/dashboard') }}">
                لوحة التحكم
            </a>


            <form method="POST" action="{{ url('/logout') }}">
                @csrf

                <button class="logout-link" type="submit">
                    تسجيل الخروج
                </button>

            </form>



            @else


            <a href="{{ url('/login') }}">
                دخول
            </a>


            <a href="{{ url('/register') }}" 
               class="button primary">

                إنشاء حساب

            </a>



            @endauth



        </div>


    </div>

</nav>