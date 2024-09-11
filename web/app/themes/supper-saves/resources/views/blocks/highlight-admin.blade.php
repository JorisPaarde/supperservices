<div>
    <small><i>Pas de content van het block aan in de sidebar of klik op het potloodje in de opties hierboven.</i></small>

    <div>
        @isset (get_fields()['highlight_title'])
            <h2>
                {{ get_fields()['highlight_title'] }}
            </h2>
        @endisset

        @isset (get_fields()['highlight_text'])
            <p>{{ get_fields()['highlight_text'] }}</p>
        @endisset

        @isset (get_fields()['highlight_button'])
            <a
                href="{{ get_fields()['highlight_button']['url'] }}"
                target="{{ get_fields()['highlight_button']['target'] }}"
                @if (get_fields()['highlight_button']['target'] === '_blank')
                    rel="noopener nofollow noreferrer"
                @endif
            >
                {{ get_fields()['highlight_button']['title'] }}
            </a>
        @endisset
    </div>
</div>
