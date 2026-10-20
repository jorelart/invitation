@extends('layouts.admin', ['title' => 'Login Admin'])

@section('content')
<main class="login-shell">
    <section class="card login-card">
        <p class="muted" style="margin:0 0 8px">PANEL PENGELOLAAN</p>
        <h1>Masuk admin</h1>
        <p class="muted">Masuk untuk mengelola undangan, RSVP, dan balasan.</p>

        @if ($errors->any())
            <div class="notice error" role="alert">{{ $errors->first() }}</div>
        @endif

        <form method="post" action="{{ route('admin.login.store') }}">
            @csrf
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="username" required autofocus>
            <label for="password">Password</label>
            <input id="password" type="password" name="password" autocomplete="current-password" required>
            <label style="display:flex;align-items:center;gap:8px;font-weight:500"><input type="checkbox" name="remember" value="1" style="width:auto"> Ingat saya</label>
            <button class="full" type="submit">Masuk</button>
        </form>
    </section>
</main>
@endsection
