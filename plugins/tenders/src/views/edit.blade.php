@extends("admin::layouts.master")

@section("content")

    <form action="" method="post">

        <div class="row wrapper border-bottom white-bg page-heading">

            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <h2>
                    <i class="fa fa-newspaper-o"></i>
                    {{ $tender->id ? trans("tenders::tenders.edit") : trans("tenders::tenders.add_new") }}
                </h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="{{ route("admin") }}">{{ trans("admin::common.admin") }}</a>
                    </li>
                    <li>
                        <a href="{{ route("admin.tenders.show") }}">{{ trans("tenders::tenders.tenders") }}</a>
                    </li>
                    <li class="active">
                        <strong>
                            {{ $tender->id ? trans("tenders::tenders.edit") : trans("tenders::tenders.add_new") }}
                        </strong>
                    </li>
                </ol>
            </div>

            <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12 text-right">

                @if ($tender->id)
                    <a href="{{ route("admin.tenders.create") }}" class="btn btn-primary btn-labeled btn-main"> <span
                                class="btn-label icon fa fa-plus"></span>
                        {{ trans("tenders::tenders.add_new") }}</a>
                @endif

                <button type="submit" class="btn btn-flat btn-danger btn-main">
                    <i class="fa fa-download" aria-hidden="true"></i>
                    {{ trans("tenders::tenders.save_post") }}
                </button>

            </div>
        </div>

        <div class="wrapper wrapper-content fadeInRight">

            @include("admin::partials.messages")

            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-body">

                            <div class="form-group">
                                <label>{{ trans("tenders::tenders.attributes.name") }}</label>
                                <textarea name="name" class="form-control input-lg" rows="1" id="tender_name"
                                          placeholder="{{ trans("tenders::tenders.attributes.name") }}">{{ @Request::old("name", $tender->name) }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>{{ trans("tenders::tenders.attributes.objective") }}</label>
                                <textarea name="objective" rows="4" class="form-control input-lg" rows="1"
                                          id="tender-goal"
                                          placeholder="{{ trans("tenders::tenders.attributes.objective") }}">{{ @Request::old("objective", $tender->objective) }}</textarea>
                            </div>


                            {{--<div class="form-group">--}}
                            {{--<label>$ {{ trans("tenders::tenders.attributes.price") }} </label>--}}
                            {{--<input name="price" type="number" min="1"  step="0.01" class="form-control" rows="1"--}}
                            {{--id="tender-goal"--}}
                            {{--placeholder="{{ trans("tenders::tenders.attributes.price") }}" value="{{ @Request::old("price", $tender->price) }}">--}}
                            {{--</div>--}}

                            <div class="form-group">
                                <label>{{ trans("tenders::tenders.attributes.org_id") }}</label>
                                <select name="org_id" class="form-control chosen-select chosen-rtl"
                                        id="input-orgid">
                                    @foreach(Dot\Tenders\Models\TenderOrg::where('status',1)->get() as $org)
                                        <option value="{{$org->id}}" {{old('org_id',$tender->org_id)==$org->id?'selected':""}}>{{$org->name}}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group">
                                <label>{{ trans("tenders::tenders.attributes.activity_id") }}</label>
                                <select name="activity_id" class="form-control chosen-select chosen-rtl"
                                        id="input-activity_id">
                                    @php
                                        $activities= Dot\Tenders\Models\TenderActivity::where('status',1)->get()
                                    @endphp
                                    @if(count($activities)<=0)
                                        <option> {{trans('tenders::tenders.no_activity')}}</option>
                                    @endif
                                    @foreach($activities as $activity)
                                        <option value="{{$activity->id}}" {{old('activity_id',$tender->activity_id)==$activity->id?'selected':""}} >{{$activity->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>{{ trans("tenders::tenders.attributes.number") }} </label>
                                <input name="number" type="text" class="form-control"
                                       id="tender-goal"
                                       placeholder="{{ trans("tenders::tenders.attributes.number") }}"
                                       value="{{ @Request::old("number", $tender->number) }}">
                            </div>
                        </div>
                    </div>


                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-book" aria-hidden="true"></i>
                            {{trans('tenders::tenders.cb')}}
                        </div>
                        <div class="panel-body">
                            <div class="cb-wrapper">
                                <a href="javascript:void(0)" class="btn btn-primary change-pdf">
                                    {{trans('tenders::tenders.cb_upload_or_choice')}}
                                </a>
                                <input type="hidden" name="cb_id" id="cb-id" value="{{old('cb_id',@$tender->cb_id)}}">
                                <span id="cp-title"> {{$tender->id&&$tender->cb_id!=0?@(\Dot\Media\Models\Media::find($tender->cb_id)->title).'.pdf':trans('tenders::tenders.no_cb_uploaded')}}</span>
                            </div>

                            <div id="cb-price" style="display: {{$tender->cb_id==0?'none':'block'}}">

                                <br>

                                <div class="form-group">
                                    <label>{{ trans("tenders::tenders.attributes.cb_real_price") }}</label>
                                    <input type="text" name="cb_real_price" class="form-control input-lg"
                                           placeholder="{{ trans("tenders::tenders.attributes.cb_real_price") }}"
                                           maxlength="10"
                                           min="0"
                                           value="{{ @Request::old("cb_real_price", $tender->cb_real_price) }}"/>
                                </div>


                                <div class="form-group switch-row">
                                    <label class="col-sm-9 control-label"
                                           for="input-is_cb_ratio_active">{{ trans("tenders::tenders.attributes.is_cb_ratio_active") }}</label>
                                    <div class="col-sm-3">
                                        <input @if (@Request::old("is_cb_ratio_active", $tender->is_cb_ratio_active)) checked="checked"
                                               @endif
                                               type="checkbox" id="input-is_cb_ratio_active" name="is_cb_ratio_active"
                                               value="1"
                                               class="status-switcher switcher-sm">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label id="cb_downloaded_price"
                                           @if (@Request::old("is_cb_ratio_active", $tender->is_cb_ratio_active)) style="display: none"
                                            @endif

                                    >{{ trans("tenders::tenders.attributes.cb_downloaded_price") }}</label>
                                    <input type="text" min="0"
                                           name="cb_downloaded_price" class="form-control input-lg"

                                           @if (@Request::old("is_cb_ratio_active", $tender->is_cb_ratio_active)) style="display: none"
                                           @endif

                                           placeholder="{{ trans("tenders::tenders.attributes.cb_downloaded_price") }}"
                                           id="input-cb_downloaded_price"
                                           value="{{ @Request::old("cb_downloaded_price", $tender->cb_downloaded_price) }}"/>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-book" aria-hidden="true"></i>
                            {{trans('tenders::tenders.information')}}

                            <a href="javascript:void(0)" class="btn btn-primary change-info-pdf">
                                {{trans('tenders::tenders.add_files')}}
                            </a>
                        </div>
                        <div class="panel-body">
                            <ul class="list-group" id="file-list">
                                @foreach($files as $file)
                                    <li class="list-group-item">
                                        <a href="{{uploads_url($file->path)}}" target="_blank">{{$file->title}}.pdf</a>
                                        <button type="button" class="close" data-dismiss="list-group-item"
                                                aria-hidden="true">
                                            &times;
                                        </button>
                                        <input type="hidden" name="files[]" value="{{$file->id}}"/>
                                    </li>
                                @endforeach

                            </ul>
                            @if(count($files)==0)
                                <p id="list-no-files" class="text-center">{{trans('tenders::tenders.not_files')}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                            {{trans('tenders::tenders.addresses')}}
                        </div>
                        <div class="panel-body">

                            <div class="form-group">
                                <label>{{ trans("tenders::tenders.attributes.address_get_offer") }}</label>
                                <textarea name="address_get_offer" class="form-control input-lg" rows="1"
                                          id="tender-address_get_offer"
                                          maxlength="249"
                                          placeholder="{{ trans("tenders::tenders.attributes.address_get_offer") }}">{{ @Request::old("address_get_offer", $tender->address_get_offer) }}</textarea>
                            </div>


                            <div class="form-group">
                                <label>{{ trans("tenders::tenders.attributes.address_files_open") }}</label>
                                <textarea name="address_files_open" class="form-control input-lg" rows="1"
                                          id="tender-address_files_open" maxlength="249" max="249"
                                          placeholder="{{ trans("tenders::tenders.attributes.address_files_open") }}">{{ @Request::old("address_files_open", $tender->address_files_open) }}</textarea>
                            </div>


                            <div class="form-group">
                                <label>{{ trans("tenders::tenders.attributes.address_execute") }}</label>
                                <textarea name="address_execute" class="form-control input-lg" rows="1"
                                          id="tender-address_execute"
                                          maxlength="249"
                                          placeholder="{{ trans("tenders::tenders.attributes.address_execute") }}">{{ @Request::old("address_execute", $tender->address_execute) }}</textarea>
                            </div>


                            <div class="form-group" style="position:relative">
                                <label>{{ trans("tenders::tenders.attributes.places") }}</label>

                                <select name="tender_places[]" class="form-control" multiple="multiple"
                                        id="tender_places">
                                    @foreach($tender->places as $place)
                                        <option value="{{$place->id}}" selected>{{$place->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    @foreach(Action::fire("tender.form.featured", $tender) as $output)
                        {!!  $output !!}
                    @endforeach

                </div>
                <div class="col-md-4">
                    @if(Auth::user()->can('tenders.publish'))
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-check-square"></i>
                            {{ trans("tenders::tenders.tender_status") }}
                        </div>
                        <div class="panel-body">
                            <div class="form-group switch-row">
                                <label class="col-sm-9 control-label"
                                       for="input-status">{{ trans("tenders::tenders.attributes.status") }}</label>
                                <div class="col-sm-3">
                                    <input @if (@Request::old("status", $tender->status)) checked="checked" @endif
                                    type="checkbox" id="input-status" name="status" value="1"
                                           class="status-switcher switcher-sm">
                                </div>
                            </div>

                        </div>

                    </div>

                    @endif

                    @foreach(Action::fire("tender.form.sidebar") as $output)
                        {!! $output !!}
                    @endforeach

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-calendar" aria-hidden="true"></i>

                            {{trans('tenders::tenders.dates')}}
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label>{{ trans("tenders::tenders.attributes.published_at") }}</label>
                                <div class="input-group date datetimepick">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input name="published_at" type="text"
                                           value="{{ (!$tender->id) ? date("Y-m-d H:i:s") : @Request::old('published_at', $tender->published_at) }}"
                                           class="form-control" id="input-published_at"
                                           placeholder="{{ trans("posts::posts.attributes.published_at") }}">
                                </div>
                            </div>


                            <div class="form-group">
                                <label>{{ trans("tenders::tenders.attributes.last_queries_at") }}</label>
                                <div class="input-group date datetimepick">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input name="last_queries_at" type="text"
                                           value="{{ (!$tender->id) ? date("Y-m-d H:i:s") : @Request::old('last_queries_at', $tender->last_queries_at) }}"
                                           class="form-control" id="input-last_queries_at"
                                           placeholder="{{ trans("posts::posts.attributes.last_queries_at") }}">
                                </div>
                            </div>


                            <div class="form-group">
                                <label>{{ trans("tenders::tenders.attributes.last_get_offer_at") }}</label>
                                <div class="input-group date datetimepick">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input name="last_get_offer_at" type="text"
                                           value="{{ (!$tender->id) ? date("Y-m-d H:i:s") : @Request::old('last_get_offer_at', $tender->last_get_offer_at) }}"
                                           class="form-control" id="input-last_get_offer_at"
                                           placeholder="{{ trans("posts::posts.attributes.last_get_offer_at") }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>{{ trans("tenders::tenders.attributes.files_opened_at") }}</label>
                                <div class="input-group date datetimepick">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input name="files_opened_at" type="text"
                                           value="{{ (!$tender->id) ? date("Y-m-d H:i:s") : @Request::old('files_opened_at', $tender->files_opened_at) }}"
                                           class="form-control" id="input-files_opened_at"
                                           placeholder="{{ trans("posts::posts.attributes.files_opened_at") }}">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>

    </form>

@stop


@section("head")

    <link href="{{ assets("admin::tagit") }}/jquery.tagit.css" rel="stylesheet" type="text/css">
    <link href="{{ assets("admin::tagit") }}/tagit.ui-zendesk.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('/css') }}/select2.min.css" rel="stylesheet" type="text/css">

    <link href="{{ assets('admin::css/plugins/datetimepicker/bootstrap-datetimepicker.min.css') }}"
          rel="stylesheet" type="text/css">


    <style>
        .custom-field-name {
            width: 40%;
            margin: 5px;
        }

        .custom-field-value {
            width: 50%;
            margin: 5px;
        }

        .remove-custom-field {
            margin: 10px;
        }

        .meta-rows {

        }

        .meta-row {
            background: #f1f1f1;
            overflow: hidden;
            margin-top: 4px;
        }

        .title {
            font-size: 18px !important;
        }

        .cp-title {
            padding: 0 5px;
        }

    </style>

@stop

@section("footer")

    <script type="text/javascript" src="{{ assets("admin::tagit") }}/tag-it.js"></script>
    <script type="text/javascript" src="{{ assets('admin::js/plugins/moment/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/select2.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ assets('admin::js/plugins/datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>

    <script>

        $(document).ready(function () {

            $("#tender_places").select2({
                ajax: {
                    url: "<?php echo route("admin.tenders.places.search"); ?>",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        var query = {
                            q: params.term,
                            status:1
                        };

                        // Query parameters will be ?search=[term]&type=public
                        return query;
                    },
                    processResults: function (data) {
                        // Tranforms the top-level key of the response object from 'items' to 'results'
                        console.log(data);
                        var items = data.map(function (e) {
                            return {
                                text: e.name['{{app()->getLocale()}}'],
                                id: e.id,
                                self: e,
                            }
                        });
                        return {
                            results: items
                        };
                    }
                },
                dir: "{{app()->getLocale()=="ar"?"rtl":"ltr"}}"
            });

            $('.datetimepick').datetimepicker({
                format: 'YYYY-MM-DD HH:mm:ss',
            });

            $('#input-is_cb_ratio_active').change(function (e) {

                if (e.target.checked) {
                    $('#input-cb_downloaded_price').hide()
                    $('#cb_downloaded_price').hide()
                } else {
                    $('#input-cb_downloaded_price').show()
                    $('#cb_downloaded_price').show()


                }
            })

            $("[name=format]").on('ifChecked', function () {
                $(this).iCheck('check');
                $(this).change();
                switch_format($(this));
            });

            switch_format($("[name=format]:checked"));

            function switch_format(radio) {

                var format = radio.val();

                $(".format-area").hide();
                $("." + format + "-format-area").show();
            }


            var elems = Array.prototype.slice.call(document.querySelectorAll('.status-switcher'));
            elems.forEach(function (html) {
                var switchery = new Switchery(html, {size: 'small'});
            });


            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });


            $(".change-pdf").filemanager({
                types: null,
                panel: "media",
                done: function (result, base) {
                    if (result.length) {
                        var file = result[0];
                        base.closest(".cb-wrapper").find("#cb-id").first().val(file.id);
                        base.closest(".cb-wrapper").find('#cp-title').html(file.title)
                        $('#cb-price').fadeIn(1000);
                    }
                },
                error: function (media_path) {
                    alert_box("{{ trans("tenders::tenders.not_media_file") }}");
                }
            });

            $(".change-info-pdf").filemanager({
                // types: "pdf",
                panel: "media",
                done: function (result) {
                    $('#list-no-files').fadeOut(100);
                    if (result.length) {
                        let listHtml = result.map(function (file) {
                            return '<li class="list-group-item">' +
                                '                                    <a href="javascript:void(0)">' + file.title + '.pdf</a>' +
                                '                                    <button type="button" class="close" data-dismiss="list-group-item" aria-hidden="true">' +
                                '                                        &times;</button>' +
                                '                                    <input type="hidden" name="files[]" value="' + file.id + '"/></li>';
                        });
                        $(listHtml.join('')).hide().appendTo('#file-list').fadeIn(500);
                    }
                },
                error: function (media_path) {
                    alert_box("{{ trans("tenders::tenders.not_media_file") }}");
                }
            });

            $('.list-group').on('click', '.list-group-item button', function (e) {
                $(this).parent().fadeOut(300, function () {
                    $(e.target).parent().remove()
                });
            });
        });


    </script>

@stop
