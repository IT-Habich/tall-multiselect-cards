<?php

return [

    /*
    |--------------------------------------------------------------------------
    | TALL Multiselect Cards - Package configuration
    |--------------------------------------------------------------------------
    |
    | The following arrays configure the available models and their attributes
    | that are shown within the cards. 
    | You'll be able to configure multiple models to use them with
    | multiple components.
    |
    | Furthermore they provide a settings array which allows you to adjust 
    | the color schema and some basic settings.
    | You can use any color that is shipped with Tailwind CSS
    | - https://tailwindcss.com/docs/customizing-colors
    |
    */

    'User' => [
        'model' => 'App\Models\User',
        'modelAttributes' => [
            'uniqueId' => 'id',
            'primary' => 'name',
            'secondary' => 'email',
            'optional' => NULL,
        ],
        'settings' => [
            'paginate_data' => true,
            'paginate_data_per_page' => 15,
            'enable_optional_brackets' => false,
            'hide_search' => false,
            'search_color_focus' => 'blue-400',
            'search_color_bg_focus' => 'blue-100',
            'card_color_bg' => 'white',
            'card_color_bg_hover' => 'blue-100',
            'card_color_bg_focus' => 'blue-100',
            'card_color' => 'gray-500',
            'card_color_selected' => 'blue-600',
            'card_color_hover' => 'blue-400',
            'card_color_focus' => 'blue-400',
            'primary_button_color_bg' => 'gray-800',
            'primary_button_color_bg_hover' => 'gray-700',
            'primary_button_color_bg_focus' => 'gray-700',
            'primary_button_color_text' => 'white',
            'primary_button_color_text_hover' => 'white',
            'primary_button_color_text_focus' => 'white',
            'secondary_button_color_border' => 'gray-600',
            'secondary_button_color_border_hover' => 'gray-400',
            'secondary_button_color_border_focus' => 'gray-400',
            'secondary_button_color_text' => 'gray-900',
            'secondary_button_color_text_hover' => 'gray-400',
            'secondary_button_color_text_focus' => 'gray-400',
        ]
    ],
    // 'Contact' => [
    //     'model' => 'App\Models\Contact',
    //     'modelAttributes' => [
    //         'uniqueId' => 'id',
    //         'primary' => 'name',
    //         'secondary' => 'email',
    //         'optional' => 'mobile',
    //     ],
    //     'settings' => [
    //         'paginate_data' => true,
    //         'paginate_data_per_page' => 15,
    //         'enable_optional_brackets' => true,
    //         'hide_search' => false,
    //         'search_color_focus' => 'blue-400',
    //         'search_color_bg_focus' => 'blue-100',
    //         'card_color_bg' => 'white',
    //         'card_color_bg_hover' => 'blue-100',
    //         'card_color_bg_focus' => 'blue-100',
    //         'card_color' => 'blue-900',
    //         'card_color_selected' => 'blue-600',
    //         'card_color_hover' => 'blue-400',
    //         'card_color_focus' => 'blue-400',
    //         'primary_button_color_bg' => 'gray-800',
    //         'primary_button_color_bg_hover' => 'gray-700',
    //         'primary_button_color_bg_focus' => 'gray-700',
    //         'primary_button_color_text' => 'white',
    //         'primary_button_color_text_hover' => 'white',
    //         'primary_button_color_text_focus' => 'white',
    //         'secondary_button_color_border' => 'gray-600',
    //         'secondary_button_color_border_hover' => 'gray-400',
    //         'secondary_button_color_border_focus' => 'gray-400',
    //         'secondary_button_color_text' => 'gray-900',
    //         'secondary_button_color_text_hover' => 'gray-400',
    //         'secondary_button_color_text_focus' => 'gray-400',
    //     ]
    // ],
];
