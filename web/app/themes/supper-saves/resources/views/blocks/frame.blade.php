{{--
Title: Frame
Description: Frame containing content
Category: common
Icon: format-image
Keywords: frame content block kader box
--}}

<div class="p-10 mb-6 bg-secondary">
    @isset (get_fields()['frame_title'])
        <h2 class="mb-5 lg:text-2xl text-white">
            {{ get_fields()['frame_title'] }}
        </h2>
    @endisset
    @isset (get_fields()['frame_text'])
        <p class="leading-1 text-white">
            {{ get_fields()['frame_text'] }}
        </p>
    @endisset
</div>
