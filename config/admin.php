<?php

return [

    /*
     * Admin prefix (the admin url segment)
     * For security concerns, prefix should be hashed.
     * @var string
     */

    'prefix' => env("ADMIN_PREFIX", "backend"),

    /*
     * Default Page after login
     * without admin prefix
     * @var string
     */

    'default_path' => env("DEFAULT_PATH", "dashboard"),

    /*
     * API prefix
     * example (api/v1)
     *
     * @var string
     */

    'api' => env("API_PREFIX", "api"),

    /*
     * Dot plugins
     *
     * @var array
     */

    'plugins' => [
        "admin" => Dot\Platform\System::class,
        "i18n" => Dot\I18n\I18n::class,
        "posts" => Dot\Posts\Posts::class,
        "seo" => Dot\Seo\Seo::class,
    ]
];
