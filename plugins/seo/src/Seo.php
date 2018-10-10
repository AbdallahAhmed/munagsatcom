<?php

namespace Dot\Seo;

use Action;
use Dot\Options\Facades\Option;
use Dot\Seo\Classes\Sitemap;
use Dot\Seo\Models\Analysis;
use Dot\Seo\Models\SEOModel;
use Request;

class Seo extends \Dot\Platform\Plugin
{

    /*
     * Plugin permissions
     * @var array
     */
    protected $permissions = [];

    /*
     * Plugin providers
     * @var array
     */
    protected $providers = [
        \Roumen\Sitemap\SitemapServiceProvider::class
    ];

    /*
     * Plugin aliases
     * @var array
     */
    protected $aliases = [
        'Sitemap' => \Dot\Seo\Facades\Sitemap::class
    ];

    /*
     * Plugin bootstrap
     * Called in system boot
     */
    public function boot()
    {

        parent::boot();

        Sitemap::set("sitemap", function ($sitemap) {

            $sitemap->url(url("/"))
                ->date(time())
                ->priority("0.9")
                ->freq("hourly");

        });

        Option::page("seo", function ($option) {
            $option->title(trans("seo::options.seo_options"))
                ->icon("fa-line-chart")
                ->order(3)
                ->view("seo::seo_options");
        });

        Option::page("social", function ($option) {
            $option->title(trans("seo::options.social_options"))
                ->icon("fa-globe")
                ->order(4)
                ->view("seo::social_options");
        });

        Action::listen("post.form.featured", function ($post) {

            $post->load("seo");

            if ($post->id) {

                $analysis = new Analysis();

                $data['seo_results'] = $analysis->linkdex_output($post);
                // $data['publish_seo'] = $analysis->publish_box();

            } else {

                $analysis = new Analysis();

                $data['seo_results'] = $analysis->linkdex_output($post);
                // $data['publish_seo'] = $analysis->publish_box();

            }

            $data['post'] = $post;

            return view("seo::seo", $data);
        });


        Action::listen("post.saved", function ($post) {

            $meta = Request::get("meta");

            $meta["post_id"] = $post->id;
            $meta["type"] = 1;

             \Dot\Seo\Models\SEO::where("post_id", $post->id)->delete();
            \Dot\Seo\Models\SEO::where("post_id", $post->id)->insert($meta);
        });

        include $this->getPath() . "/helpers.php";
    }


    /*
     * Register some classes
     */
    function register()
    {
        parent::register();

        $this->app->bind("sitemap", function () {
            return new \Dot\Seo\Classes\Sitemap();
        });

    }

    function install($command)
    {
        parent::install($command);

        $command->info("Setting default options");

        Option::set("site_title", "Site Title", 1);
        Option::set("site_description", "Site Title", 1);
        Option::set("site_author", "Site Author", 1);
        Option::set("site_robots", "NOINDEX, NOFOLLOW");
        Option::set("site_keywords", "dot, cms, platform", 1);
        Option::set("site_logo", NULL, 1);
        Option::set("sitemap_status", 0);
        Option::set("sitemap_xml_status", 0);
        Option::set("sitemap_html_status", 0);
        Option::set("sitemap_txt_status", 0);
        Option::set("sitemap_ping_status", 0);
        Option::set("sitemap_google_ping_status", 0);
        Option::set("sitemap_bing_ping_status", 0);
        Option::set("sitemap_yahoo_ping_status", 0);
        Option::set("sitemap_ask_ping_status", 0);
        Option::set("sitemap_path", "/");
        Option::set("facebook_page", NULL, 1);
        Option::set("twitter_page", NULL, 1);
        Option::set("youtube_page", NULL, 1);
        Option::set("googleplus_page", NULL, 1);
        Option::set("instagram_page", NULL, 1);
        Option::set("soundcloud_page", NULL, 1);
        Option::set("linkedin_page", NULL, 1);
    }

    function uninstall($command)
    {
        parent::uninstall($command);

        $command->info("Deleting plugin options");

        Option::delete("site_title");
        Option::delete("site_description");
        Option::delete("site_author");
        Option::delete("site_robots");
        Option::delete("site_keywords");
        Option::delete("site_logo");
        Option::delete("sitemap_status");
        Option::delete("sitemap_xml_status");
        Option::delete("sitemap_html_status");
        Option::delete("sitemap_txt_status");
        Option::delete("sitemap_ping_status");
        Option::delete("sitemap_google_ping_status");
        Option::delete("sitemap_bing_ping_status");
        Option::delete("sitemap_yahoo_ping_status");
        Option::delete("sitemap_ask_ping_status");
        Option::delete("sitemap_path");
        Option::delete("facebook_page");
        Option::delete("twitter_page");
        Option::delete("youtube_page");
        Option::delete("googleplus_page");
        Option::delete("instagram_page");
        Option::delete("soundcloud_page");
        Option::delete("linkedin_page");
    }
}
