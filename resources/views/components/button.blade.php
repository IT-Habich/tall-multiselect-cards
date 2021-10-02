@props(['primary' => false])

@if ($primary)
<button wire:click="sendSelected" onclick="this.blur();" type="button" class="px-4 py-2 mx-1 border-2 border-transparent rounded-md text-sm bg-{{ $this->settings['primary_button_color_bg'] }} hover:bg-{{ $this->settings['primary_button_color_bg_hover'] }} focus:bg-{{ $this->settings['primary_button_color_bg_hover'] }} text-{{ $this->settings['primary_button_color_text'] }} hover:text-{{ $this->settings['primary_button_color_text_hover'] }} focus:text-{{ $this->settings['primary_button_color_text_focus'] }}">
    {{ __('tall-multiselect-cards::strings.primary_btn') }}
</button>
@else
<button wire:click="clearSelected" onclick="this.blur();" type="button" class="px-4 py-2 mx-1 border-2 rounded-md text-sm border-{{ $this->settings['secondary_button_color_border'] }} hover:border-{{ $this->settings['secondary_button_color_border_hover'] }} focus:border-{{ $this->settings['secondary_button_color_border_hover'] }} text-{{ $this->settings['secondary_button_color_text'] }} hover:text-{{ $this->settings['secondary_button_color_text_hover'] }} focus:text-{{ $this->settings['secondary_button_color_text_focus'] }}">
    {{ __('tall-multiselect-cards::strings.secondary_btn') }}
</button>
@endif