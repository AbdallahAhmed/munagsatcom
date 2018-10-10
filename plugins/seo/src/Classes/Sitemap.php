<?php

namespace Dot\Seo\Classes;

use Dot\Options\Facades\Option;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\File;

/*
 * Class DotSitemap
 * @package Dot\Platform
 */
class Sitemap
{

    /*
     * @var array
     */
    public static $items = [];

    /*
     * @var
     */
    public static $item;

    /*
     * @var
     */
    public static $sitemaps = [];

    /*
     * @var
     */
    public static $currentSitemap;


    /*
     * @return array
     */
    public static function maps()
    {
        return array_unique(self::$sitemaps);
    }

    /*
     * @param $sitemap
     * @return string
     */
    public static function render($sitemap)
    {

        $map = new \Roumen\Sitemap\Sitemap(config("sitemap"));

        $items = self::get($sitemap);

        foreach ($items as $item) {
            $map->add($item->loc, $item->lastmod, $item->priority, $item->changefreq);
        }

        $directory = option("sitemap_path", "/");

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0777, true, true);
        }

        $file = public_path($directory . "/" . $sitemap);

        $file = ltrim(get_relative_path($file), "/public");

        if (option("sitemap_xml_status") == 1) {
            $map->store("xml", $file);
        }

        if (option("sitemap_html_status") == 1) {
            $map->store("html", $file);
        }

        if (option("sitemap_txt_status") == 1) {
            $map->store("txt", $file);
        }

        Option::set("sitemap_last_update", time());

        if (option("sitemap_ping_status") == 1) {
            self::ping($sitemap);
        }
    }

    /*
     * @param $sitemap
     * @return array
     */
    public static function get($sitemap)
    {

        Event::fire($sitemap . ".sitemap");

        $return = [];

        foreach (self::$items as $item) {
            if ($item->sitemap == $sitemap) {
                $return[] = $item;
            }
        }

        return $return;
    }

    /*
     * @return bool
     */
    public static function ping($sitemap)
    {

        $sitemap_url = url(get_relative_path(option("sitemap_path", "/")) . $sitemap . ".xml");

        $curl_req = [];

        $urls = [];

        // below are the SEs that we will be pining

        if (option("sitemap_google_ping_status") == 1) {
            $urls[] = "http://www.google.com/webmasters/tools/ping?sitemap=" . $sitemap_url;
        }

        if (option("sitemap_bing_ping_status") == 1) {
            $urls[] = "http://www.bing.com/webmaster/ping.aspx?siteMap=" . $sitemap_url;
        }

        if (option("sitemap_yahoo_ping_status") == 1) {
            $urls[] = "http://search.yahooapis.com/SiteExplorerService/V1/updateNotification?appid=YahooDemo&amp;url=" . ($sitemap_url);
        }

        if (option("sitemap_ask_ping_status") == 1) {
            $urls[] = "http://submissions.ask.com/ping?sitemap=" . $sitemap_url;
        }

        foreach ($urls as $url) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURL_HTTP_VERSION_1_1, 1);
            $curl_req[] = $curl;
        }

        // Initiating multi handler

        $multiHandle = curl_multi_init();

        // Adding all the single handler to a multi handler
        foreach ($curl_req as $key => $curl) {
            curl_multi_add_handle($multiHandle, $curl);
        }

        $isactive = null;

        do {
            $multi_curl = curl_multi_exec($multiHandle, $isactive);
        } while ($isactive || $multi_curl == CURLM_CALL_MULTI_PERFORM);

        curl_multi_close($multiHandle);
    }

    /*
     * @param $sitemap
     * @param bool $callback
     */
    public static function set($sitemap, $callback = false)
    {

        self::$sitemaps[] = $sitemap;

        if ($callback) {
            Event::listen($sitemap . ".sitemap", function () use ($sitemap, $callback) {
                if ($callback) {
                    self::$currentSitemap = $sitemap;
                    call_user_func_array($callback, [new self()]);
                }
            });
        }
    }

    /*
     * @param string $url
     * @param bool $date
     * @param float $freq
     * @param string $priority
     * @return Map
     */
    function url($url = "", $date = false, $freq = 0.9, $priority = "hourly")
    {

        self::$item = new self();

        self::$item->sitemap = self::$currentSitemap;

        self::$item->loc = $url;

        $this->date($date);
        $this->freq($freq);
        $this->priority($priority);

        self::$items[$url] = self::$item;

        return self::$item;
    }

    /*
     * @param bool $date
     * @return mixed
     */
    function date($date = false)
    {
        self::$item->lastmod = ($date) ? $date : date("Y-m-d H:i:s");
        self::$items[self::$item->loc] = self::$item;
        return self::$item;
    }

    /*
     * @param string $freq
     * @return mixed
     */
    function freq($freq = "hourly")
    {
        self::$item->changefreq = $freq;
        self::$items[self::$item->loc] = self::$item;
        return self::$item;
    }

    /*
     * @param string $priority
     * @return mixed
     */
    function priority($priority = "0.9")
    {
        self::$item->priority = $priority;
        self::$items[self::$item->loc] = self::$item;
        return self::$item;
    }

}
