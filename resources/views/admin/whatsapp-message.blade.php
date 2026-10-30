@extends('layouts.admin', ['title' => 'Template Pesan Undangan'])

@section('content')
<main class="container">
    <div class="section-head">
        <div><p class="muted" style="margin:0 0 6px">PANEL PENGELOLAAN</p><h1>Template pesan undangan</h1></div>
        <a class="button secondary" href="{{ route('admin.index') }}">Kembali ke admin</a>
    </div>

    @if (session('success'))<div class="notice success" role="status">{{ session('success') }}</div>@endif
    @if ($errors->any())<div class="notice error" role="alert">{{ $errors->first() }}</div>@endif

    <section class="card section">
        <p>Template ini dipakai untuk WhatsApp dan Instagram. WhatsApp dapat dibuka dengan pesan terisi; untuk Instagram, salin pesan lalu tempelkan ke Direct Message. Placeholder yang tersedia:</p>
        <ul>
            <li><code>&#123;&#123; nama_tamu &#125;&#125;</code> untuk nama tamu</li>
            <li><code>&#123;&#123; nama_pria &amp; nama_wanita &#125;&#125;</code> untuk nama pasangan</li>
            <li><code>&#123;&#123; link_undangan &#125;&#125;</code> untuk link undangan tamu</li>
        </ul>
        <form method="post" action="{{ route('admin.whatsapp-message.update') }}">
            @csrf @method('put')
            <label for="message">Isi pesan undangan</label>
            <textarea id="message" name="message" rows="20" maxlength="10000" required>{{ old('message', $message) }}</textarea>
            <button type="submit" style="margin-top:14px">Simpan template</button>
        </form>
        <form method="post" action="{{ route('admin.whatsapp-message.reset') }}" style="margin-top:10px" onsubmit="return confirm('Kembalikan template ke pesan bawaan?')">
            @csrf @method('delete')
            <button class="secondary" type="submit">Kembalikan pesan bawaan</button>
        </form>
    </section>
</main>
@endsection
