@if (function_exists('icl_get_languages'))
    <dropdown
        v-cloak
        class="hidden md:block"
    >
        <template v-slot:trigger="{ showDropdown }">
            <div
                class="border-secondary flex items-center rounded border-2 py-0.5 px-2 uppercase"
            >
                {{ ICL_LANGUAGE_CODE }}
                <icon
                    icon="triangle"
                    :class="['text-xxs ml-3 transition', { '-rotate-180': showDropdown }]"
                ></icon>
            </div>
        </template>
        <template v-slot:items>
            @foreach (icl_get_languages() as $lang)
                @if ($lang['active']) 
                    <dropdown-item 
                        link="{{ $lang['url'] }}"
                        active
                    >
                        {{ $lang['native_name'] }}
                    </dropdown-item>
                @else
                    <dropdown-item
                        link="{{ $lang['url'] }}"
                    >
                        {{ $lang['native_name'] }}
                    </dropdown-item>
                @endif
            @endforeach
        </template>
    </dropdown>
@endif
