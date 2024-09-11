<div class="rounded-md border-2 border-petite-orchid">
    <table class="w-full">
        <thead>
            <tr class="text-cinnabar font-title text-left">
                <th class="p-6 w-1/2 rounded-lt-md">
                    {{ $tabData['title'] }}
                </th>
                <th class="p-6 border-l-2 border-petite-orchid w-1/2">
                    {{ $tabData['amounts'] }}
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($tabData['items'] as $item)
                <tr>
                    <td class="py-2.5 px-6 border-t-2 border-petite-orchid">{{ $item['label'] }}</td>
                    <td class="py-2.5 px-6 border-l-2 border-t-2 border-petite-orchid">{{ $item['value'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
