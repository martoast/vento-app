{{-- Bilingual text. Renders both languages inline; CSS (.lang-es/.lang-en +
     [data-lang] on <html>) shows only the active one. Slots may contain markup.

     Usage:
       <x-t><x-slot:es>Texto</x-slot:es><x-slot:en>Text</x-slot:en></x-t>
--}}
<span class="lang-es">{{ $es }}</span><span class="lang-en">{{ $en }}</span>
