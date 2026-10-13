<?php

use App\Models\Guest;
use App\Models\Rsvp;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Component;

new class extends Component {
    #[Layout('layouts.app')]
    public string $title = 'Undangan Website Premium 06';

    #[Locked]
    public ?Guest $guest = null;

    public $token;
    public ?string $guuestName;
    public ?string $brideName, $brideFullName, $brideInstagram, $brideParent, $groomName, $groomFullName, $groomInstagram, $groomParent, $weddingDate, $weddingTime, $weddingLocation, $weddingMapLink, $weddingAddress, $receptionDate, $receptionTime, $receptionLocation, $receptionAddress, $receptionMapLink;
    public array $events = [];
    #[Locked]
    public Collection $rsvpComments;

    protected function quryString(): array
    {
        return [
            'token' => $this->token
        ];
    }

    public function mount(): void
    {
        $this->guest = Guest::where('invitation_token', $this->token)->first();
        $this->brideName = 'Vya';
        $this->brideFullName = 'Utami Alivya Widyawati, S.Tr.Keb.,Bd.';
        $this->brideInstagram = 'utamialivyaa_';
        $this->brideParent = 'Putra Kedua dari (Alm) Bapak Widarto & Ibu Riswati';
        $this->groomName = 'Fairuz';
        $this->groomFullName = 'Fairuz Akbar Dani Swara, S.H.';
        $this->groomInstagram = 'fairuzdanis';
        $this->groomParent = 'Putra Pertama dari Bapak Tri Hariyanto & Ibu Sri haryanti';
        $this->weddingDate = '16 November 2026';
        $this->weddingTime = '09:00 WIB';
        $this->weddingLocation = 'Kediaman Mempelai Wanita';
        $this->weddingAddress = 'Gedung TEA Desa Treko, Jl. Candimulyo, Treko I, Treko, Kec. Mungkid, Kabupaten Magelang, Jawa Tengah 56512';
        $this->weddingMapLink = 'https://maps.google.com/?q=Rumah+Makan';
        $this->receptionDate = '16 November 2026';
        $this->receptionTime = '12:00 WIB';
        $this->receptionLocation = 'Kediaman Mempelai Wanita';
        $this->receptionAddress = 'Gedung TEA Desa Treko, Jl. Candimulyo, Treko I, Treko, Kec. Mungkid, Kabupaten Magelang, Jawa Tengah 56512';
        $this->receptionMapLink = 'https://maps.google.com/?q=Rumah+Makan';
        $this->events = [
            [
                'name' => 'Akad Nikah',
                'date' => $this->weddingDate,
                'time' => $this->weddingTime . ' WIB',
                'location' => $this->weddingLocation,
                'address' => $this->weddingAddress,
                'map_link' => $this->weddingMapLink
            ],
            [
                'name' => 'Resepsi Sesi 1',
                'date' => $this->receptionDate,
                'time' => $this->receptionTime . ' WIB s/d ' . Carbon\Carbon::parse($this->receptionTime)->addHours(1)->format('H:i') . ' WIB',
                'location' => $this->receptionLocation,
                'address' => $this->receptionAddress,
                'map_link' => $this->receptionMapLink
            ],
            [
                'name' => 'Resepsi Sesi 2',
                'date' => $this->receptionDate,
                'time' => Carbon\Carbon::parse($this->receptionTime)->addHours(1)->format('H:i') . ' WIB s/d Selesai',
                'location' => $this->receptionLocation,
                'address' => $this->receptionAddress,
                'map_link' => $this->receptionMapLink
            ]
        ];
    }
};
?>

<div>
    <div data-elementor-type="wp-page" data-elementor-id="32120" class="elementor elementor-32120"
        data-elementor-post-type="page">
        @include('partials.invitation.cover')

        <div class="elementor-element elementor-element-258985b9 e-con-full e-flex e-con e-parent" data-id="258985b9"
            data-element_type="container" data-e-type="container">
            @include('partials.invitation.desktop-cover')

            <div class="elementor-element elementor-element-6626d23e e-con-full e-flex e-con e-child" data-id="6626d23e"
                data-element_type="container" data-e-type="container">
                <livewire:section.opening :groomName="$groomName" :brideName="$brideName" :weddingDate="$weddingDate" />
                @include('partials.invitation.couple')
                <livewire:section.save-the-date :weddingDate="$weddingDate" />
                <livewire:section.event :events="$events" :weddingDate="$weddingDate" :weddingTime="$weddingTime" :weddingLocation="$weddingLocation"
                    :weddingAddress="$weddingAddress" :weddingMapLink="$weddingMapLink" :receptionDate="$receptionDate" :receptionTime="$receptionTime" :receptionLocation="$receptionLocation"
                    :receptionAddress="$receptionAddress" :receptionMapLink="$receptionMapLink" />
                <livewire:section.love-story />
                <livewire:section.gallery />

                <div class="elementor-element elementor-element-51cdfcef e-con-full e-flex e-con e-child"
                    data-id="51cdfcef" data-element_type="container" data-e-type="container"
                    data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                    <livewire:section.digital-envelope :groomName="$groomName" :brideName="$brideName" />
                    <livewire:section.rsvp :guest="$guest" :rsvpComments="$rsvpComments" />
                </div>

                <livewire:section.closing :groomName="$groomName" :brideName="$brideName" />
                @include('partials.invitation.footer')
            </div>
        </div>
    </div>
</div>
