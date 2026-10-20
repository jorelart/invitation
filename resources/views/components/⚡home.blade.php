<?php

use App\Models\Guest;
use App\Models\InvitationSetting;
use App\Models\InvitationPhoto;
use App\Models\Rsvp;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Component;

new class extends Component {
    #[Layout('layouts.app')]
    public string $title;

    #[Locked]
    public ?Guest $guest = null;

    #[Locked]
    public ?string $token = null;
    public ?string $brideName, $brideFullName, $brideInstagram, $brideParent, $groomName, $groomFullName, $groomInstagram, $groomParent, $weddingDate, $weddingTime, $weddingLocation, $weddingMapLink, $weddingAddress, $receptionDate, $receptionTime, $receptionLocation, $receptionAddress, $receptionMapLink;
    public array $events = [];
    public array $galleryPhotos = [];
    public ?array $bridePhoto = null;
    public ?array $groomPhoto = null;
    public ?array $storyPhoto = null;
    public ?array $closingPhoto = null;
    public ?array $openingPhoto = null;
    public ?array $coverPhoto = null;
    #[Locked]
    public Collection $rsvpComments;

    public function mount(): void
    {
        $inv = request()->query('inv');
        $this->token = is_string($inv) && preg_match('/^[A-Za-z0-9]{64}$/', $inv) ? $inv : null;
        $this->guest = $this->token ? Guest::where('invitation_token', $this->token)->first() : null;
        $settings = InvitationSetting::query()->where('key', 'home')->firstOrFail()->value;

        $this->title = $settings['title'];
        $this->brideName = $settings['brideName'];
        $this->brideFullName = $settings['brideFullName'];
        $this->brideInstagram = $settings['brideInstagram'];
        $this->brideParent = $settings['brideParent'];
        $this->groomName = $settings['groomName'];
        $this->groomFullName = $settings['groomFullName'];
        $this->groomInstagram = $settings['groomInstagram'];
        $this->groomParent = $settings['groomParent'];
        $this->weddingDate = $settings['weddingDate'];
        $this->weddingTime = $settings['weddingTime'];
        $this->weddingLocation = $settings['weddingLocation'];
        $this->weddingAddress = $settings['weddingAddress'];
        $this->weddingMapLink = $settings['weddingMapLink'];
        $this->receptionDate = $settings['receptionDate'];
        $this->receptionTime = $settings['receptionTime'];
        $this->receptionLocation = $settings['receptionLocation'];
        $this->receptionAddress = $settings['receptionAddress'];
        $this->receptionMapLink = $settings['receptionMapLink'];
        $this->events = $settings['events'];

        $photos = InvitationPhoto::query()->orderBy('sort_order')->orderBy('id')->get();
        $this->galleryPhotos = $photos
            ->where('slot', 'gallery')
            ->map(
                fn(InvitationPhoto $photo): array => [
                    'url' => $photo->url,
                    'caption' => $photo->caption ?? '',
                    'width' => $photo->width ?? 1024,
                    'height' => $photo->height ?? 1535
                ]
            )
            ->values()
            ->all();
        $this->bridePhoto = $this->photoData($photos->firstWhere('slot', 'bride'));
        $this->groomPhoto = $this->photoData($photos->firstWhere('slot', 'groom'));
        $this->storyPhoto = $this->photoData($photos->firstWhere('slot', 'story'));
        $this->closingPhoto = $this->photoData($photos->firstWhere('slot', 'closing'));
        $this->openingPhoto = $this->photoData($photos->firstWhere('slot', 'opening'));
        $this->coverPhoto = $this->photoData($photos->firstWhere('slot', 'cover'));
    }

    private function photoData(?InvitationPhoto $photo): ?array
    {
        if (!$photo) {
            return null;
        }

        return [
            'url' => $photo->url,
            'caption' => $photo->caption ?? '',
            'width' => $photo->width ?? 1024,
            'height' => $photo->height ?? 1024
        ];
    }
};
?>

<div>
    <div data-elementor-type="wp-page" data-elementor-id="32120" class="elementor elementor-32120"
        data-elementor-post-type="page">
        {{-- @include('partials.invitation.cover') --}}
        <livewire:section.cover :photo="$coverPhoto" :groomName="$groomName" :brideName="$brideName" :guest="$guest" />
        <div class="elementor-element elementor-element-258985b9 e-con-full e-flex e-con e-parent" data-id="258985b9"
            data-element_type="container" data-e-type="container">
            @include('partials.invitation.desktop-cover')

            <div class="elementor-element elementor-element-6626d23e e-con-full e-flex e-con e-child" data-id="6626d23e"
                data-element_type="container" data-e-type="container">
                <livewire:section.opening :groomName="$groomName" :brideName="$brideName" :weddingDate="$weddingDate" :photo="$openingPhoto" />
                @include('partials.invitation.couple', [
                    'bridePhoto' => $bridePhoto,
                    'groomPhoto' => $groomPhoto
                ])
                <livewire:section.save-the-date :weddingDate="$weddingDate" :photo="$openingPhoto" />
                <livewire:section.event :events="$events" :weddingDate="$weddingDate" :weddingTime="$weddingTime" :weddingLocation="$weddingLocation"
                    :weddingAddress="$weddingAddress" :weddingMapLink="$weddingMapLink" :receptionDate="$receptionDate" :receptionTime="$receptionTime" :receptionLocation="$receptionLocation"
                    :receptionAddress="$receptionAddress" :receptionMapLink="$receptionMapLink" />
                <livewire:section.love-story :photo="$storyPhoto" />
                <livewire:section.gallery :photos="$galleryPhotos" />

                <div class="elementor-element elementor-element-51cdfcef e-con-full e-flex e-con e-child"
                    data-id="51cdfcef" data-element_type="container" data-e-type="container"
                    data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                    <livewire:section.digital-envelope :groomName="$groomName" :brideName="$brideName" />
                    <livewire:section.rsvp :guest="$guest" :rsvpComments="$rsvpComments" />
                </div>

                <livewire:section.closing :groomName="$groomName" :brideName="$brideName" :photo="$closingPhoto" />
                @include('partials.invitation.footer')
            </div>
        </div>
    </div>
</div>
