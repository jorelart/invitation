@extends('layouts.admin', ['title' => 'Admin Undangan'])

@section('content')
<main class="container">
    <div class="section-head">
        <div>
            <p class="muted" style="margin:0 0 6px">PANEL PENGELOLAAN</p>
            <h1>Undangan & RSVP</h1>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap">
            <a class="button secondary" href="{{ route('admin.settings.edit') }}">Ubah konten undangan</a>
            <a class="button secondary" href="{{ route('admin.photos.index') }}">Kelola foto</a>
            <a class="button secondary" href="{{ route('admin.whatsapp-message.edit') }}">Custom Pesan</a>
        </div>
    </div>

    @if (session('success'))
        <div class="notice success" role="status">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="notice error" role="alert">{{ $errors->first() }}</div>
    @endif

    <section class="grid stats">
        <div class="card"><div class="stat-label">Total undangan</div><div class="stat-value">{{ $guestCount }}</div></div>
        <div class="card"><div class="stat-label">Total RSVP</div><div class="stat-value">{{ $rsvpCount }}</div></div>
        <div class="card"><div class="stat-label">Akan hadir</div><div class="stat-value">{{ $attendingCount }}</div></div>
        <div class="card"><div class="stat-label">Belum merespons</div><div class="stat-value">{{ $pendingCount }}</div></div>
    </section>

    <section class="grid columns">
        <div class="card">
            <h2>Buat undangan</h2>
            <form method="post" action="{{ route('admin.invitations.store') }}">
                @csrf
                <label for="name">Nama tamu</label>
                <input id="name" name="name" value="{{ old('name') }}" maxlength="120" required>
                @error('name')<div class="form-error">{{ $message }}</div>@enderror

                <label for="phone">Nomor WhatsApp</label>
                <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx" required>
                @error('phone')<div class="form-error">{{ $message }}</div>@enderror

                <label for="max_guests">Maksimal jumlah tamu</label>
                <input id="max_guests" name="max_guests" type="number" min="1" max="20" value="{{ old('max_guests', 1) }}" required>
                @error('max_guests')<div class="form-error">{{ $message }}</div>@enderror

                <button class="full" type="submit">Buat undangan</button>
            </form>
        </div>

        <section class="card">
            <div class="section-head">
                <div><h2 style="margin:0 0 4px">Daftar undangan</h2><div class="muted">Cari nama atau nomor telepon.</div></div>
                <form class="search" method="get" action="{{ route('admin.index') }}">
                    <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari tamu..." aria-label="Cari tamu">
                    <button class="secondary" type="submit">Cari</button>
                </form>
            </div>
            <div class="table-wrap">
                <table>
                    <thead><tr><th>Tamu</th><th>RSVP</th><th>Link undangan</th><th></th></tr></thead>
                    <tbody>
                    @forelse ($guests as $guest)
                        <tr>
                            <td data-label="Tamu"><strong>{{ $guest->name }}</strong><br><span class="muted">{{ $guest->phone }} · Maks. {{ $guest->max_guests }} orang</span></td>
                            <td data-label="RSVP">
                                @if ($guest->rsvp)
                                    <span class="badge {{ $guest->rsvp->presence === 'hadir' ? 'yes' : 'no' }}">{{ $guest->rsvp->presence === 'hadir' ? 'Hadir' : 'Tidak hadir' }}</span>
                                @else <span class="badge">Belum ada</span> @endif
                            </td>
                            <td data-label="Link undangan"><a class="url" href="{{ url('/?inv='.$guest->invitation_token) }}" target="_blank" rel="noopener">{{ url('/?inv='.$guest->invitation_token) }}</a></td>
                            <td data-label="Aksi">
                                <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap">
                                    @php
                                        $invitationUrl = url('/?inv='.$guest->invitation_token);
                                        $waPhone = preg_replace('/\D+/', '', (string) $guest->phone);
                                        $waPhone = str_starts_with($waPhone, '0') ? '62'.substr($waPhone, 1) : $waPhone;
                                        $waMessage = strtr($whatsappMessage, [
                                            '{{ nama_tamu }}' => $guest->name,
                                            '{{ nama_pria & nama_wanita }}' => $invitationSettings['groomName'].' & '.$invitationSettings['brideName'],
                                            '{{ link_undangan }}' => $invitationUrl,
                                        ]);
                                    @endphp
                                    <a class="button" href="https://wa.me/{{ $waPhone }}?text={{ rawurlencode($waMessage) }}" target="_blank" rel="noopener">WhatsApp</a>
                                    <button class="secondary" type="button" data-copy-text="{{ $waMessage }}">Salin Pesan</button>
                                    <form method="post" action="{{ route('admin.invitations.destroy', $guest) }}" onsubmit="return confirm('Hapus undangan {{ $guest->name }}? RSVP terkait juga akan terhapus.')">
                                        @csrf @method('delete')
                                        <button class="danger" type="submit" aria-label="Hapus undangan {{ $guest->name }}" title="Hapus undangan">
                                            <svg aria-hidden="true" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18M8 6V4h8v2m3 0-.9 14H5.9L5 6m4 4v6m6-6v6"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="muted">Belum ada undangan yang cocok.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination">{{ $guests->links() }}</div>
        </section>
    </section>

    <section class="card section" id="rsvps">
        <div class="section-head">
            <div><h2 style="margin:0 0 4px">RSVP & balasan</h2><div class="muted">Balasan yang disimpan akan tampil pada daftar ucapan undangan.</div></div>
            <form class="search" method="get" action="{{ route('admin.index') }}">
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari nama tamu..." aria-label="Cari RSVP">
                <select name="presence" aria-label="Filter kehadiran">
                    <option value="">Semua status</option>
                    <option value="hadir" @selected(request('presence') === 'hadir')>Hadir</option>
                    <option value="tidak" @selected(request('presence') === 'tidak')>Tidak hadir</option>
                </select>
                <button class="secondary" type="submit">Filter</button>
            </form>
        </div>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Tamu</th><th>Status</th><th>Ucapan</th><th>Balasan pemilik</th></tr></thead>
                <tbody>
                @forelse ($rsvps as $rsvp)
                    <tr>
                        <td data-label="Tamu"><strong>{{ $rsvp->guest?->name ?? 'Tamu dihapus' }}</strong><br><span class="muted">{{ $rsvp->created_at?->format('d-m-Y H:i') }}</span></td>
                        <td data-label="Status"><span class="badge {{ $rsvp->presence === 'hadir' ? 'yes' : 'no' }}">{{ $rsvp->presence === 'hadir' ? 'Hadir' : 'Tidak hadir' }}</span><br><span class="muted">{{ $rsvp->guest_count }} orang</span></td>
                        <td data-label="Ucapan" style="min-width:220px;white-space:pre-wrap">{{ $rsvp->message }}</td>
                        <td data-label="Balasan pemilik">
                            <form class="row-form" method="post" action="{{ route('admin.rsvps.reply', $rsvp->guest_id) }}">
                                @csrf @method('patch')
                                <textarea name="owner_reply" maxlength="1000" required placeholder="Tulis balasan...">{{ old('owner_reply', $rsvp->owner_reply) }}</textarea>
                                <button style="margin-top:7px" type="submit">Simpan balasan</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="muted">Belum ada RSVP.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="pagination">{{ $rsvps->links() }}</div>
    </section>
</main>
<script>
    document.addEventListener('click', async (event) => {
        const button = event.target.closest('[data-copy-text]');
        if (!button) return;

        try {
            if (navigator.clipboard && window.isSecureContext) {
                await navigator.clipboard.writeText(button.dataset.copyText);
            } else {
                const input = document.createElement('textarea');
                input.value = button.dataset.copyText;
                input.style.position = 'fixed';
                input.style.opacity = '0';
                document.body.appendChild(input);
                input.select();
                const copied = document.execCommand('copy');
                input.remove();
                if (!copied) throw new Error('Clipboard unavailable');
            }

            button.textContent = 'Tersalin';
            window.setTimeout(() => { button.textContent = 'Salin Pesan'; }, 1600);
        } catch {
            button.textContent = 'Gagal menyalin';
            window.setTimeout(() => { button.textContent = 'Salin Pesan'; }, 1600);
        }
    });
</script>
@endsection
