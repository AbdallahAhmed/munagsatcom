<div class="row">

    <div class="col-md-12">
        <div class="panel ">
            <div class="panel-body">

                <div id="options_seo" class="tab-pane">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="site_title">{{ trans("seo::options.attributes.site_title") }}</label>
                                <input name="option[site_title]" type="text" required="required"
                                       title="Lütfen işaretli yerleri doldurunuz"
                                       value="{{ Request::old("option.site_title", option("site_title")) }}"
                                       class="form-control" id="site_title"
                                       placeholder="{{ trans("seo::options.attributes.site_title") }}">
                            </div>

                            <div class="form-group">
                                <label
                                    for="site_description">{{ trans("seo::options.attributes.site_description") }}</label>
                                <br/>
                                <textarea class="form-control" id="site_description" name="option[site_description]"
                                          required="required" placeholder="{{ trans("seo::options.attributes.site_description") }}">{{ Request::old("option.site_description", option("site_description")) }}</textarea>
                            </div>

                            <div class="form-group">
                                <label
                                    for="site_author">{{ trans("seo::options.attributes.site_author") }}</label>
                                <input name="option[site_author]" type="text" required="required"
                                       value="{{ Request::old("option.site_author", option("site_author")) }}"
                                       class="form-control" id="site_author"
                                       placeholder="{{ trans("seo::options.attributes.site_author") }}">
                            </div>

                            <div class="form-group">
                                <label
                                    for="site_robots">{{ trans("seo::options.attributes.site_robots") }}</label>
                                <select id="site_robots" class="form-control chosen-select chosen-rtl"
                                        name="option[site_robots]">
                                    @foreach (array("INDEX, FOLLOW", "NOINDEX, NOFOLLOW", "INDEX, NOFOLLOW", "NOINDEX, FOLLOW") as $robot)
                                        <option value="{{ $robot }}"
                                                @if (option("site_robots") == $robot) selected="selected" @endif>{{ $robot }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="site_keywords">{{ trans("seo::options.attributes.site_keywords") }}</label>
                                <br/>
                                <input type="hidden" name="option[site_keywords]" id="tags_names"
                                       value="{{ Request::old("option.site_keywords", option("site_keywords")) }}">
                                <ul id="mytags"></ul>
                            </div>

                            <fieldset>
                                <legend>{{ trans("seo::options.attributes.site_logo") }}</legend>
                                <div class="row">
                                    <div class="col-md-3 text-center">
                                        <input id="site_logo_path" type="hidden"
                                               value="@if (option("site_logo") != "") {{ option("site_logo") }} @endif"
                                               id="user_photo_id" name="option[site_logo]"/>
                                        <img id="site_logo" style="border: 1px solid #ccc; width: 100%;"
                                             src="{{ (option("site_logo") != "") ? thumbnail(option("site_logo")) : assets("admin::default/image.png") }}"/>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <p>{{ trans("seo::options.chane_logo_help") }}</p>
                                            <a href="javascript:void(0)" id="change_logo" class="text-navy"
                                               @if(option("site_logo") != "") style="display: none" @endif>{{ trans("seo::options.change_logo") }}</a>
                                            <a href="javascript:void(0)" id="remove_logo" class="text-navy"
                                               @if(option("site_logo") == "") style="display: none" @endif>{{ trans("seo::options.remove_logo") }}</a>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>


                        </div>

                        <div class="col-md-6">

                            <fieldset>

                                <legend>
                                    {{ trans("seo::options.sitemap") }}
                                </legend>

                                @if(option("sitemap_last_update"))

                                    <div style="margin:5px 0">
                                        {{ trans("seo::options.attributes.sitemap_last_update") }}
                                        <i id="sitemap_last_update">{{ time_ago(option("sitemap_last_update")) }}</i>
                                    </div>

                                @endif

                                <br/>

                                <div style="clear:both"></div>

                                <div class="form-group switch-row">
                                    <label class="col-sm-10 control-label"
                                           for="sitemap_status">{{ trans("seo::options.attributes.sitemap_status") }}</label>
                                    <div class="col-sm-2">
                                        <input @if (option("sitemap_status", 0)) checked="checked" @endif
                                        type="checkbox" id="sitemap_status"
                                               value="1"
                                               class="option-switcher switcher-sm sitemap_status_check">
                                        <input type="hidden" name="option[sitemap_status]"
                                               value="{{ option("sitemap_status", 0) }}"/>
                                    </div>
                                </div>


                                <div id="sitemap_status_options"

                                     @if (option("sitemap_status", 0) == 0) style="display:none" @endif>

                                    <div class="well">
                                        <div class="form-group switch-row">
                                            <label class="col-sm-10 control-label"
                                                   for="sitemap_xml_status">{{ trans("seo::options.attributes.sitemap_xml_status") }}</label>
                                            <div class="col-sm-2">
                                                <input
                                                    @if (option("sitemap_xml_status", 0)) checked="checked" @endif
                                                type="checkbox" id="sitemap_xml_status"
                                                    name="" value="1"
                                                    class="option-switcher switcher-sm sitemap_xml_status_check">
                                                <input type="hidden" name="option[sitemap_xml_status]"
                                                       value="{{ option("sitemap_xml_status", 0) }}"/>
                                            </div>
                                        </div>

                                        <div class="form-group switch-row">
                                            <label class="col-sm-10 control-label"
                                                   for="sitemap_html_status">{{ trans("seo::options.attributes.sitemap_html_status") }}</label>
                                            <div class="col-sm-2">
                                                <input
                                                    @if (option("sitemap_html_status", 0)) checked="checked"
                                                    @endif
                                                    type="checkbox" id="sitemap_html_status" value="1"
                                                    class="option-switcher switcher-sm sitemap_html_status_check">
                                                <input type="hidden" name="option[sitemap_html_status]"
                                                       value="{{ option("sitemap_html_status", 0) }}"/>
                                            </div>
                                        </div>

                                        <div class="form-group switch-row">
                                            <label class="col-sm-10 control-label"
                                                   for="sitemap_txt_status">{{ trans("seo::options.attributes.sitemap_txt_status") }}</label>
                                            <div class="col-sm-2">
                                                <input
                                                    @if (option("sitemap_txt_status", 0)) checked="checked" @endif
                                                type="checkbox" id="sitemap_txt_status" value="1"
                                                    class="option-switcher switcher-sm sitemap_txt_status_check">
                                                <input type="hidden" name="option[sitemap_txt_status]"
                                                       value="{{ option("sitemap_txt_status", 0) }}"/>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group switch-row">
                                        <label class="col-sm-10 control-label"
                                               for="sitemap_ping">{{ trans("seo::options.attributes.sitemap_ping") }}</label>
                                        <div class="col-sm-2">
                                            <input
                                                @if (option("sitemap_ping_status")) checked="checked" @endif
                                            type="checkbox" id="sitemap_ping" value="1"
                                                class="option-switcher switcher-sm sitemap_ping_status_check">
                                            <input type="hidden" name="option[sitemap_ping_status]"
                                                   value="{{ option("sitemap_ping_status", 0) }}"/>
                                        </div>
                                    </div>

                                    <div class="well" id="sitemap_ping_options"
                                         @if (option("sitemap_ping_status", 0) == 0) style="display:none" @endif>
                                        <div class="form-group switch-row">
                                            <label class="col-sm-10 control-label"
                                                   for="sitemap_google_ping">{{ trans("seo::options.attributes.sitemap_google_ping") }}</label>
                                            <div class="col-sm-2">
                                                <input
                                                    @if (option("sitemap_google_ping_status", 0)) checked="checked"
                                                    @endif
                                                    type="checkbox" id="sitemap_google_ping" value="1"
                                                    class="option-switcher switcher-sm sitemap_google_ping_status_check">
                                                <input type="hidden" name="option[sitemap_google_ping_status]"
                                                       value="{{ option("sitemap_google_ping_status", 0) }}"/>
                                            </div>
                                        </div>

                                        <div class="form-group switch-row">
                                            <label class="col-sm-10 control-label"
                                                   for="sitemap_bing_ping">{{ trans("seo::options.attributes.sitemap_bing_ping") }}</label>
                                            <div class="col-sm-2">
                                                <input
                                                    @if (option("sitemap_bing_ping_status", 0)) checked="checked"
                                                    @endif
                                                    type="checkbox" id="sitemap_bing_ping" value="1"
                                                    class="option-switcher switcher-sm sitemap_bing_ping_status_check">
                                                <input type="hidden" name="option[sitemap_bing_ping_status]"
                                                       value="{{ option("sitemap_bing_ping_status", 0) }}"/>
                                            </div>
                                        </div>

                                        <div class="form-group switch-row">
                                            <label class="col-sm-10 control-label"
                                                   for="sitemap_yahoo_ping">{{ trans("seo::options.attributes.sitemap_yahoo_ping") }}</label>
                                            <div class="col-sm-2">
                                                <input @if (option("sitemap_yahoo_ping_status", 0)) checked="checked"
                                                       @endif
                                                       type="checkbox" id="sitemap_yahoo_ping" value="1"
                                                       class="option-switcher switcher-sm sitemap_yahoo_ping_status_check">
                                                <input type="hidden" name="option[sitemap_yahoo_ping_status]"
                                                       value="{{ option("sitemap_yahoo_ping_status", 0) }}"/>
                                            </div>
                                        </div>

                                        <div class="form-group switch-row">
                                            <label class="col-sm-10 control-label"
                                                   for="sitemap_ask_ping">{{ trans("seo::options.attributes.sitemap_ask_ping") }}</label>
                                            <div class="col-sm-2">
                                                <input @if (option("sitemap_ask_ping_status", 0)) checked="checked"
                                                       @endif
                                                       type="checkbox" id="sitemap_ask_ping" value="1"
                                                       class="option-switcher switcher-sm sitemap_ask_ping_status_check">
                                                <input type="hidden" name="option[sitemap_ask_ping_status]"
                                                       value="{{ option("sitemap_ask_ping_status", 0) }}"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label
                                            for="sitemap_path">{{ trans("seo::options.attributes.sitemap_path") }}</label>

                                        <input name="option[sitemap_path]" type="text"
                                               value="{{ Request::old("option.sitemap_path", option("sitemap_path", "/")) }}"
                                               class="form-control" id="sitemap_path"
                                               style="direction: ltr; text-align: left"
                                               placeholder="/">
                                    </div>


                                    @if (!File::isWritable(public_path(option("sitemap_path", "/"))))
                                        <div class="alert alert-danger" role="alert">
                                                <span class="pull-right text-left "> {{ public_path(option("sitemap_path", "/")) }}
                                                    {{ trans("seo::options.not_writable") }}
                                                </span>
                                            <span class="glyphicon glyphicon-exclamation-sign"
                                                  aria-hidden="true"></span>
                                        </div>
                                @endif

                            </fieldset>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>


@section("head")
    <link href="{{ assets("admin::tagit/jquery.tagit.css") }}" rel="stylesheet" type="text/css">
    <link href="{{ assets("admin::tagit/tagit.ui-zendesk.css") }}" rel="stylesheet" type="text/css">
@stop

@section("footer")

    <script src="{{ assets("admin::tagit/tag-it.js") }}"></script>

    <script>

        $(document).ready(function () {



            // Sitemap status checks

            var sitemap_status_check = document.querySelector('.sitemap_status_check');

            sitemap_status_check.onchange = function () {

                $("[name=option\\[sitemap_status\\]]").val(sitemap_status_check.checked ? 1 : 0);

                if (sitemap_status_check.checked) {
                    $("#sitemap_status_options").slideDown();
                } else {
                    $("#sitemap_status_options").slideUp();
                }
            };

            new Switchery(sitemap_status_check);


            var sitemap_xml_status_check = document.querySelector('.sitemap_xml_status_check');

            sitemap_xml_status_check.onchange = function () {
                $("[name=option\\[sitemap_xml_status\\]]").val(sitemap_xml_status_check.checked ? 1 : 0);
            };

            new Switchery(sitemap_xml_status_check);

            var sitemap_html_status_check = document.querySelector('.sitemap_html_status_check');

            sitemap_html_status_check.onchange = function () {
                $("[name=option\\[sitemap_html_status\\]]").val(sitemap_html_status_check.checked ? 1 : 0);
            };

            new Switchery(sitemap_html_status_check);

            var sitemap_txt_status_check = document.querySelector('.sitemap_txt_status_check');

            sitemap_txt_status_check.onchange = function () {
                $("[name=option\\[sitemap_txt_status\\]]").val(sitemap_txt_status_check.checked ? 1 : 0);
            };

            new Switchery(sitemap_txt_status_check);


            // Sitemap ping status checks


            var sitemap_ping_status_check = document.querySelector('.sitemap_ping_status_check');

            sitemap_ping_status_check.onchange = function () {

                $("[name=option\\[sitemap_ping_status\\]]").val(sitemap_ping_status_check.checked ? 1 : 0);

                if (sitemap_ping_status_check.checked) {
                    $("#sitemap_ping_options").slideDown();
                } else {
                    $("#sitemap_ping_options").slideUp();
                }
            };

            new Switchery(sitemap_ping_status_check);


            var sitemap_google_ping_status_check = document.querySelector('.sitemap_google_ping_status_check');

            sitemap_google_ping_status_check.onchange = function () {
                $("[name=option\\[sitemap_google_ping_status\\]]").val(sitemap_google_ping_status_check.checked ? 1 : 0);
            };

            new Switchery(sitemap_google_ping_status_check);

            var sitemap_bing_ping_status_check = document.querySelector('.sitemap_bing_ping_status_check');

            sitemap_bing_ping_status_check.onchange = function () {
                $("[name=option\\[sitemap_bing_ping_status\\]]").val(sitemap_bing_ping_status_check.checked ? 1 : 0);
            };

            new Switchery(sitemap_bing_ping_status_check);


            var sitemap_yahoo_ping_status_check = document.querySelector('.sitemap_yahoo_ping_status_check');

            sitemap_yahoo_ping_status_check.onchange = function () {
                $("[name=option\\[sitemap_yahoo_ping_status\\]]").val(sitemap_yahoo_ping_status_check.checked ? 1 : 0);
            };

            new Switchery(sitemap_yahoo_ping_status_check);

            var sitemap_ask_ping_status_check = document.querySelector('.sitemap_ask_ping_status_check');

            sitemap_ask_ping_status_check.onchange = function () {
                $("[name=option\\[sitemap_ask_ping_status\\]]").val(sitemap_ask_ping_status_check.checked ? 1 : 0);
            };

            new Switchery(sitemap_ask_ping_status_check);


            $('#update-sitemap').click(function () {
                btn = $(this);
                simpleLoad(btn, true)
                $.post("{{ route("sitemap.update") }}", function (date) {
                    $("#sitemap_last_update").text(date);
                    simpleLoad(btn, false);
                });
            });

            function simpleLoad(btn, state) {
                if (state) {
                    btn.children().addClass('fa-spin');
                    btn.contents().last().replaceWith(" {{ trans("seo::options.updating_sitemap") }}");
                } else {
                    btn.children().removeClass('fa-spin');
                    btn.contents().last().replaceWith(" {{ trans("seo::options.update_sitemap") }}");
                }
            }

            $("#change_logo").filemanager({
                types: "image",
                done: function (result, base) {
                    if (result.length) {
                        var file = result[0];
                        $("#site_logo_path").val(file.url.split("uploads/")[1]);
                        $("#site_logo").attr("src", file.url);

                        base.hide();
                        $("#remove_logo").show();
                    }
                },
                error: function (media_path) {
                    alert_box(media_path + " {{ trans("seo::options.file_not_supported") }}");
                }
            });

            $("#remove_logo").click(function () {
                $("#site_logo_path").val("");
                $("#site_logo").attr("src", "{{ assets("admin::default/image.png") }}");

                $(this).hide();
                $("#change_logo").show();
            });


            $("#mytags").tagit({
                singleField: true,
                singleFieldNode: $('#tags_names'),
                allowSpaces: true,
                minLength: 2,
                placeholderText: "",
                removeConfirmation: true,
                tagSource: function (request, response) {
                    $.ajax({
                        url: "{{ route("admin.google.search") }}", data: {term: request.term},
                        dataType: "json",
                        success: function (data) {
                            console.log(data);
                            response($.map(data, function (item) {
                                return {
                                    label: item.name,
                                    value: item.name
                                }
                            }));
                        }
                    });
                }
            });


        });
    </script>
@stop
