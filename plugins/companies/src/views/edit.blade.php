@extends("admin::layouts.master")

@section("content")

    <form action="" method="post">

        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <h2>
                    <i class="fa fa-folder"></i>
                    {{ $company ? trans("companies::companies.edit") : trans("companies::companies.add_new") }}
                </h2>
                <ol class="breadcrumb">
                    <li>
                        <a href="{{ route("admin") }}">{{ trans("admin::common.admin") }}</a>
                    </li>
                    <li>
                        <a href="{{ route("admin.companies.show") }}">{{ trans("companies::companies.companies") }}</a>
                    </li>
                    <li class="active">
                        <strong>
                            {{ $company ? trans("companies::companies.edit") : trans("companies::companies.add_new") }}
                        </strong>
                    </li>
                </ol>
            </div>
            <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12 text-right">

                @if ($company)
                    <a href="{{ route("admin.companies.create") }}"
                       class="btn btn-primary btn-labeled btn-main"> <span
                                class="btn-label icon fa fa-plus"></span>
                        &nbsp; {{ trans("companies::companies.add_new") }}</a>
                @endif

                <button type="submit" class="btn btn-flat btn-danger btn-main">
                    <i class="fa fa-download" aria-hidden="true"></i>
                    {{ trans("companies::companies.save_company") }}
                </button>

            </div>
        </div>

        <div class="wrapper wrapper-content fadeInRight">

            @include("admin::partials.messages")

            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            <div class="row">
                <div class="col-md-8">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label
                                            for="input-name">{{ trans("companies::companies.attributes.name") }}</label>
                                    <input name="name" type="text"
                                           value="{{ @Request::old("name", $company->name) }}"
                                           class="form-control" id="input-name"
                                           placeholder="{{ trans("companies::companies.attributes.name") }}">
                                </div>

                                <div class="form-group">
                                    <label
                                            for="input-slug">{{ trans("companies::companies.attributes.first_name") }}</label>
                                    <input name="first_name" type="text"
                                           value="{{ @Request::old("first_name", $company->first_name) }}"
                                           class="form-control" id="input-slug"
                                           placeholder="{{ trans("companies::companies.attributes.first_name") }}">
                                </div>
                                <div class="form-group">
                                    <label
                                            for="input-slug">{{ trans("companies::companies.attributes.last_name") }}</label>
                                    <input name="last_name" type="text"
                                           value="{{ @Request::old("last_name", $company->last_name) }}"
                                           class="form-control" id="input-slug"
                                           placeholder="{{ trans("companies::companies.attributes.last_name") }}">
                                </div>
                                <div class="form-group">
                                    <label
                                            for="input-slug">{{ trans("app.details") }}</label>
                                    <textarea name="details"
                                           value="{{ @Request::old("details", $company->details) }}"
                                           class="form-control" id="input-slug"
                                              rows="4"
                                              placeholder="{{ trans("app.details") }}"></textarea>
                                </div>
                                <div class="form-group">
                                    <label
                                            for="input-slug">{{ trans("app.fields.phone_number") }}</label>
                                    <input name="phone_number" type="text"
                                           value="{{ @Request::old("phone_number", $company->phone_number) }}"
                                           class="form-control" id="input-slug"
                                           placeholder="{{ trans("app.fields.phone_number") }}">
                                </div>
                                <div class="form-group">
                                    <label
                                            for="input-slug">{{ trans("app.fields.mobile_number") }}</label>
                                    <input name="phone_number" type="text"
                                           value="{{ @Request::old("mobile_number", $company->mobile_number) }}"
                                           class="form-control" id="input-slug"
                                           placeholder="{{ trans("app.fields.mobile_number") }}">
                                </div>
                                <div class="form-group">
                                    <label
                                            for="input-slug">{{ trans("app.address") }}</label>
                                    <input name="phone_number" type="text"
                                           value="{{ @Request::old("address", $company->address) }}"
                                           class="form-control" id="input-slug"
                                           placeholder="{{ trans("app.address") }}">
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-picture-o"></i>
                                {{ trans("companies::companies.logo") }}
                            </div>
                            <div class="panel-body form-group">
                                <div class="row post-image-block">
                                    <a class="post-image-preview"
                                       href="{{ ($company && $company->logo != 0) ? uploads_url().$company->image->path : "#" }}">
                                        <img width="100%" height="130px" class="post-image"
                                             src="{{ ($company && $company->image_id != 0) ? uploads_url().$company->image->path : assets("admin::default/image.png") }}">
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-folder"></i>
                                {{ trans("companies::companies.files") }}
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    @foreach($files as $file)
                                        <span><i class="fa fa-file-{{$file->type == "application" ? "word" : "image"}}-o"></i></span>
                                        <a href="{{uploads_url().$file->path}}"
                                           target="_blank">{{$file->title}}</a>
                                        <br>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-check-square"></i>
                            {{ trans("companies::companies.attributes.status") }}
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <select name="status" class="form-control chosen-select chosen-rtl">
                                    @foreach($status as $st)
                                        @if($company->status == $st)
                                            <option value="{{$st}}"
                                                    selected="selected">{{trans("companies::companies.status.$st")}}</option>
                                        @else
                                            <option value="{{$st}}">{{trans("companies::companies.status.$st")}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-ban"></i>
                            {{ trans("companies::companies.attributes.block") }}
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <select name="blocked" class="form-control chosen-select chosen-rtl">
                                    @if($company->blocked == 0)
                                        <option value="0"
                                                selected="selected">{{trans("companies::companies.unblocked")}}</option>
                                        <option value="1">{{trans("companies::companies.blocked")}}</option>
                                    @else
                                        <option value="1"
                                                selected="selected">{{trans("companies::companies.unblocked")}}</option>
                                        <option value="0">{{trans("companies::companies.blocked")}}</option>
                                    @endif
                                </select>
                                <div id="reason"
                                     style="display: @if($company->blocked == 1) block @else none @endif; margin-top: 20px">
                                    <label
                                            for="input-number">{{ trans("companies::companies.attributes.block_reason") }}</label>
                                    <input name="block_reason" type="text"
                                           value="{{$company->block_reason}}"
                                           class="form-control" id="input-name"
                                           placeholder="{{ trans("companies::companies.attributes.block_reason") }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-th-large"></i>
                            {{ trans("chances::sectors.sector") }}
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <select name="sector_id" class="form-control chosen-select chosen-rtl">
                                    @foreach($sectors as $sector)
                                        <option value="{{$sector->id}}"
                                                @if($company->sector_id == $sector->id)selected="selected"@endif>{{$sector->name}}</option>
                                    @endforeach
                                </select>
                                <div id="reason"
                                     style="display: @if($company->blocked == 1) block @else none @endif; margin-top: 20px">
                                    <label
                                            for="input-number">{{ trans("companies::companies.attributes.block_reason") }}</label>
                                    <input name="block_reason" type="text"
                                           value="{{$company->block_reason}}"
                                           class="form-control" id="input-name"
                                           placeholder="{{ trans("companies::companies.attributes.block_reason") }}">
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
        $(document).ready(function () {
            $('[name=blocked]').change(function () {
                if (this.value == 0)
                    $("#reason").css('display', 'none');
                else
                    $("#reason").css('display', 'block');
            })

        });
    </script>
@stop
