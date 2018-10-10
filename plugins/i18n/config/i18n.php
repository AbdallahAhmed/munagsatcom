<?php

return [

    /*
     * The place where system stores the current locale.
     * Available Settings: "session" and "url"
     * @var string
     */

    'driver' => env("I18N_DRIVER", "session"),

    /*
     * All system Locales
     *
     * @var array
     */

    'locales' => [

        'ar' => [
            "title" => "العربية",
            "direction" => "rtl"
        ],

        'en' => [
            "title" => "English",
            "direction" => "ltr"
        ]

    ]
];
