<?php

namespace Dot\Seo\Controllers;

use Dot\Platform\Controller;
use Dot\Seo\Facades\Sitemap;
use Illuminate\Support\Facades\Request;

/*
 * Class ServicesController
 * @package Dot\Seo\Controllers
 */
class ServicesController extends Controller
{

    /*
     * Update sitemap links
     * @return array
     */
    function sitemap()
    {

        $error = NULL;

        try {
            Sitemap::render("sitemap");
        } catch (\Exception $error) {
            $error = $error->getMessage();
        }

        return ['status' => !$error, "error" => $error];
    }

    /*
     * Get search results from google
     * @return string
     */
    function keywords()
    {

        $keywords = array();

        $data = file_get_contents('http://suggestqueries.google.com/complete/search?output=firefox&client=firefox&hl=ar-EG&q=' . Request::get("term"));

        if (($data = json_decode($data, true)) !== null) {
            foreach ($data[1] as $item) {
                $keyword = new stdClass();
                $keyword->name = $item;
                $keywords[] = $keyword;
            }
        }

        return json_encode($keywords);
    }


}
