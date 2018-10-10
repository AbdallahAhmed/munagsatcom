<div class="row">

    <div class="col-md-12">
        <div class="panel ">
            <div class="panel-body">
                <div class="tab-content">
                    <div id="options_main" class="tab-pane active">
                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="facebook_page">
                                        <i class="fa fa-facebook-square"></i>
                                        {{ trans("seo::options.attributes.facebook_page") }}
                                    </label>
                                    <input name="option[facebook_page]" type="url"
                                           value="{{ Request::old("option.facebook_page", option("facebook_page")) }}"
                                           class="form-control forign-box" id="facebook_page"
                                           placeholder="https://www.facebook.com/fanpage">
                                </div>

                                <div class="form-group">
                                    <label for="twitter_page">
                                        <i class="fa fa-twitter-square"></i>
                                        {{ trans("seo::options.attributes.twitter_page") }}
                                    </label>
                                    <input name="option[twitter_page]" type="url"
                                           value="{{ Request::old("option.twitter_page", option("twitter_page")) }}"
                                           class="form-control forign-box" id="twitter_page"
                                           placeholder="https://twitter.com/fanpage">
                                </div>

                                <div class="form-group">
                                    <label for="googleplus_page">
                                        <i class="fa fa-google-plus-square"></i>

                                        {{ trans("seo::options.attributes.googleplus_page") }}
                                    </label>
                                    <input name="option[googleplus_page]" type="url"
                                           value="{{ Request::old("option.googleplus_page", option("googleplus_page")) }}"
                                           class="form-control forign-box" id="googleplus_page"
                                           placeholder="https://plus.google.com/+fanpage">
                                </div>

                                <div class="form-group">
                                    <label for="youtube_page">
                                        <i class="fa fa-youtube-square"></i>

                                        {{ trans("seo::options.attributes.youtube_page") }}
                                    </label>
                                    <input name="option[youtube_page]" type="url"
                                           value="{{ Request::old("option.youtube_page", option("youtube_page")) }}"
                                           class="form-control forign-box" id="youtube_page"
                                           placeholder="https://www.youtube.com/channel/fanpage">
                                </div>

                                <div class="form-group">
                                    <label for="instagram_page">
                                        <i class="fa fa-instagram"></i>

                                        {{ trans("seo::options.attributes.instagram_page") }}
                                    </label>
                                    <input name="option[instagram_page]" type="url"
                                           value="{{ Request::old("option.instagram_page", option("instagram_page")) }}"
                                           class="form-control forign-box" id="instagram_page"
                                           placeholder="https://instagram.com/fanpage">
                                </div>

                                <div class="form-group">
                                    <label for="soundcloud_page">
                                        <i class="fa fa-soundcloud"></i>

                                        {{ trans("seo::options.attributes.soundcloud_page") }}
                                    </label>
                                    <input name="option[soundcloud_page]" type="url"
                                           value="{{ Request::old("option.soundcloud_page", option("soundcloud_page")) }}"
                                           class="form-control forign-box" id="soundcloud_page"
                                           placeholder="https://soundcloud.com/fanpage">
                                </div>

                                <div class="form-group">
                                    <label for="linkedin_page">
                                        <i class="fa fa-linkedin-square"></i>

                                        {{ trans("seo::options.attributes.linkedin_page") }}
                                    </label>
                                    <input name="option[linkedin_page]" type="url"
                                           value="{{ Request::old("option.linkedin_page", option("linkedin_page")) }}"
                                           class="form-control forign-box" id="linkedin_page"
                                           placeholder="https://www.linkedin.com/profile">
                                </div>

                            </div>


                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

</div>
