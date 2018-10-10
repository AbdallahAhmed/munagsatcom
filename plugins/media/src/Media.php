<?php

namespace Dot\Media;

use Aws\Laravel\AwsFacade;
use Aws\Laravel\AwsServiceProvider;
use Dot\Options\Facades\Option;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageServiceProvider;

class Media extends \Dot\Platform\Plugin
{

    protected $providers = [
        ImageServiceProvider::class,
        AwsServiceProvider::class,
    ];

    protected $aliases = [
        'Image' => Image::class,
        'AWS' => AwsFacade::class,
    ];

    function boot()
    {

        parent::boot();

        Option::page("media", function ($option) {
            $option->title(trans("media::options.media_options"))
                ->icon("fa-camera")
                ->order(1)
                ->view("media::options");
        });

        $media_path = config("media.drivers.local.path");

        if (!$media_path) {
            $media_path = public_path("uploads");
        }

        define("UPLOADS_PATH", $media_path);
        define("AMAZON", 1);
        define("AMAZON_URL", "https://" . config("media.s3.bucket") . ".s3-" . config("media.s3.region") . ".amazonaws.com/");

        require_once $this->getPath("helpers.php");
    }

    function install($command)
    {
        parent::install($command);

        Option::set("media_allowed_file_types", "jpg,png,jpeg,bmp,gif,zip,doc,docx,rar,zip,pdf,txt,csv,xls");
        Option::set("media_max_file_size", 512000);
        Option::set("media_max_width", 2500);
        Option::set("media_thumbnails", 0);
        Option::set("media_resize_mode", "resize");
        Option::set("media_resize_background_color", "#ffffff");
        Option::set("media_resize_gradient_first_color", "#ffffff");
        Option::set("media_resize_gradient_second_color", "#000000");
    }

    function uninstall($command)
    {
        parent::uninstall($command);

        Option::delete("media_allowed_file_types");
        Option::delete("media_max_file_size");
        Option::delete("media_max_width");
        Option::delete("media_thumbnails");
        Option::delete("media_resize_mode");
        Option::delete("media_resize_background_color");
        Option::delete("media_resize_gradient_first_color");
        Option::delete("media_resize_gradient_second_color");

    }
}
