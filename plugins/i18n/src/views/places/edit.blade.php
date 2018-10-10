@extends("admin::layouts.master")

@section("content")

    <form action="" method="post">

        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <h2>
                    <i class="fa fa-map-marker"></i>
                    {{ $place ? trans("i18n::places.edit"):trans("i18n::places.add_new")}}
                </h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="{{route("admin")}}">{{trans("admin::common.admin")}}</a>
                    </li>
                    <li>
                        <a href="{{ route("admin.places.show") }}">{{trans("i18n::places.places")}}</a>
                    </li>

                    @if($country)
                        <li>
                            <a href="{{ route("admin.places.show", ["parent" => $country->id]) }}">
                                {{ $country->name }}
                            </a>
                        </li>
                    @endif

                    <li class="active">
                        <strong>
                            {{ $place ? trans("i18n::places.edit"):trans("i18n::places.add_new")}}
                        </strong>
                    </li>
                </ol>
            </div>
            <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12 text-right">

                @if ($place)
                    <a href="{{ @route("admin.places.create", ["parent" => $country->id])}}" class="btn btn-primary btn-labeled btn-main"> <span
                            class="btn-label icon fa fa-plus"></span> &nbsp;{{trans("i18n::places.add_new")}}</a>
                @endif

                <button type="submit" class="btn btn-flat btn-danger btn-main">
                    <i class="fa fa-download" aria-hidden="true"></i>
                    <?php echo trans("i18n::places.save_place") ?>
                </button>

            </div>
        </div>

        <div class="wrapper wrapper-content fadeInRight">

            @include("admin::partials.messages")

            {{csrf_field()}}

            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-default">

                        <div class="panel-body">

                            <div class="panel-options">
                                <ul class="nav nav-tabs">
                                    @if(count(config("i18n.locales")))
                                        @foreach(config("i18n.locales") as $key => $locale)
                                            <li @if($key == app()->getLocale()) class="active" @endif>
                                                <a data-toggle="tab" href="#tab-{{ $key }}" aria-expanded="true">
                                                    {{ $locale["title"] }}
                                                </a>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            <br/>

                            <div class="tab-content">

                                @foreach(config("i18n.locales") as $key => $locale)

                                    <div id="tab-{{ $key }}"
                                         class="tab-pane @if($key == app()->getLocale()) active @endif" style="direction: {{ $locale["direction"] }}">

                                        <div class="form-group">

                                            <label for="input-name">{{ trans("i18n::places.attributes.name", [], $key) }}</label>

                                            <input type="text" class="form-control" id="input-name"
                                                   value="{{ @Request::old("name.".$key, $place->name->$key) }}"
                                                   name="name[{{ $key }}]"
                                                   placeholder="{{trans("i18n::places.attributes.name", [], $key)}}">
                                        </div>

                                        <div class="form-group">

                                            <label
                                                for="input-currency">{{ trans("i18n::places.attributes.currency", [], $key) }}</label>

                                            @if($country)
                                                <input type="text" readonly class="form-control" name="currency[{{ $key }}]" value="{{ $country->currency }}">
                                            @else
                                                <input type="text" class="form-control" id="input-currency"
                                                   value="{{ @Request::old("currency.".$key, $place->currency->$key) }}"
                                                   name="currency[{{ $key }}]"
                                                   placeholder="{{trans("i18n::places.attributes.currency", [], $key)}}">
                                            @endif
                                        </div>

                                    </div>
                                @endforeach

                            </div>

                        </div>
                    </div>


                    <div class="panel panel-default">

                        <div class="panel-body">
                            <div class="form-group">

                                <label>{{ trans("i18n::places.attributes.code") }}</label>

                                @if($country)
                                    <input type="text" class="form-control" readonly name="code" value="{{ $country->code }}">
                                @else
                                <input type="text" class="form-control" id="code" name="code"
                                       value="{{ @Request::old('code', $place->code) }}"
                                       placeholder="{{trans("i18n::places.attributes.code")}}">
                                @endif
                            </div>


                        </div>

                    </div>

                    <div class="panel panel-default">

                        <div class="panel-heading">
                            {{trans("i18n::places.geo_settings")}}
                        </div>

                        <div class="panel-body">

                            <div class="form-group">

                                <label for="lat-input">{{ trans("i18n::places.attributes.lat") }}</label>

                                <input type="text" class="form-control" id="lat-input" name="lat"
                                       value="{{ @Request::old('lat', $place->lat) }}"
                                       placeholder="{{trans("i18n::places.attributes.lat")}}">
                            </div>

                            <div class="form-group">

                                <label for="lng-input">{{ trans("i18n::places.attributes.lng") }}</label>

                                <input type="text" class="form-control" id="lng-input" name="lng"
                                       value="{{ @Request::old('lng', $place->lng) }}"
                                       placeholder="{{trans("i18n::places.attributes.lng")}}">
                            </div>


                        </div>

                    </div>

                </div>

                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-check-square"></i>
                            {{ trans("i18n::places.attributes.status") }}
                        </div>
                        <div class="panel-body">
                            <div class="form-group switch-row">
                                <label class="col-sm-9 control-label"
                                       for="input-status">{{ trans("i18n::places.attributes.status") }}</label>
                                <div class="col-sm-3">
                                    <input @if (@Request::old("status", $place->status)) checked="checked" @endif
                                    type="checkbox" id="input-status" name="status" value="1"
                                           class="status-switcher switcher-sm">
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-camera"></i>
                            {{ trans("i18n::places.attributes.image") }}
                            <a class="remove-place-image pull-right" href="javascript:void(0)">
                                <i class="fa fa-times text-navy"></i>
                            </a>
                        </div>
                        <div class="panel-body form-group">
                            <div class="row post-image-block">
                                <input type="hidden" name="image_id" class="place-image-id"
                                       value="{{ ($place && $place->image) ? $place->image->id : 0 }}">

                                <a class="change-post-image label" href="javascript:void(0)">
                                    <i class="fa fa-pencil text-navy"></i>
                                    {{ trans("posts::posts.change_image") }}
                                </a>

                                <a class="post-media-preview" href="javascript:void(0)">
                                    <img width="100%" height="130px" class="place-image"
                                         src="{{ ($place and @$place->image) ? thumbnail($place->image->path) : assets("admin::default/image.png") }}">
                                </a>
                            </div>
                        </div>


                    </div>

                </div>


            </div>

        </div>

        </div>

    </form>

@stop


@section("footer")

    <script>

        var elems = Array.prototype.slice.call(document.querySelectorAll('.status-switcher'));

        elems.forEach(function (html) {
            var switchery = new Switchery(html, {size: 'small'});
        });

        $(".change-post-image").filemanager({
            types: "image",
            panel: "media",
            done: function (result, base) {
                if (result.length) {
                    var file = result[0];
                    base.parents(".post-image-block").find(".place-image-id").first().val(file.id);
                    base.parents(".post-image-block").find(".place-image").first().attr("src", file.thumbnail);
                }
            },
            error: function (media_path) {
                alert_box("{{ trans("i18n::places.not_image_file") }}");
            }
        });

        $(".remove-place-image").click(function () {
            var base = $(this);
            $(".place-image-id").first().val(0);
            $(".place-image").attr("src", "{{ assets("admin::default/post.png") }}");
        });


    </script>

@stop
