@extends('layouts.admin', ['title' => 'Kelola Foto'])

@section('content')
<main class="container">
    <div class="section-head">
        <div><p class="muted" style="margin:0 0 6px">PANEL PENGELOLAAN</p><h1>Foto undangan</h1></div>
        <a class="button secondary" href="{{ route('admin.index') }}">Kembali ke admin</a>
    </div>

    @if (session('success'))<div class="notice success" role="status">{{ session('success') }}</div>@endif
    @if ($errors->any())<div class="notice error" role="alert">{{ $errors->first() }}</div>@endif

    <section class="card section">
        <h2>Tambah foto</h2>
        <form method="post" action="{{ route('admin.photos.store') }}" enctype="multipart/form-data" class="photo-upload-form">
            @csrf
            <div><label for="slot">Tampilkan sebagai</label><select id="slot" name="slot" required>
                <option value="bride">Foto mempelai wanita</option>
                <option value="groom">Foto mempelai pria</option>
                <option value="gallery">Foto galeri</option>
                <option value="story">Foto cerita pasangan</option>
                <option value="closing">Foto penutup</option>
                <option value="opening">Foto halaman pembuka</option>
            </select></div>
            <div><label for="caption">Keterangan / teks alternatif</label><input id="caption" name="caption" value="{{ old('caption') }}" maxlength="255"></div>
            <div><label for="sort_order">Urutan (galeri)</label><input id="sort_order" name="sort_order" type="number" min="0" max="999" value="{{ old('sort_order', 10) }}" required></div>
            <div><label for="image">Pilih foto</label><input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp" required><div class="muted" style="margin-top:6px">JPG, PNG, atau WebP; maksimal 8 MB.</div></div>
            <button type="submit">Unggah foto</button>
        </form>
    </section>

    <section class="section">
        <div class="section-head"><div><h2 style="margin:0 0 4px">Foto yang tampil</h2><div class="muted">Urutan galeri mengikuti nomor urut. Slot lain hanya memakai satu foto per lokasi.</div></div></div>
        <div class="photo-grid">
            @forelse ($photos as $photo)
                <article class="card photo-card">
                    <img class="photo-preview" src="{{ $photo->url }}" alt="{{ $photo->caption }}" loading="lazy">
                    <form method="post" action="{{ route('admin.photos.update', $photo) }}" enctype="multipart/form-data">
                        @csrf @method('patch')
                        <label for="slot-{{ $photo->id }}">Lokasi foto</label>
                        <select id="slot-{{ $photo->id }}" name="slot" required>
                            <option value="bride" @selected($photo->slot === 'bride')>Foto mempelai wanita</option>
                            <option value="groom" @selected($photo->slot === 'groom')>Foto mempelai pria</option>
                            <option value="gallery" @selected($photo->slot === 'gallery')>Foto galeri</option>
                            <option value="story" @selected($photo->slot === 'story')>Foto cerita pasangan</option>
                            <option value="closing" @selected($photo->slot === 'closing')>Foto penutup</option>
                            <option value="opening" @selected($photo->slot === 'opening')>Foto halaman pembuka</option>
                        </select>
                        <label for="caption-{{ $photo->id }}">Keterangan / teks alternatif</label>
                        <input id="caption-{{ $photo->id }}" name="caption" value="{{ $photo->caption }}" maxlength="255">
                        <label for="order-{{ $photo->id }}">Urutan galeri</label>
                        <input id="order-{{ $photo->id }}" name="sort_order" type="number" min="0" max="999" value="{{ $photo->sort_order }}" required>
                        <label for="image-{{ $photo->id }}">Ganti file (opsional)</label>
                        <input id="image-{{ $photo->id }}" name="image" type="file" accept="image/jpeg,image/png,image/webp">
                        <div class="photo-actions">
                            <button type="submit">Simpan</button>
                        </div>
                    </form>
                    <form method="post" action="{{ route('admin.photos.destroy', $photo) }}" onsubmit="return confirm('Hapus foto ini dari undangan?')">
                        @csrf @method('delete')
                        <button class="danger photo-delete" type="submit">Hapus foto</button>
                    </form>
                </article>
            @empty
                <div class="card muted">Belum ada foto. Unggah foto di atas untuk menampilkannya.</div>
            @endforelse
        </div>
    </section>
</main>
<template id="photo-crop-template">
    <div class="photo-crop" hidden>
        <div class="muted">Crop opsional. Pilih rasio, lalu atur zoom dan posisi foto.</div>
        <label>Rasio foto</label>
        <select class="crop-ratio">
            <option value="original">Asli</option>
            <option value="0.774336">Portrait opening (875:1130)</option>
            <option value="0.8">Portrait (4:5)</option>
            <option value="0.666667">Portrait (2:3)</option>
            <option value="1">Persegi (1:1)</option>
            <option value="1.333333">Landscape (4:3)</option>
            <option value="1.777778">Wide (16:9)</option>
        </select>
        <canvas width="350" height="350" aria-label="Pratinjau crop foto"></canvas>
        <label>Zoom</label><input type="range" class="crop-zoom" min="1" max="3" step="0.01" value="1">
        <label>Geser horizontal</label><input type="range" class="crop-x" min="0" max="100" value="50">
        <label>Geser vertikal</label><input type="range" class="crop-y" min="0" max="100" value="50">
    </div>
</template>
<script>
(() => {
    const template = document.getElementById('photo-crop-template');

    function cropRect(image, zoom, horizontal, vertical, ratio) {
        let width = image.naturalWidth;
        let height = image.naturalHeight;
        if (width / height > ratio) width = height * ratio;
        else height = width / ratio;
        width /= zoom;
        height /= zoom;
        return {
            x: (image.naturalWidth - width) * horizontal,
            y: (image.naturalHeight - height) * vertical,
            width,
            height,
        };
    }

    function setup(form) {
        const slot = form.querySelector('[name="slot"]');
        const fileInput = form.querySelector('[name="image"]');
        if (!slot || !fileInput) return;

        const removeEditor = () => {
            form.querySelector('.photo-crop')?.remove();
            delete form.cropImage;
            delete form.cropEditor;
        };

        const createEditor = (file) => {
            removeEditor();
            if (!file) return;

            const editor = template.content.firstElementChild.cloneNode(true);
            editor.hidden = false;
            fileInput.after(editor);
            const image = new Image();
            form.cropImage = image;
            const objectUrl = URL.createObjectURL(file);

            const canvas = editor.querySelector('canvas');
            const context = canvas.getContext('2d');
            const ratioSelect = editor.querySelector('.crop-ratio');
            const zoom = editor.querySelector('.crop-zoom');
            const horizontal = editor.querySelector('.crop-x');
            const vertical = editor.querySelector('.crop-y');
            const selectedRatio = () => ratioSelect.value === 'original'
                ? image.naturalWidth / image.naturalHeight
                : Number(ratioSelect.value);
            function render() {
                if (!image.naturalWidth) return;
                const ratio = selectedRatio();
                canvas.height = Math.round(canvas.width / ratio);
                const rect = cropRect(image, Number(zoom.value), Number(horizontal.value) / 100, Number(vertical.value) / 100, ratio);
                context.clearRect(0, 0, canvas.width, canvas.height);
                context.drawImage(image, rect.x, rect.y, rect.width, rect.height, 0, 0, canvas.width, canvas.height);
            }
            editor.addEventListener('input', render);
            ratioSelect.addEventListener('change', render);
            editor.cropForUpload = async () => {
                if (!image.naturalWidth) await image.decode();
                const ratio = selectedRatio();
                const rect = cropRect(image, Number(zoom.value), Number(horizontal.value) / 100, Number(vertical.value) / 100, ratio);
                const output = document.createElement('canvas');
                output.width = 1200;
                output.height = Math.round(output.width / ratio);
                output.getContext('2d').drawImage(image, rect.x, rect.y, rect.width, rect.height, 0, 0, output.width, output.height);
                return new Promise((resolve) => output.toBlob(resolve, 'image/jpeg', 0.92));
            };
            image.onload = () => {
                render();
                URL.revokeObjectURL(objectUrl);
            };
            image.src = objectUrl;
            form.cropEditor = editor;
        };

        fileInput.addEventListener('change', () => createEditor(fileInput.files[0]));
        form.addEventListener('submit', async (event) => {
            if (!fileInput.files[0] || !form.cropEditor || form.dataset.cropReady === '1') return;
            event.preventDefault();
            const ratio = form.cropEditor.querySelector('.crop-ratio').value;
            const zoom = Number(form.cropEditor.querySelector('.crop-zoom').value);
            const horizontal = Number(form.cropEditor.querySelector('.crop-x').value);
            const vertical = Number(form.cropEditor.querySelector('.crop-y').value);
            if (ratio === 'original' && zoom === 1 && horizontal === 50 && vertical === 50) {
                form.dataset.cropReady = '1';
                form.requestSubmit(event.submitter);
                return;
            }
            const blob = await form.cropEditor.cropForUpload();
            if (!blob) return;
            const transfer = new DataTransfer();
            transfer.items.add(new File([blob], 'photo-cropped.jpg', { type: 'image/jpeg' }));
            fileInput.files = transfer.files;
            form.dataset.cropReady = '1';
            form.requestSubmit(event.submitter);
        });
    }

    document.querySelectorAll('.photo-upload-form, .photo-card form').forEach(setup);
})();
</script>
<style>
    .photo-upload-form{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px 16px;align-items:end}.photo-upload-form>button{justify-self:start}.photo-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:16px}.photo-card{padding:14px;min-width:0}.photo-preview{display:block;width:100%;height:220px;object-fit:cover;border-radius:9px;background:#f2f4f7;margin-bottom:14px}.photo-card label{margin-top:10px}.photo-actions{margin-top:14px}.photo-delete{margin-top:8px;width:100%}.photo-crop{grid-column:1/-1;padding:12px;border:1px solid #e4e7ec;border-radius:10px;background:#f9fafb}.photo-crop[hidden]{display:none}.photo-crop canvas{display:block;width:min(100%,280px);height:auto;margin:10px 0;border-radius:8px;background:#eaecf0}.photo-crop label{margin-top:8px}@media(max-width:850px){.photo-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}@media(max-width:600px){.photo-upload-form,.photo-grid{grid-template-columns:1fr}.photo-preview{height:260px}.photo-upload-form>button{width:100%}}
</style>
@endsection
