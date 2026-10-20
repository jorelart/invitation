<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\InvitationSetting;
use App\Models\Rsvp;
use Illuminate\Http\Request;

class Home extends Controller
{
    protected $data;

    public function __construct()
    {
        $settings = InvitationSetting::query()->where('key', 'home')->firstOrFail()->value;

        $this->data = [
            ...$settings,
            'guest' => Guest::where('invitation_token', request()->query('inv'))->first(),
            'rsvpComments' => Rsvp::with('guest')->get()
        ];
    }

    public function index()
    {
        // dd($this->data['rsvpComments']);
        return view('home', $this->data);
    }
}
