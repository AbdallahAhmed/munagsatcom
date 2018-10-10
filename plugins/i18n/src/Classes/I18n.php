<?php

namespace Dot\I18n\Classes;

class I18n {

    protected $app;

    protected $config = [];

    public function __construct($app)
    {
        $this->app = $app;
        $this->config = $app["config"]["i18n"];
    }

    public function parseLocale(){

        if($this->config["locale_driver"] == "session"){
            if(session()->has("locale")){
                return session()->get("locale");
            }
        }

        if($this->config["locale_driver"] == "url"){
            if (array_key_exists(request()->segment(1), $this->config["locales"])) {
                return request()->segment(1);
            }
        }

        return false;
    }

    public function setLocale($locale){

    }

    public function parseCountry(){

    }

    public function getCountry(){

    }
}
