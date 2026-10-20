@extends('layouts.admin', ['title' => 'Pengaturan Undangan'])

@section('content')
<main class="container">
    <div class="section-head">
        <div>
            <p class="muted" style="margin:0 0 6px">PANEL PENGELOLAAN</p>
            <h1>Konten undangan</h1>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap">
            <a class="button secondary" href="{{ route('admin.photos.index') }}">Kelola foto</a>
            <a class="button secondary" href="{{ route('admin.index') }}">Kembali ke admin</a>
        </div>
    </div>

    @if (session('success'))
        <div class="notice success" role="status">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="notice error" role="alert">{{ $errors->first() }}</div>
    @endif

    @php($eventValues = old('events', $settings['events']))
    <form method="post" action="{{ route('admin.settings.update') }}">
        @csrf
        @method('put')

        <section class="card section">
            <h2>Judul halaman</h2>
            <label for="title">Judul browser dan halaman</label>
            <input id="title" name="title" value="{{ old('title', $settings['title']) }}" maxlength="160" required>
            @error('title')<div class="form-error">{{ $message }}</div>@enderror
        </section>

        <section class="card section">
            <h2>Mempelai wanita</h2>
            <div class="grid form-grid-2">
                <div><label for="brideName">Nama panggilan</label><input id="brideName" name="brideName" value="{{ old('brideName', $settings['brideName']) }}" required>@error('brideName')<div class="form-error">{{ $message }}</div>@enderror</div>
                <div><label for="brideFullName">Nama lengkap</label><input id="brideFullName" name="brideFullName" value="{{ old('brideFullName', $settings['brideFullName']) }}" required>@error('brideFullName')<div class="form-error">{{ $message }}</div>@enderror</div>
                <div><label for="brideInstagram">Instagram (tanpa @)</label><input id="brideInstagram" name="brideInstagram" value="{{ old('brideInstagram', $settings['brideInstagram']) }}">@error('brideInstagram')<div class="form-error">{{ $message }}</div>@enderror</div>
                <div><label for="brideParent">Keterangan orang tua</label><textarea id="brideParent" name="brideParent" required>{{ old('brideParent', $settings['brideParent']) }}</textarea>@error('brideParent')<div class="form-error">{{ $message }}</div>@enderror</div>
            </div>
        </section>

        <section class="card section">
            <h2>Mempelai pria</h2>
            <div class="grid form-grid-2">
                <div><label for="groomName">Nama panggilan</label><input id="groomName" name="groomName" value="{{ old('groomName', $settings['groomName']) }}" required>@error('groomName')<div class="form-error">{{ $message }}</div>@enderror</div>
                <div><label for="groomFullName">Nama lengkap</label><input id="groomFullName" name="groomFullName" value="{{ old('groomFullName', $settings['groomFullName']) }}" required>@error('groomFullName')<div class="form-error">{{ $message }}</div>@enderror</div>
                <div><label for="groomInstagram">Instagram (tanpa @)</label><input id="groomInstagram" name="groomInstagram" value="{{ old('groomInstagram', $settings['groomInstagram']) }}">@error('groomInstagram')<div class="form-error">{{ $message }}</div>@enderror</div>
                <div><label for="groomParent">Keterangan orang tua</label><textarea id="groomParent" name="groomParent" required>{{ old('groomParent', $settings['groomParent']) }}</textarea>@error('groomParent')<div class="form-error">{{ $message }}</div>@enderror</div>
            </div>
        </section>

        <section class="card section">
            <h2>Akad nikah</h2>
            <div class="grid form-grid-2">
                <div><label for="weddingDate">Tanggal</label><input id="weddingDate" name="weddingDate" value="{{ old('weddingDate', $settings['weddingDate']) }}" placeholder="16 November 2026" required>@error('weddingDate')<div class="form-error">{{ $message }}</div>@enderror</div>
                <div><label for="weddingTime">Waktu</label><input id="weddingTime" name="weddingTime" value="{{ old('weddingTime', $settings['weddingTime']) }}" placeholder="09:00 WIB" required>@error('weddingTime')<div class="form-error">{{ $message }}</div>@enderror</div>
                <div><label for="weddingLocation">Nama tempat</label><input id="weddingLocation" name="weddingLocation" value="{{ old('weddingLocation', $settings['weddingLocation']) }}">@error('weddingLocation')<div class="form-error">{{ $message }}</div>@enderror</div>
                <div><label for="weddingMapLink">Link Google Maps</label><input id="weddingMapLink" type="url" name="weddingMapLink" value="{{ old('weddingMapLink', $settings['weddingMapLink']) }}" required>@error('weddingMapLink')<div class="form-error">{{ $message }}</div>@enderror</div>
                <div style="grid-column:1/-1"><label for="weddingAddress">Alamat</label><textarea id="weddingAddress" name="weddingAddress" required>{{ old('weddingAddress', $settings['weddingAddress']) }}</textarea>@error('weddingAddress')<div class="form-error">{{ $message }}</div>@enderror</div>
            </div>
        </section>

        <section class="card section">
            <h2>Resepsi</h2>
            <div class="grid form-grid-2">
                <div><label for="receptionDate">Tanggal</label><input id="receptionDate" name="receptionDate" value="{{ old('receptionDate', $settings['receptionDate']) }}" placeholder="16 November 2026" required>@error('receptionDate')<div class="form-error">{{ $message }}</div>@enderror</div>
                <div><label for="receptionTime">Waktu</label><input id="receptionTime" name="receptionTime" value="{{ old('receptionTime', $settings['receptionTime']) }}" placeholder="12:00 WIB" required>@error('receptionTime')<div class="form-error">{{ $message }}</div>@enderror</div>
                <div><label for="receptionLocation">Nama tempat</label><input id="receptionLocation" name="receptionLocation" value="{{ old('receptionLocation', $settings['receptionLocation']) }}">@error('receptionLocation')<div class="form-error">{{ $message }}</div>@enderror</div>
                <div><label for="receptionMapLink">Link Google Maps</label><input id="receptionMapLink" type="url" name="receptionMapLink" value="{{ old('receptionMapLink', $settings['receptionMapLink']) }}" required>@error('receptionMapLink')<div class="form-error">{{ $message }}</div>@enderror</div>
                <div style="grid-column:1/-1"><label for="receptionAddress">Alamat</label><textarea id="receptionAddress" name="receptionAddress" required>{{ old('receptionAddress', $settings['receptionAddress']) }}</textarea>@error('receptionAddress')<div class="form-error">{{ $message }}</div>@enderror</div>
            </div>
        </section>

        <section class="card section">
            <div class="section-head">
                <div><h2 style="margin:0 0 4px">Daftar acara</h2><div class="muted">Tambah, ubah, atau hapus acara yang tampil pada undangan.</div></div>
                <button class="secondary" type="button" id="add-event">Tambah acara</button>
            </div>
            <div id="event-list" class="grid">
                @foreach ($eventValues as $index => $event)
                    <article class="card event-item" style="box-shadow:none;background:#f9fafb">
                        <div class="section-head"><strong class="event-title">Acara {{ $loop->iteration }}</strong><button class="danger remove-event" type="button">Hapus acara</button></div>
                        <div class="grid form-grid-2">
                            <div><label>Nama acara</label><input data-field="name" name="events[{{ $index }}][name]" value="{{ $event['name'] ?? '' }}" maxlength="160" required></div>
                            <div><label>Tanggal</label><input data-field="date" name="events[{{ $index }}][date]" value="{{ $event['date'] ?? '' }}" required></div>
                            <div><label>Waktu</label><input data-field="time" name="events[{{ $index }}][time]" value="{{ $event['time'] ?? '' }}" required></div>
                            <div><label>Nama tempat</label><input data-field="location" name="events[{{ $index }}][location]" value="{{ $event['location'] ?? '' }}"></div>
                            <div style="grid-column:1/-1"><label>Alamat</label><textarea data-field="address" name="events[{{ $index }}][address]" required>{{ $event['address'] ?? '' }}</textarea></div>
                            <div style="grid-column:1/-1"><label>Link Google Maps (opsional)</label><input data-field="map_link" type="url" name="events[{{ $index }}][map_link]" value="{{ $event['map_link'] ?? '' }}"></div>
                        </div>
                    </article>
                @endforeach
            </div>
            <template id="event-template">
                <article class="card event-item" style="box-shadow:none;background:#f9fafb">
                    <div class="section-head"><strong class="event-title"></strong><button class="danger remove-event" type="button">Hapus acara</button></div>
                    <div class="grid form-grid-2">
                        <div><label>Nama acara</label><input data-field="name" maxlength="160" required></div>
                        <div><label>Tanggal</label><input data-field="date" required></div>
                        <div><label>Waktu</label><input data-field="time" required></div>
                        <div><label>Nama tempat</label><input data-field="location"></div>
                        <div style="grid-column:1/-1"><label>Alamat</label><textarea data-field="address" required></textarea></div>
                        <div style="grid-column:1/-1"><label>Link Google Maps (opsional)</label><input data-field="map_link" type="url"></div>
                    </div>
                </article>
            </template>
            @error('events')<div class="form-error">{{ $message }}</div>@enderror
            @foreach (['name', 'date', 'time', 'location', 'address', 'map_link'] as $field)
                @error('events.*.'.$field)<div class="form-error">{{ $message }}</div>@enderror
            @endforeach
        </section>

        <section class="card section">
            <div class="section-head"><div><h2 style="margin:0 0 4px">Love story</h2><div class="muted">Kelola tahapan cerita yang tampil pada undangan.</div></div><button class="secondary" type="button" data-add-row="lovestory">Tambah cerita</button></div>
            <div id="lovestory-list" class="grid">
                @foreach (old('lovestories', $settings['lovestories'] ?? []) as $index => $story)
                    <article class="card repeat-item" style="box-shadow:none;background:#f9fafb"><div class="section-head"><strong class="repeat-title">Cerita {{ $loop->iteration }}</strong><button class="danger remove-row" type="button">Hapus</button></div><div class="grid"><div><label>Judul</label><input data-field="title" name="lovestories[{{ $index }}][title]" value="{{ $story['title'] ?? '' }}" maxlength="160" required></div><div><label>Isi cerita</label><textarea data-field="text" name="lovestories[{{ $index }}][text]" maxlength="3000" required>{{ $story['text'] ?? '' }}</textarea></div></div></article>
                @endforeach
            </div>
            <template id="lovestory-template"><article class="card repeat-item" style="box-shadow:none;background:#f9fafb"><div class="section-head"><strong class="repeat-title"></strong><button class="danger remove-row" type="button">Hapus</button></div><div class="grid"><div><label>Judul</label><input data-field="title" maxlength="160" required></div><div><label>Isi cerita</label><textarea data-field="text" maxlength="3000" required></textarea></div></div></article></template>
            @error('lovestories')<div class="form-error">{{ $message }}</div>@enderror
            @foreach (['title', 'text'] as $field) @error('lovestories.*.'.$field)<div class="form-error">{{ $message }}</div>@enderror @endforeach
        </section>

        <section class="card section">
            <div class="section-head"><div><h2 style="margin:0 0 4px">Amplop digital</h2><div class="muted">Kelola rekening yang ditampilkan pada amplop digital.</div></div><button class="secondary" type="button" data-add-row="wallet">Tambah rekening</button></div>
            <div id="wallet-list" class="grid">
                @foreach (old('wallets', $settings['wallets'] ?? []) as $index => $wallet)
                    <article class="card repeat-item" style="box-shadow:none;background:#f9fafb"><div class="section-head"><strong class="repeat-title">Rekening {{ $loop->iteration }}</strong><button class="danger remove-row" type="button">Hapus</button></div><div class="grid form-grid-2"><div><label>Nama bank</label><input data-field="name" name="wallets[{{ $index }}][name]" value="{{ $wallet['name'] ?? '' }}" maxlength="120" required></div><div><label>Nomor rekening</label><input data-field="account_number" name="wallets[{{ $index }}][account_number]" value="{{ $wallet['account_number'] ?? '' }}" maxlength="80" required></div><div><label>Nama pemilik rekening</label><input data-field="account_name" name="wallets[{{ $index }}][account_name]" value="{{ $wallet['account_name'] ?? '' }}" maxlength="160" required></div></div></article>
                @endforeach
            </div>
            <template id="wallet-template"><article class="card repeat-item" style="box-shadow:none;background:#f9fafb"><div class="section-head"><strong class="repeat-title"></strong><button class="danger remove-row" type="button">Hapus</button></div><div class="grid form-grid-2"><div><label>Nama bank</label><input data-field="name" maxlength="120" required></div><div><label>Nomor rekening</label><input data-field="account_number" maxlength="80" required></div><div><label>Nama pemilik rekening</label><input data-field="account_name" maxlength="160" required></div></div></article></template>
            @error('wallets')<div class="form-error">{{ $message }}</div>@enderror
            @foreach (['name', 'account_number', 'account_name'] as $field) @error('wallets.*.'.$field)<div class="form-error">{{ $message }}</div>@enderror @endforeach
        </section>

        <div class="section-head" style="margin:18px 0 40px">
            <a class="button secondary" href="{{ route('admin.index') }}">Batal</a>
            <button type="submit">Simpan semua pengaturan</button>
        </div>
    </form>
</main>
<script>
    (() => {
        const list = document.getElementById('event-list');
        const template = document.getElementById('event-template');
        const addButton = document.getElementById('add-event');

        const renumber = () => {
            const items = [...list.querySelectorAll('.event-item')];
            items.forEach((item, index) => {
                item.querySelector('.event-title').textContent = `Acara ${index + 1}`;
                item.querySelector('.remove-event').disabled = items.length <= 1;
                item.querySelectorAll('[data-field]').forEach((field) => {
                    field.name = `events[${index}][${field.dataset.field}]`;
                });
            });
            addButton.disabled = list.querySelectorAll('.event-item').length >= 10;
        };

        addButton.addEventListener('click', () => {
            if (list.querySelectorAll('.event-item').length >= 10) return;
            list.append(template.content.cloneNode(true));
            renumber();
            list.lastElementChild.querySelector('[data-field="name"]').focus();
        });

        list.addEventListener('click', (event) => {
            if (!event.target.closest('.remove-event')) return;
            event.target.closest('.event-item').remove();
            renumber();
        });

        renumber();
    })();
    (() => {
        document.querySelectorAll('[data-add-row]').forEach((button) => {
            const type = button.dataset.addRow;
            const prefix = type === 'wallet' ? 'wallets' : 'lovestories';
            const list = document.getElementById(type === 'wallet' ? 'wallet-list' : 'lovestory-list');
            const template = document.getElementById(`${type}-template`);
            const fields = type === 'wallet' ? ['name', 'account_number', 'account_name'] : ['title', 'text'];
            const renumber = () => {
                const items = [...list.querySelectorAll('.repeat-item')];
                items.forEach((item, index) => {
                    item.querySelector('.repeat-title').textContent = `${type === 'wallet' ? 'Rekening' : 'Cerita'} ${index + 1}`;
                    item.querySelector('.remove-row').disabled = items.length <= 1;
                    item.querySelectorAll('[data-field]').forEach((field) => field.name = `${prefix}[${index}][${field.dataset.field}]`);
                });
                button.disabled = items.length >= 10;
            };
            button.addEventListener('click', () => {
                if (list.querySelectorAll('.repeat-item').length >= 10) return;
                list.append(template.content.cloneNode(true));
                renumber();
                list.lastElementChild.querySelector('[data-field]').focus();
            });
            list.addEventListener('click', (event) => {
                if (!event.target.closest('.remove-row')) return;
                event.target.closest('.repeat-item').remove();
                renumber();
            });
            renumber();
        });
    })();
</script>
@endsection
