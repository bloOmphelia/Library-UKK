<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>

    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@700;800;900&family=DM+Sans:wght@400;500;600;700&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
         :root {
             --dark: #40487A;
            --accent: #ad9a79;
            --primary-bg: #e5e0d8;
            --hero-bg: #f0ebe2;
            --muted: #8e8e8e;
            --radius: 18px;
            --shadow: 0 8px 24px rgba(64, 72, 122, 0.08);
            --shadow-hover: 0 18px 40px rgba(64, 72, 122, 0.15);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        html, body {
            height: 100%;
            zoom: 0.9;
            background-color: #fbfaf8;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            overflow-x: hidden;
        }

        .app-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
            margin-left: 85px;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 0 50px 50px 50px;
            min-height: 100vh;
            overflow: hidden;
            width: 0;
        }

        /* ── PRELOADER ISOMETRIC 3D (SMARTLIB STYLE) ── */
        #preloader {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .book-loader {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 30px;
        }

        .book-container {
            position: relative;
            width: 80px;
            height: 55px;
            transform: rotateX(45deg) rotateZ(-30deg);
            transform-style: preserve-3d;
        }

        .book-base {
            position: absolute;
            width: 100%;
            height: 100%;
            background: var(--accent);
            border-radius: 3px;
            transform: translateZ(-8px);
            box-shadow: 10px 10px 20px rgba(0,0,0,0.15);
        }

        .book-spine {
            position: absolute;
            width: 8px;
            height: 100%;
            left: 0; top: 0;
            background: #8e7d60;
            transform: rotateY(-90deg);
            transform-origin: left;
        }

        .page {
            position: absolute;
            width: 50%;
            height: 100%;
            right: 0; top: 0;
            background: linear-gradient(to right, #f5f5f5 0%, #ffffff 100%);
            transform-origin: left center;
            transform-style: preserve-3d;
            animation: pageFlip3D 1.9s infinite ease-in-out;
            border-radius: 0 3px 3px 0;
            box-shadow: inset 2px 0px 5px rgba(0,0,0,0.05);
        }

        .page:nth-child(1) { animation-delay: 0s; background: var(--accent); }
        .page:nth-child(2) { animation-delay: 0.25s; background: #fdfbf7; }
        .page:nth-child(3) { animation-delay: 0.5s; background: #ffffff; }
        .page:nth-child(4) { animation-delay: 0.75s; background: #f9f6f2; }

        @keyframes pageFlip3D {
            0% { transform: rotateY(0deg); }
            50% { transform: rotateY(-180deg) skewY(-5deg); }
            100% { transform: rotateY(-180deg); }
        }

        .loader-progress-wrap {
            width: 120px;
            height: 3px;
            background: rgba(173,154,121,0.2);
            border-radius: 2px;
            overflow: hidden;
            margin-top: 15px;
        }
        .loader-progress-bar {
            height: 100%;
            background: var(--accent);
            animation: growBar 1.9s ease-in-out infinite;
        }

        @keyframes growBar {
            0% { width: 0%; }
            50% { width: 100%; }
            100% { width: 0%; }
        }

        .loading-text {
            font-size: 11px;
            color: var(--accent);
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-top: 5px;
            font-family: 'DM Sans', sans-serif;
        }

        /* ── TAMBAHAN: CUSTOM TOAST DARI APP 2 ── */
        #toast-wrap {
            position: fixed;
            top: 20px; right: 20px;
            z-index: 99999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            pointer-events: none;
        }
        .tc {
            pointer-events: all;
            display: flex;
            align-items: center;
            gap: 12px;
            background: #fff;
            border-radius: 14px;
            padding: 13px 15px 19px 13px;
            min-width: 280px;
            max-width: 340px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.10), 0 1px 4px rgba(0,0,0,0.05);
            border: 0.5px solid rgba(0,0,0,0.07);
            position: relative;
            overflow: hidden;
            font-family: 'DM Sans', sans-serif;
            animation: tcIn 0.35s cubic-bezier(0.34,1.56,0.64,1) forwards;
        }
        .tc.tc-out { animation: tcOut 0.28s ease-in forwards; }
        @keyframes tcIn  { from { opacity:0; transform:translateX(50px) scale(.95); } to { opacity:1; transform:translateX(0) scale(1); } }
        @keyframes tcOut { from { opacity:1; transform:translateX(0) scale(1); } to { opacity:0; transform:translateX(50px) scale(.95); } }

        .tc .tc-icon {
            width:30px; height:30px; border-radius:50%;
            display:flex; align-items:center; justify-content:center;
            flex-shrink:0; color:#fff; font-size:14px;
        }
        .tc.tc-success .tc-icon { background:#22c55e; }
        .tc.tc-error   .tc-icon { background:#ef4444; }
        .tc.tc-warning .tc-icon { background:#f59e0b; }
        .tc.tc-info    .tc-icon { background:#3b82f6; }

        .tc .tc-msg  { flex:1; font-size:13.5px; font-weight:500; color:#1e1e1e; line-height:1.45; }

        .tc .tc-x {
            background:none; border:none; cursor:pointer;
            color:#bbb; font-size:15px; padding:0;
            line-height:1; align-self:flex-start;
            transition:color .2s;
        }
        .tc .tc-x:hover { color:#555; }

        .tc .tc-bar {
            position:absolute; bottom:0; left:0;
            height:3.5px; border-radius:0 0 14px 14px;
            animation:tcBar linear forwards;
        }
        .tc.tc-success .tc-bar { background:linear-gradient(to right,#16a34a,#bbf7d0); }
        .tc.tc-error   .tc-bar { background:linear-gradient(to right,#dc2626,#fca5a5); }
        .tc.tc-warning .tc-bar { background:linear-gradient(to right,#d97706,#fde68a); }
        .tc.tc-info    .tc-bar { background:linear-gradient(to right,#2563eb,#bfdbfe); }

        @keyframes tcBar { from{width:100%} to{width:0%} }
    </style>
    @stack('styles')
</head>
<body>

    <div id="preloader">
        <div class="book-loader">
            <div class="book-container">
                <div class="book-base"></div>
                <div class="book-spine"></div>
                <div class="page"></div>
                <div class="page"></div>
                <div class="page"></div>
                <div class="page"></div>
            </div>
            <div class="loader-progress-wrap">
                <div class="loader-progress-bar"></div>
            </div>
            <p class="loading-text">Tunggu Sebentar Ya...</p>
        </div>
    </div>

    <!-- TAMBAHAN: Toast Wrapper -->
    <div id="toast-wrap"></div>

    <div class="app-wrapper">
        @include('student.layouts.sidebar')

        <main class="main-content">
            @include('student.layouts.navbar')

            <div class="page-content" data-aos="fade-up" data-aos-duration="800" style="padding-top: 40px;">
                @yield('content')
            </div>
        </main>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- TAMBAHAN: SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <script>
        $(window).on('load', function() {
            // Jeda 400ms agar animasi buku sempat terlihat sempurna
            setTimeout(function() {
                $('#preloader').fadeOut('slow');
            }, 400); 
        });

        AOS.init({ once: true, duration: 800 });

        const sidebar = document.querySelector('.sidebar');
        const mainContent = document.querySelector('.main-content');
        
        if (sidebar && mainContent) {
            sidebar.addEventListener('mouseenter', () => {
                mainContent.style.marginLeft = '260px';
            });
            sidebar.addEventListener('mouseleave', () => {
                mainContent.style.marginLeft = '85px';
            });
        }

        // ── TAMBAHAN: TOAST FUNCTION DARI APP 2 ──
        window.Toast = (function () {
            var wrap = document.getElementById('toast-wrap');
            var icons = {
                success : '<i class="bi bi-check-lg"></i>',
                error   : '<i class="bi bi-x-lg"></i>',
                warning : '<i class="bi bi-exclamation-triangle-fill"></i>',
                info    : '<i class="bi bi-info-circle-fill"></i>',
            };
            function show(msg, type, ms) {
                ms = ms || 3500;
                var el = document.createElement('div');
                el.className = 'tc tc-' + type;
                el.innerHTML =
                    '<span class="tc-icon">'+ icons[type] +'</span>' +
                    '<span class="tc-msg">'  + msg + '</span>' +
                    '<button class="tc-x">&#x2715;</button>' +
                    '<div class="tc-bar" style="animation-duration:'+ ms +'ms"></div>';
                wrap.appendChild(el);
                var t = setTimeout(function(){ dismiss(el); }, ms);
                el.querySelector('.tc-x').addEventListener('click', function(){ clearTimeout(t); dismiss(el); });
            }
            function dismiss(el) {
                if (!el.isConnected) return;
                el.classList.add('tc-out');
                el.addEventListener('animationend', function(){ el.remove(); }, { once: true });
            }
            return {
                success : function(m,ms){ show(m,'success',ms); },
                error   : function(m,ms){ show(m,'error',ms);   },
                warning : function(m,ms){ show(m,'warning',ms); },
                info    : function(m,ms){ show(m,'info',ms);    },
            };
        })();

        $(document).on('click', '.swal-delete', function (e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title            : 'Apakah kamu yakin?',
                text             : 'Data ini akan dihapus permanen!',
                icon             : 'warning',
                showCancelButton : true,
                confirmButtonColor : '#1e1e1e',
                cancelButtonColor  : '#d33',
                confirmButtonText  : 'Ya, Hapus!',
                cancelButtonText   : 'Batal',
            }).then(function (result) {
                if (result.isConfirmed) form.submit();
            });
        });

        $(document).on('click', '.swal-return', function (e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title            : 'Kembalikan Buku?',
                text             : 'Buku ini akan dikembalikan ke perpustakaan dan tidak bisa dibatalkan.',
                icon             : 'question',
                showCancelButton : true,
                confirmButtonColor : '#1e1e1e',
                cancelButtonColor  : '#d33',
                confirmButtonText  : 'Ya, Kembalikan!',
                cancelButtonText   : 'Batal',
            }).then(function (result) {
                if (result.isConfirmed) form.submit();
            });
        });

        // ── TAMBAHAN: FLASH SESSION → Toast ──
        @if(session('success')) Toast.success("{{ session('success') }}"); @endif
        @if(session('error'))   Toast.error("{{ session('error') }}");     @endif
        @if(session('warning')) Toast.warning("{{ session('warning') }}"); @endif
        @if(session('info'))    Toast.info("{{ session('info') }}");       @endif
    </script>

    @stack('scripts')
</body>
</html>