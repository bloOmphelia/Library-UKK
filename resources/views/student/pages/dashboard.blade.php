@extends('student.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div style="
        padding: 40px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        min-height: 100vh;
    ">

    <!-- Greeting -->
    <div style="margin-bottom: 30px;">
        <h1 style="font-size: 28px; font-weight: 600; margin-bottom: 5px; color: #111;">
            Hey, {{ auth()->user()->name }} 👋
        </h1>

        <p style="
            color: #666;
            font-size: 15px;
        ">
            Welcome back to <strong>SmartLib</strong>
        </p>
    </div>

    <div style="
        background: white;
        border-radius: 14px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    ">
    <div style="
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    ">
        <h3 style="margin:0; font-size:16px;">Quick Access</h3>
    </div>

    <div style="
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    ">
        <!-- Menu 1 -->
        <div style="
            border: 1px solid #eee;
            border-radius: 12px;
            padding: 14px;
            cursor: pointer;
            transition: 0.2s;
        ">
            <div style="
                width: 36px;
                height: 36px;
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 10px;
            ">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M4 3C3.44772 3 3 3.44772 3 4V20C3 20.5523 3.44772 21 4 21H14C14.5523 21 15 20.5523 15 20V10.6973L17.0215 20.2076C17.1363 20.7479 17.6673 21.0927 18.2075 20.9779L21.142 20.3541C21.6822 20.2393 22.027 19.7083 21.9122 19.1681L19.0015 5.47402C18.8866 4.9338 18.3556 4.58896 17.8154 4.70378L15 5.30221V5C15 4.44772 14.5523 4 14 4H9C9 3.44772 8.55228 3 8 3H4ZM9 6H13V14H9V6ZM13 16V19H9V16H13ZM7 17V19H5V17H7ZM18.7699 18.8137L18.3541 16.8577L19.3323 16.6498L19.748 18.6058L18.7699 18.8137Z"></path></svg>
            </div>
            <p style="margin:0; font-size:14px; font-weight:600;">
                Borrowed Books
            </p>
            <p style="margin:4px 0 0; font-size:12px; color:#777;">
                0 books
            </p>
        </div>

        <!-- Menu 2 -->
        <div style="
            border: 1px solid #eee;
            border-radius: 12px;
            padding: 14px;
            cursor: pointer;
            transition: 0.2s;
        ">
            <div style="
                width: 36px;
                height: 36px;
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 10px;
            ">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M20.9998 7L16 2H3.9985C3.44749 2 3 2.44405 3 2.9918V21.0082C3 21.5447 3.44476 22 3.9934 22H12.3414C12.1203 21.3744 12 20.7013 12 20C12 16.6863 14.6863 14 18 14C19.0928 14 20.1174 14.2922 20.9999 14.8026L20.9998 7ZM14.4646 19.4647L18.0001 23.0002L22.9498 18.0505L21.5356 16.6362L18.0001 20.1718L15.8788 18.0505L14.4646 19.4647Z"></path></svg>
            </div>
            <p style="margin:0; font-size:14px; font-weight:600;">
                Returned Books
            </p>
            <p style="margin:4px 0; font-size:12px; color:#777;">
                0 books
            </p>
        </div>
    </div>

    <div style="margin-bottom: 40px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 style="font-size: 18px; font-weight: 700; color: #1B2559;">Popular Books</h3>
                    <a href="#" style="color: #4318FF; font-size: 14px; font-weight: 600; text-decoration: none;">View All</a>
                </div>
                
                {{-- <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                    @foreach($popularBooks->take(3) as $book)
                    <div style="background: white; border-radius: 20px; padding: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.02);">
                        <div style="width: 100%; height: 140px; background: #E9EDF7; border-radius: 16px; margin-bottom: 15px; overflow: hidden;">
                            <img src="{{ $book->cover ? asset('storage/'.$book->cover) : 'https://via.placeholder.com/300x200' }}" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <span style="font-size: 12px; color: #4318FF; font-weight: 700; text-transform: uppercase;">{{ $book->category->name ?? 'General' }}</span>
                        <h4 style="font-size: 15px; font-weight: 700; color: #1B2559; margin: 5px 0;">{{ Str::limit($book->title, 20) }}</h4>
                        <p style="font-size: 12px; color: #A3AED0;">{{ $book->transactions_count ?? 0 }} Borrows</p>
                    </div>
                    @endforeach
                </div>
            </div> --}}
</div>
@endsection
