<a {{ $attributes }}
    class="{{ $active ? 'text-white' : 'text-gray-400 hover:text-white' }} relative rounded-md px-3 py-2 text-md font-normal group"
    aria-current="{{ $active ? 'page' : false }}">
    {{ $slot }}

    <span class="absolute left-0 bottom-1 w-full h-0.5 bg-current transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></span>
</a>
