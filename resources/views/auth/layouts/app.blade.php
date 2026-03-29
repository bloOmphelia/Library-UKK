<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
            background-color: #e5e0d8;
            overflow-x: hidden;
            position: relative;
            min-height: 100vh;
        }

        /* Wave Background Global */
        .bg-wave { 
            position: absolute; 
            right: 0; 
            bottom: 0; 
            height: 70%; 
            z-index: 0; 
            pointer-events: none; 
            opacity: 0.8;
        }

        .floating-icons {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 1;
            pointer-events: none;
            overflow: hidden;
        }

        .floating-icons i {
            position: absolute;
            color: #b8ad9b;
            opacity: 0.2;
            filter: blur(0.4px);
            animation: floatAnim 6s ease-in-out infinite;
        }

        @keyframes floatAnim {
            0%, 100% { transform: translateY(0) rotate(inherit); }
            50% { transform: translateY(-25px) rotate(inherit); }
        }

        /* Posisi Icon */
        .icon-1 { top: 10%; left: 10%; font-size: 45px; transform: rotate(-15deg); }
        .icon-2 { top: 15%; right: 10%; font-size: 50px; transform: rotate(20deg); }
        .icon-3 { bottom: 15%; left: 15%; font-size: 30px; transform: rotate(10deg); }
        .icon-4 { bottom: 10%; right: 15%; font-size: 45px; transform: rotate(-20deg); }
        .icon-5 { top: 40%; right: 5%; font-size: 35px; transform: rotate(15deg); }
        .icon-6 { bottom: 40%; left: 5%; font-size: 38px; transform: rotate(-10deg); }
        .icon-7 { top: 78%; left: 80%; font-size: 25px; transform: rotate(10deg); }
        .icon-8 { top: 45%; left: 25%; font-size: 32px; transform: rotate(15deg); }
        .icon-9 { bottom: 45%; right: 25%; font-size: 35px; transform: rotate(-25deg); }

        .main-content {
            position: relative;
            z-index: 10;
        }

        @media (max-width: 1024px) { 
            .floating-icons { display: none; } 
            .bg-wave { height: 40%; } /* Wave lebih kecil di mobile */
        }
    </style>
    @stack('styles')
</head>
<body>

    {{-- Background Wave --}}
    <img src="{{ asset('images/wave.svg') }}" class="bg-wave" alt="">

    {{-- Floating Icons --}}
    <div class="floating-icons">
        <i class="fas fa-book icon-1" data-aos="fade-up" data-aos-delay="100"></i>
        <i class="fas fa-book-open icon-2" data-aos="zoom-in" data-aos-delay="300"></i>
        <i class="fas fa-bookmark icon-3" data-aos="fade-right" data-aos-delay="500"></i>
        <i class="fas fa-graduation-cap icon-4" data-aos="fade-left" data-aos-delay="200"></i>
        <i class="fas fa-scroll icon-5" data-aos="fade-down" data-aos-delay="400"></i>
        <i class="fas fa-pencil-alt icon-6" data-aos="fade-up" data-aos-delay="600"></i>
        <i class="fas fa-lightbulb icon-7" data-aos="zoom-in" data-aos-delay="150"></i>
        <i class="fas fa-university icon-8" data-aos="fade-up" data-aos-delay="350"></i>
        <i class="fas fa-atlas icon-9" data-aos="fade-left" data-aos-delay="450"></i>
    </div>

    <main class="main-content">
        @yield('content')
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            AOS.init({
                once: true,
                duration: 1000,
                easing: "ease-out-back",
            });
        });
    </script>

    @stack('scripts')
</body>
</html>