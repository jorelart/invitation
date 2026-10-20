<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\InvitationSetting;
use App\Models\Rsvp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function editSettings(): View
    {
        $settings = InvitationSetting::query()->where('key', 'home')->firstOrFail()->value;

        return view('admin.settings', compact('settings'));
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'brideName' => ['required', 'string', 'max:120'],
            'brideFullName' => ['required', 'string', 'max:180'],
            'brideInstagram' => ['nullable', 'string', 'max:120'],
            'brideParent' => ['required', 'string', 'max:500'],
            'groomName' => ['required', 'string', 'max:120'],
            'groomFullName' => ['required', 'string', 'max:180'],
            'groomInstagram' => ['nullable', 'string', 'max:120'],
            'groomParent' => ['required', 'string', 'max:500'],
            'weddingDate' => ['required', 'date'],
            'weddingTime' => ['required', 'regex:/^\d{1,2}:\d{2}(?:\s*WIB)?$/i'],
            'weddingLocation' => ['required', 'string', 'max:180'],
            'weddingAddress' => ['required', 'string', 'max:1000'],
            'weddingMapLink' => ['required', 'url', 'max:1000'],
            'receptionDate' => ['required', 'date'],
            'receptionTime' => ['required', 'regex:/^\d{1,2}:\d{2}(?:\s*WIB)?$/i'],
            'receptionLocation' => ['required', 'string', 'max:180'],
            'receptionAddress' => ['required', 'string', 'max:1000'],
            'receptionMapLink' => ['required', 'url', 'max:1000'],
            'events' => ['required', 'array', 'min:1', 'max:10'],
            'events.*.name' => ['required', 'string', 'max:160'],
            'events.*.date' => ['required', 'date'],
            'events.*.time' => ['required', 'string', 'max:120'],
            'events.*.location' => ['required', 'string', 'max:180'],
            'events.*.address' => ['required', 'string', 'max:1000'],
            'events.*.map_link' => ['nullable', 'url', 'max:1000'],
        ]);

        InvitationSetting::updateOrCreate(['key' => 'home'], ['value' => $validated]);

        return redirect()->route('admin.settings.edit')->with('success', 'Pengaturan undangan berhasil disimpan.');
    }

    public function index(Request $request): View
    {
        $validated = $request->validate([
            'q' => ['nullable', 'string', 'max:120'],
            'presence' => ['nullable', Rule::in(['hadir', 'tidak'])],
        ]);

        $guestQuery = Guest::query()->with('rsvp')->latest('id');
        $rsvpQuery = Rsvp::query()->with('guest')->latest('id');

        if (! empty($validated['q'])) {
            $term = $validated['q'];
            $phoneTerm = preg_replace('/\D+/', '', $term);
            $guestQuery->where(function ($query) use ($term, $phoneTerm): void {
                $query->where('name', 'like', '%'.$term.'%');

                if (strlen($phoneTerm) >= 8) {
                    $query->orWhere('phone', 'like', '%'.$phoneTerm.'%');
                }
            });
            $rsvpQuery->whereHas('guest', fn ($query) => $query->where('name', 'like', '%'.$term.'%'));
        }

        if (! empty($validated['presence'])) {
            $guestQuery->whereHas('rsvp', fn ($query) => $query->where('presence', $validated['presence']));
            $rsvpQuery->where('presence', $validated['presence']);
        }

        return view('admin.index', [
            'guests' => $guestQuery->paginate(15, ['*'], 'guests_page')->withQueryString(),
            'rsvps' => $rsvpQuery->paginate(15, ['*'], 'rsvps_page')->withQueryString(),
            'guestCount' => Guest::count(),
            'rsvpCount' => Rsvp::count(),
            'attendingCount' => Rsvp::where('presence', 'hadir')->count(),
            'pendingCount' => Guest::doesntHave('rsvp')->count(),
        ]);
    }

    public function storeInvitation(Request $request): RedirectResponse
    {
        $phone = $request->input('phone');
        $request->merge([
            'phone' => is_string($phone) ? preg_replace('/\D+/', '', $phone) : $phone,
        ]);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'digits_between:8,20', Rule::unique('guests', 'phone')],
            'max_guests' => ['required', 'integer', 'min:1', 'max:20'],
        ]);

        $guest = Guest::create([
            'name' => trim($validated['name']),
            'phone' => $validated['phone'],
            'max_guests' => $validated['max_guests'],
            'invitation_token' => Str::random(64),
        ]);

        return redirect()->route('admin.index')
            ->with('success', 'Undangan dibuat: '.url('/?inv='.$guest->invitation_token));
    }

    public function destroyInvitation(Guest $guest): RedirectResponse
    {
        $guest->delete();

        return redirect()->route('admin.index')->with('success', 'Undangan berhasil dihapus.');
    }

    public function reply(Request $request, Guest $guest): RedirectResponse
    {
        $validated = $request->validate([
            'owner_reply' => ['required', 'string', 'max:1000'],
        ]);

        $rsvp = $guest->rsvp;
        if (! $rsvp) {
            return redirect()->route('admin.index')->withErrors([
                'owner_reply' => 'Tamu ini belum mengirim RSVP.',
            ]);
        }

        $rsvp->update(['owner_reply' => trim($validated['owner_reply'])]);

        return redirect()->route('admin.index')->with('success', 'Balasan RSVP berhasil disimpan.');
    }
}
