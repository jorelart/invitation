<?php

namespace App\Http\Controllers;

use App\Models\InvitationPhoto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminPhotoController extends Controller
{
    public function index(): View
    {
        return view('admin.photos', [
            'photos' => InvitationPhoto::query()->orderBy('slot')->orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'slot' => ['required', Rule::in(['gallery', 'bride', 'groom', 'story', 'closing', 'opening', 'save_the_date', 'cover'])],
            'caption' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:999'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:20480'],
        ]);

        $photoData = $this->uploadedPhotoData($validated['image']);
        $slot = $validated['slot'];

        if ($slot !== 'gallery') {
            $this->deleteSlotPhotos($slot);
        }

        InvitationPhoto::create([
            'slot' => $slot,
            'caption' => $validated['caption'] ?? null,
            'sort_order' => $validated['sort_order'],
            ...$photoData,
        ]);

        return redirect()->route('admin.photos.index')->with('success', 'Foto berhasil diunggah.');
    }

    public function update(Request $request, InvitationPhoto $photo): RedirectResponse
    {
        $validated = $request->validate([
            'slot' => ['required', Rule::in(['gallery', 'bride', 'groom', 'story', 'closing', 'opening', 'save_the_date', 'cover'])],
            'caption' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:999'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:20480'],
        ]);

        $oldPath = $photo->path;
        $photoData = isset($validated['image']) ? $this->uploadedPhotoData($validated['image']) : [];
        $slot = $validated['slot'];

        if ($slot !== 'gallery') {
            $this->deleteSlotPhotos($slot, $photo->id);
        }

        $photo->update([
            'slot' => $slot,
            'caption' => $validated['caption'] ?? null,
            'sort_order' => $validated['sort_order'],
            ...$photoData,
        ]);

        if (isset($validated['image'])) {
            $this->deleteUploadedFile($oldPath);
        }

        return redirect()->route('admin.photos.index')->with('success', 'Pengaturan foto berhasil disimpan.');
    }

    public function destroy(InvitationPhoto $photo): RedirectResponse
    {
        $path = $photo->path;
        $photo->delete();
        $this->deleteUploadedFile($path);

        return redirect()->route('admin.photos.index')->with('success', 'Foto berhasil dihapus.');
    }

    /** @return array{path: string, width: int|null, height: int|null} */
    private function uploadedPhotoData(UploadedFile $image): array
    {
        $dimensions = $image->dimensions();

        return [
            'path' => $image->store('invitation-photos', 'public'),
            'width' => $dimensions[0] ?? null,
            'height' => $dimensions[1] ?? null,
        ];
    }

    private function deleteSlotPhotos(string $slot, ?int $exceptId = null): void
    {
        $photos = InvitationPhoto::query()->where('slot', $slot)
            ->when($exceptId, fn ($query) => $query->where('id', '!=', $exceptId))
            ->get();

        foreach ($photos as $photo) {
            $path = $photo->path;
            $photo->delete();
            $this->deleteUploadedFile($path);
        }
    }

    private function deleteUploadedFile(string $path): void
    {
        if (str_starts_with($path, 'invitation-photos/')) {
            Storage::disk('public')->delete($path);
        }
    }
}
