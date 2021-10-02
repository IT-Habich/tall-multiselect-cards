@props(['selected' => false, 'key' => '', 'item' => []])

<div wire:click='toggleChecked("{{ $key }}")' class="group cursor-pointer relative px-1 py-2 max-w-xl">
    <div class="absolute right-1 top-2 z-50 rounded-full border-2 text-{{ $this->settings['card_color_selected'] }} @if ($selected) border-{{ $this->settings['card_color_selected'] }} @else border-{{ $this->settings['card_color'] }} @endif group-hover:border-{{ $this->settings['card_color_hover'] }} group-focus:border-{{ $this->settings['card_color_focus'] }} group-hover:text-{{ $this->settings['card_color_hover'] }} group-focus:text-{{ $this->settings['card_color_focus'] }}">
        @if ($selected)
        <x-tall-multiselect-cards::check-circle />
        @else
        <div class="h-5 w-5"></div>
        @endif
    </div>
    <div class="relative p-2 bg-{{ $this->settings['card_color_bg'] }} group-hover:bg-{{ $this->settings['card_color_bg_hover'] }} group-focus:bg-{{ $this->settings['card_color_bg_focus'] }} shadow-lg rounded-xl border-2 @if ($selected) border-{{ $this->settings['card_color_selected'] }} @else border-{{ $this->settings['card_color'] }} @endif group-hover:border-{{ $this->settings['card_color_hover'] }} group-focus:border-{{ $this->settings['card_color_focus'] }}">
        <div class="max-w-md">
            <div class="flex justify-between items-center">
                <span class="text-sm font-bold">{{ $item['primary'] }}</span><span class="pr-2 m-2 text-xs text-gray-500">@if($this->settings['enable_optional_brackets']) ({{ $item['optional'] }}) @else {{ $item['optional'] }} @endif</span>
            </div>
        </div>
        <div class="text-md">{{ $item['secondary'] }}</div>
    </div>
</div>