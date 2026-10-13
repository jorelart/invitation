<?php

use Livewire\Component;

new class extends Component {
    public $weddingDate, $weddingTime, $weddingLocation, $weddingAddress, $weddingMapLink, $receptionDate, $receptionTime, $receptionLocation, $receptionAddress, $receptionMapLink;

    public function mount()
    {
        $this->weddingDate = Carbon\Carbon::parse($this->weddingDate)->format('d F Y');
        $this->weddingTime = Carbon\Carbon::parse($this->weddingTime)->format('H:i');
        $this->receptionDate = Carbon\Carbon::parse($this->receptionDate)->format('d F Y');
        $this->receptionTime = Carbon\Carbon::parse($this->receptionTime)->format('H:i');
    }
};
?>
<div>
    @foreach ($events as $event)
        <div class="elementor-element elementor-element-67952455 e-con-full acara-con e-flex e-con e-child"
            data-id="67952455" data-element_type="container" data-e-type="container"
            data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
            <div class="elementor-element elementor-element-653de833 elementor-widget elementor-widget-spacer"
                data-id="653de833" data-element_type="widget" data-e-type="widget" data-widget_type="spacer.default">
                <div class="elementor-widget-container">
                    <div class="elementor-spacer">
                        <div class="elementor-spacer-inner"></div>
                    </div>
                </div>
            </div>
            <div class="elementor-element elementor-element-38637978 e-con-full e-flex e-con e-child" data-id="38637978"
                data-element_type="container" data-e-type="container">
                <div class="elementor-element elementor-element-74e7328c elementor-widget elementor-widget-spacer"
                    data-id="74e7328c" data-element_type="widget" data-e-type="widget"
                    data-widget_type="spacer.default">
                    <div class="elementor-widget-container">
                        <div class="elementor-spacer">
                            <div class="elementor-spacer-inner"></div>
                        </div>
                    </div>
                </div>
                <div class="idb-reveal idb-ef zoom-down elementor-element elementor-element-2bc6348e elementor-widget elementor-widget-heading"
                    data-reveal-offset="100" data-reveal-duration="2000" data-reveal-delay="0"
                    style="transition-duration: 2000ms;" data-id="2bc6348e" data-element_type="widget"
                    data-e-type="widget" data-widget_type="heading.default">
                    <div class="elementor-widget-container">
                        <h2 class="elementor-heading-title elementor-size-default"><span class="nama-acara-marker"
                                data-event-index="1">{{ $event['name'] }}</span></h2>
                    </div>
                </div>
                <div class="idb-reveal idb-ef zoom-down elementor-element elementor-element-577ad1ab elementor-widget elementor-widget-text-editor"
                    data-reveal-offset="100" data-reveal-duration="2000" data-reveal-delay="0"
                    style="transition-duration: 2000ms;" data-id="577ad1ab" data-element_type="widget"
                    data-e-type="widget" data-widget_type="text-editor.default">
                    <div class="elementor-widget-container">{{ $event['date'] }}</div>
                </div>
                <div class="idb-reveal idb-ef zoom-down elementor-element elementor-element-33b95f24 elementor-widget elementor-widget-text-editor"
                    data-reveal-offset="100" data-reveal-duration="2000" data-reveal-delay="0"
                    style="transition-duration: 2000ms;" data-id="33b95f24" data-element_type="widget"
                    data-e-type="widget" data-widget_type="text-editor.default">
                    <div class="elementor-widget-container">
                        Pukul : {{ $event['time'] }}</div>
                </div>
                <div class="idb-reveal idb-ef zoom-down elementor-element elementor-element-61daa429 elementor-widget-divider--view-line_icon elementor-view-default elementor-widget-divider--element-align-center elementor-widget elementor-widget-divider"
                    data-reveal-offset="100" data-reveal-duration="2000" data-reveal-delay="0"
                    style="transition-duration: 2000ms;" data-id="61daa429" data-element_type="widget"
                    data-e-type="widget" data-widget_type="divider.default">
                    <div class="elementor-widget-container">
                        <div class="elementor-divider">
                            <span class="elementor-divider-separator">
                                <div class="elementor-icon elementor-divider__element">
                                    <i aria-hidden="true" class="fas fa-map-marker-alt"></i>
                                </div>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="elementor-element elementor-element-649c29e2 elementor-widget elementor-widget-text-editor"
                    data-id="649c29e2" data-element_type="widget" data-e-type="widget"
                    data-widget_type="text-editor.default">
                    <div class="elementor-widget-container">
                        Tempat : <span class="niku-multiline"><strong>{{ $event['location'] }}</strong><br
                                class="niku-lb">{{ $event['address'] }}</span> </div>
                </div>
                <div class="idb-reveal idb-ef zoom-down elementor-element elementor-element-6a0a05e3 elementor-widget elementor-widget-bisdev_social_icons"
                    data-reveal-offset="100" data-reveal-duration="2000" data-reveal-delay="0"
                    style="transition-duration: 2000ms;" data-id="6a0a05e3" data-element_type="widget"
                    data-e-type="widget" data-widget_type="bisdev_social_icons.default">
                    <div class="elementor-widget-container">
                        <div class="idb-social-icons is-auto-columns is-location-buttons is-shape-circle"
                            style="--idb-loc-btn-text:#FFFFFF;">
                            <a class="idb-social-icons__item elementor-animation-grow" href="{{ $event['map_link'] }}"
                                aria-label="{{ $event['name'] }}" title="{{ $event['name'] }}" style=""
                                data-idb-maps-link="1" target="_blank" rel="nofollow noopener noreferrer">
                                <i class="fas fa-map-marker-alt" aria-hidden="true"></i> <span
                                    class="idb-social-icons__text">Lihat Lokasi</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="elementor-element elementor-element-19db68d6 elementor-widget elementor-widget-spacer"
                    data-id="19db68d6" data-element_type="widget" data-e-type="widget"
                    data-widget_type="spacer.default">
                    <div class="elementor-widget-container">
                        <div class="elementor-spacer">
                            <div class="elementor-spacer-inner"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="elementor-element elementor-element-4d223f9a elementor-absolute elementor-widget__width-inherit elementor-widget elementor-widget-image"
                data-id="4d223f9a" data-element_type="widget" data-e-type="widget"
                data-settings="{&quot;_position&quot;:&quot;absolute&quot;}" data-widget_type="image.default">
                <div class="elementor-widget-container">
                    <img loading="lazy" decoding="async" width="1080" height="250"
                        src="assets/vendor/site/wp-content/uploads/2026/06/FRAME4-GREEN-PII.webp"
                        class="attachment-full size-full wp-image-34094" alt=""
                        srcset="assets/vendor/site/wp-content/uploads/2026/06/FRAME4-GREEN-PII.webp 1080w, assets/vendor/site/wp-content/uploads/2026/06/FRAME4-GREEN-PII-300x69.webp 300w, assets/vendor/site/wp-content/uploads/2026/06/FRAME4-GREEN-PII-1024x237.webp 1024w, assets/vendor/site/wp-content/uploads/2026/06/FRAME4-GREEN-PII-768x178.webp 768w"
                        sizes="(max-width: 1080px) 100vw, 1080px" />
                </div>
            </div>
            <div class="idb-reveal idb-ef zoom-bottom-left elementor-element elementor-element-46933dba elementor-absolute fla1 elementor-widget__width-inherit elementor-widget elementor-widget-image"
                data-reveal-offset="0" data-reveal-duration="2000" data-reveal-delay="0"
                style="transition-duration: 2000ms;" data-id="46933dba" data-element_type="widget"
                data-e-type="widget" data-settings="{&quot;_position&quot;:&quot;absolute&quot;}"
                data-widget_type="image.default">
                <div class="elementor-widget-container">
                    <img loading="lazy" decoding="async" width="642" height="649"
                        src="assets/vendor/site/wp-content/uploads/2026/06/BUNGA-A2-GREEN-PII.webp"
                        class="attachment-full size-full wp-image-34082" alt=""
                        srcset="assets/vendor/site/wp-content/uploads/2026/06/BUNGA-A2-GREEN-PII.webp 642w, assets/vendor/site/wp-content/uploads/2026/06/BUNGA-A2-GREEN-PII-297x300.webp 297w"
                        sizes="(max-width: 642px) 100vw, 642px" />
                </div>
            </div>
            <div class="idb-reveal idb-ef zoom-bottom-right elementor-element elementor-element-7bc8720d elementor-absolute fla1 e-transform elementor-widget__width-inherit elementor-widget elementor-widget-image"
                data-reveal-offset="0" data-reveal-duration="2000" data-reveal-delay="0"
                style="transition-duration: 2000ms;" data-id="7bc8720d" data-element_type="widget"
                data-e-type="widget"
                data-settings="{&quot;_position&quot;:&quot;absolute&quot;,&quot;_transform_flipX_effect&quot;:&quot;transform&quot;}"
                data-widget_type="image.default">
                <div class="elementor-widget-container">
                    <img loading="lazy" decoding="async" width="642" height="649"
                        src="assets/vendor/site/wp-content/uploads/2026/06/BUNGA-A2-GREEN-PII.webp"
                        class="attachment-full size-full wp-image-34082" alt=""
                        srcset="assets/vendor/site/wp-content/uploads/2026/06/BUNGA-A2-GREEN-PII.webp 642w, assets/vendor/site/wp-content/uploads/2026/06/BUNGA-A2-GREEN-PII-297x300.webp 297w"
                        sizes="(max-width: 642px) 100vw, 642px" />
                </div>
            </div>
            <div class="idb-reveal idb-ef zoom-out elementor-element elementor-element-16d19a15 elementor-absolute elementor-widget__width-inherit elementor-widget elementor-widget-image"
                data-reveal-offset="0" data-reveal-duration="2000" data-reveal-delay="0"
                style="transition-duration: 2000ms;" data-id="16d19a15" data-element_type="widget"
                data-e-type="widget" data-settings="{&quot;_position&quot;:&quot;absolute&quot;}"
                data-widget_type="image.default">
                <div class="elementor-widget-container">
                    <img loading="lazy" decoding="async" width="1080" height="463"
                        src="assets/vendor/site/wp-content/uploads/2026/06/BUNGA6-GREEN-PII.webp"
                        class="attachment-full size-full wp-image-34096" alt=""
                        srcset="assets/vendor/site/wp-content/uploads/2026/06/BUNGA6-GREEN-PII.webp 1080w, assets/vendor/site/wp-content/uploads/2026/06/BUNGA6-GREEN-PII-300x129.webp 300w, assets/vendor/site/wp-content/uploads/2026/06/BUNGA6-GREEN-PII-1024x439.webp 1024w, assets/vendor/site/wp-content/uploads/2026/06/BUNGA6-GREEN-PII-768x329.webp 768w"
                        sizes="(max-width: 1080px) 100vw, 1080px" />
                </div>
            </div>
            <div class="idb-reveal idb-ef zoom-bottom-left elementor-element elementor-element-14467dd elementor-absolute flb1 elementor-widget__width-inherit elementor-widget elementor-widget-image"
                data-reveal-offset="0" data-reveal-duration="2000" data-reveal-delay="0"
                style="transition-duration: 2000ms;" data-id="14467dd" data-element_type="widget"
                data-e-type="widget" data-settings="{&quot;_position&quot;:&quot;absolute&quot;}"
                data-widget_type="image.default">
                <div class="elementor-widget-container">
                    <img loading="lazy" decoding="async" width="333" height="418"
                        src="assets/vendor/site/wp-content/uploads/2026/06/BUNGA-A3-GREEN-PII.webp"
                        class="attachment-full size-full wp-image-34085" alt=""
                        srcset="assets/vendor/site/wp-content/uploads/2026/06/BUNGA-A3-GREEN-PII.webp 333w, assets/vendor/site/wp-content/uploads/2026/06/BUNGA-A3-GREEN-PII-239x300.webp 239w"
                        sizes="(max-width: 333px) 100vw, 333px" />
                </div>
            </div>
            <div class="idb-reveal idb-ef zoom-bottom-right elementor-element elementor-element-137ff158 elementor-absolute flb1 e-transform elementor-widget__width-inherit elementor-widget elementor-widget-image"
                data-reveal-offset="0" data-reveal-duration="2000" data-reveal-delay="0"
                style="transition-duration: 2000ms;" data-id="137ff158" data-element_type="widget"
                data-e-type="widget"
                data-settings="{&quot;_position&quot;:&quot;absolute&quot;,&quot;_transform_flipX_effect&quot;:&quot;transform&quot;}"
                data-widget_type="image.default">
                <div class="elementor-widget-container">
                    <img loading="lazy" decoding="async" width="333" height="418"
                        src="assets/vendor/site/wp-content/uploads/2026/06/BUNGA-A3-GREEN-PII.webp"
                        class="attachment-full size-full wp-image-34085" alt=""
                        srcset="assets/vendor/site/wp-content/uploads/2026/06/BUNGA-A3-GREEN-PII.webp 333w, assets/vendor/site/wp-content/uploads/2026/06/BUNGA-A3-GREEN-PII-239x300.webp 239w"
                        sizes="(max-width: 333px) 100vw, 333px" />
                </div>
            </div>
        </div>
    @endforeach

    <div class="elementor-element elementor-element-684292c2 e-con-full acara-con e-flex e-con e-child"
        data-id="684292c2" data-element_type="container" data-e-type="container"
        data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
        <div class="elementor-element elementor-element-695636c7 elementor-widget elementor-widget-spacer"
            data-id="695636c7" data-element_type="widget" data-e-type="widget" data-widget_type="spacer.default">
            <div class="elementor-widget-container">
                <div class="elementor-spacer">
                    <div class="elementor-spacer-inner"></div>
                </div>
            </div>
        </div>
        <div class="elementor-element elementor-element-43a7aed8 e-con-full e-flex e-con e-child" data-id="43a7aed8"
            data-element_type="container" data-e-type="container">
            <div class="elementor-element elementor-element-22496be0 elementor-widget elementor-widget-spacer"
                data-id="22496be0" data-element_type="widget" data-e-type="widget"
                data-widget_type="spacer.default">
                <div class="elementor-widget-container">
                    <div class="elementor-spacer">
                        <div class="elementor-spacer-inner"></div>
                    </div>
                </div>
            </div>
            <div class="idb-reveal idb-ef zoom-down elementor-element elementor-element-2ab0a1a7 elementor-widget elementor-widget-heading"
                data-reveal-offset="100" data-reveal-duration="2000" data-reveal-delay="0"
                style="transition-duration: 2000ms;" data-id="2ab0a1a7" data-element_type="widget"
                data-e-type="widget" data-widget_type="heading.default">
                <div class="elementor-widget-container">
                    <h2 class="elementor-heading-title elementor-size-default"><span class="nama-acara-marker"
                            data-event-index="2"></span></h2>
                </div>
            </div>
            <div class="idb-reveal idb-ef zoom-down elementor-element elementor-element-6e0aee90 elementor-widget-divider--view-line_icon elementor-view-default elementor-widget-divider--element-align-center elementor-widget elementor-widget-divider"
                data-reveal-offset="100" data-reveal-duration="2000" data-reveal-delay="0"
                style="transition-duration: 2000ms;" data-id="6e0aee90" data-element_type="widget"
                data-e-type="widget" data-widget_type="divider.default">
                <div class="elementor-widget-container">
                    <div class="elementor-divider">
                        <span class="elementor-divider-separator">
                            <div class="elementor-icon elementor-divider__element">
                                <i aria-hidden="true" class="fas fa-map-marker-alt"></i>
                            </div>
                        </span>
                    </div>
                </div>
            </div>
            <div class="elementor-element elementor-element-506ff68c elementor-widget elementor-widget-spacer"
                data-id="506ff68c" data-element_type="widget" data-e-type="widget"
                data-widget_type="spacer.default">
                <div class="elementor-widget-container">
                    <div class="elementor-spacer">
                        <div class="elementor-spacer-inner"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="elementor-element elementor-element-301b21c elementor-absolute elementor-widget__width-inherit elementor-widget elementor-widget-image"
            data-id="301b21c" data-element_type="widget" data-e-type="widget"
            data-settings="{&quot;_position&quot;:&quot;absolute&quot;}" data-widget_type="image.default">
            <div class="elementor-widget-container">
                <img loading="lazy" decoding="async" width="1080" height="250"
                    src="assets/vendor/site/wp-content/uploads/2026/06/FRAME4-GREEN-PII.webp"
                    class="attachment-full size-full wp-image-34094" alt=""
                    srcset="assets/vendor/site/wp-content/uploads/2026/06/FRAME4-GREEN-PII.webp 1080w, assets/vendor/site/wp-content/uploads/2026/06/FRAME4-GREEN-PII-300x69.webp 300w, assets/vendor/site/wp-content/uploads/2026/06/FRAME4-GREEN-PII-1024x237.webp 1024w, assets/vendor/site/wp-content/uploads/2026/06/FRAME4-GREEN-PII-768x178.webp 768w"
                    sizes="(max-width: 1080px) 100vw, 1080px" />
            </div>
        </div>
        <div class="idb-reveal idb-ef zoom-bottom-left elementor-element elementor-element-508d5cf6 elementor-absolute fla1 elementor-widget__width-inherit elementor-widget elementor-widget-image"
            data-reveal-offset="0" data-reveal-duration="2000" data-reveal-delay="0"
            style="transition-duration: 2000ms;" data-id="508d5cf6" data-element_type="widget" data-e-type="widget"
            data-settings="{&quot;_position&quot;:&quot;absolute&quot;}" data-widget_type="image.default">
            <div class="elementor-widget-container">
                <img loading="lazy" decoding="async" width="642" height="649"
                    src="assets/vendor/site/wp-content/uploads/2026/06/BUNGA-A2-GREEN-PII.webp"
                    class="attachment-full size-full wp-image-34082" alt=""
                    srcset="assets/vendor/site/wp-content/uploads/2026/06/BUNGA-A2-GREEN-PII.webp 642w, assets/vendor/site/wp-content/uploads/2026/06/BUNGA-A2-GREEN-PII-297x300.webp 297w"
                    sizes="(max-width: 642px) 100vw, 642px" />
            </div>
        </div>
        <div class="idb-reveal idb-ef zoom-bottom-right elementor-element elementor-element-5ebe793f elementor-absolute fla1 e-transform elementor-widget__width-inherit elementor-widget elementor-widget-image"
            data-reveal-offset="0" data-reveal-duration="2000" data-reveal-delay="0"
            style="transition-duration: 2000ms;" data-id="5ebe793f" data-element_type="widget" data-e-type="widget"
            data-settings="{&quot;_position&quot;:&quot;absolute&quot;,&quot;_transform_flipX_effect&quot;:&quot;transform&quot;}"
            data-widget_type="image.default">
            <div class="elementor-widget-container">
                <img loading="lazy" decoding="async" width="642" height="649"
                    src="assets/vendor/site/wp-content/uploads/2026/06/BUNGA-A2-GREEN-PII.webp"
                    class="attachment-full size-full wp-image-34082" alt=""
                    srcset="assets/vendor/site/wp-content/uploads/2026/06/BUNGA-A2-GREEN-PII.webp 642w, assets/vendor/site/wp-content/uploads/2026/06/BUNGA-A2-GREEN-PII-297x300.webp 297w"
                    sizes="(max-width: 642px) 100vw, 642px" />
            </div>
        </div>
        <div class="idb-reveal idb-ef zoom-out elementor-element elementor-element-572a1ab elementor-absolute elementor-widget__width-inherit elementor-widget elementor-widget-image"
            data-reveal-offset="0" data-reveal-duration="2000" data-reveal-delay="0"
            style="transition-duration: 2000ms;" data-id="572a1ab" data-element_type="widget" data-e-type="widget"
            data-settings="{&quot;_position&quot;:&quot;absolute&quot;}" data-widget_type="image.default">
            <div class="elementor-widget-container">
                <img loading="lazy" decoding="async" width="1080" height="463"
                    src="assets/vendor/site/wp-content/uploads/2026/06/BUNGA6-GREEN-PII.webp"
                    class="attachment-full size-full wp-image-34096" alt=""
                    srcset="assets/vendor/site/wp-content/uploads/2026/06/BUNGA6-GREEN-PII.webp 1080w, assets/vendor/site/wp-content/uploads/2026/06/BUNGA6-GREEN-PII-300x129.webp 300w, assets/vendor/site/wp-content/uploads/2026/06/BUNGA6-GREEN-PII-1024x439.webp 1024w, assets/vendor/site/wp-content/uploads/2026/06/BUNGA6-GREEN-PII-768x329.webp 768w"
                    sizes="(max-width: 1080px) 100vw, 1080px" />
            </div>
        </div>
        <div class="idb-reveal idb-ef zoom-bottom-left elementor-element elementor-element-51085f2b elementor-absolute flb1 elementor-widget__width-inherit elementor-widget elementor-widget-image"
            data-reveal-offset="0" data-reveal-duration="2000" data-reveal-delay="0"
            style="transition-duration: 2000ms;" data-id="51085f2b" data-element_type="widget" data-e-type="widget"
            data-settings="{&quot;_position&quot;:&quot;absolute&quot;}" data-widget_type="image.default">
            <div class="elementor-widget-container">
                <img loading="lazy" decoding="async" width="333" height="418"
                    src="assets/vendor/site/wp-content/uploads/2026/06/BUNGA-A3-GREEN-PII.webp"
                    class="attachment-full size-full wp-image-34085" alt=""
                    srcset="assets/vendor/site/wp-content/uploads/2026/06/BUNGA-A3-GREEN-PII.webp 333w, assets/vendor/site/wp-content/uploads/2026/06/BUNGA-A3-GREEN-PII-239x300.webp 239w"
                    sizes="(max-width: 333px) 100vw, 333px" />
            </div>
        </div>
        <div class="idb-reveal idb-ef zoom-bottom-right elementor-element elementor-element-5fb0ce25 elementor-absolute flb1 e-transform elementor-widget__width-inherit elementor-widget elementor-widget-image"
            data-reveal-offset="0" data-reveal-duration="2000" data-reveal-delay="0"
            style="transition-duration: 2000ms;" data-id="5fb0ce25" data-element_type="widget" data-e-type="widget"
            data-settings="{&quot;_position&quot;:&quot;absolute&quot;,&quot;_transform_flipX_effect&quot;:&quot;transform&quot;}"
            data-widget_type="image.default">
            <div class="elementor-widget-container">
                <img loading="lazy" decoding="async" width="333" height="418"
                    src="assets/vendor/site/wp-content/uploads/2026/06/BUNGA-A3-GREEN-PII.webp"
                    class="attachment-full size-full wp-image-34085" alt=""
                    srcset="assets/vendor/site/wp-content/uploads/2026/06/BUNGA-A3-GREEN-PII.webp 333w, assets/vendor/site/wp-content/uploads/2026/06/BUNGA-A3-GREEN-PII-239x300.webp 239w"
                    sizes="(max-width: 333px) 100vw, 333px" />
            </div>
        </div>
    </div>

</div>
