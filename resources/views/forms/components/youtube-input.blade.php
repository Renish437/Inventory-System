<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div x-data="{ url: $wire.entangle('{{ $getStatePath() }}') }" class="space-y-2">
        <x-filament::input.wrapper>
    <x-filament::input
     type="url" x-model="url"
     placeholder="Paste YouTube URL…"
    />
</x-filament::input.wrapper>

        {{-- <input type="url" x-model="url"
               placeholder="Paste YouTube URL…"
               class="w-full border rounded px-2 py-1 text-sm" /> --}}

        <template x-if="url">
            <iframe
                class="w-full aspect-video  h-96 rounded"
                :src="'https://www.youtube.com/embed/' + (new URL(url).searchParams.get('v') || url.split('/').pop())"
                frameborder="0"
                allowfullscreen>
            </iframe>
        </template>
    </div>
</x-dynamic-component>
