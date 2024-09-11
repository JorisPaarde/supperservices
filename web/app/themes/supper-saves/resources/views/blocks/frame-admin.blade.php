<div>
    <small><i>Pas de titel en tekst van dit block aan in de sidebar of klik op het potloodje in de opties hierboven.</i></small>

    @isset (get_fields()['frame_title'])
        <h2>
            {{ get_fields()['frame_title'] }}
        </h2>
    @endisset
    @isset (get_fields()['frame_text'])
        <div>
            {!! get_fields()['frame_text'] !!}
        </div>
    @endisset
</div>
