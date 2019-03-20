@extends("admin::layouts.master")

@section("content")

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
            <h2>
                <i class="fa fa-money"></i>
                {{ trans("companies::companies.transactions") }}
            </h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route("admin") }}">{{ trans("admin::common.admin") }}</a>
                </li>
                <li>
                    <a href="{{ route("admin.companies.transactions") }}">{{ trans("companies::companies.transactions") }}
                        ({{ $transactions->total() }})</a>
                </li>
            </ol>
        </div>
    </div>

    <div class="wrapper wrapper-content fadeInRight">

        <div id="content-wrapper">

            @include("admin::partials.messages")

            <form action="" method="get" class="filter-form">
                <input type="hidden" name="per_page" value="{{ Request::get('per_page') }}"/>

                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <select name="sort" class="form-control chosen-select chosen-rtl">
                                <option value="created_at"
                                        @if($sort == "created_at") selected='selected' @endif>{{ trans("companies::companies.attributes.created_at") }}</option>
                                <option value="points"
                                        @if($sort == "created_at") selected='selected' @endif>{{ trans("companies::companies.attributes.points") }}</option>
                            </select>
                            <select name="order" class="form-control chosen-select chosen-rtl">
                                <option value="DESC"
                                        @if($order == "DESC") selected='selected' @endif>{{ trans("companies::companies.desc") }}</option>
                                <option value="ASC"
                                        @if($order == "ASC") selected='selected' @endif>{{ trans("companies::companies.asc") }}</option>
                            </select>
                            <button type="submit"
                                    class="btn btn-primary">{{ trans("companies::companies.order") }}</button>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="form-group">
                            <select name="action" class="form-control chosen-select chosen-rtl">
                                <option value="">{{trans('app.all_actions')}}</option>
                                @foreach(['tenders.buy'=>trans('app.types.tenders_buy'),
                                'points.buy'=>trans('app.types.points_buy'),
                                'add.chance'=>trans('app.types.add_chance')] as $key=>$val)
                                    <option value="{{$key}}" {{$key==request('action')?'selected':''}}>{{$val}}</option>
                                @endforeach
                            </select>
                            <button type="submit"
                                    class="btn btn-primary">{{ trans("companies::companies.filter") }}</button>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4">
                        <form action="" method="get" class="search_form">
                            <div class="input-group">
                                <input name="q" value="{{ Request::get("q") }}" type="text"
                                       class=" form-control"
                                       placeholder="{{ trans("companies::companies.search_companies") }} ...">
                                <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit"> <i class="fa fa-search"></i> </button>
                        </span>
                            </div>
                        </form>
                    </div>
                </div>
            </form>
            <form action="" method="post" class="action_form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>
                            <i class="fa fa-folder"></i>
                            {{ trans("companies::companies.transactions") }}
                        </h5>
                    </div>
                    <div class="ibox-content">
                        @if(count($transactions))
                            <div class="row">
                                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 action-box">

                                    <select name="action" class="form-control pull-left">
                                        <option value="-1"
                                                selected="selected">{{ trans("companies::companies.bulk_actions") }}</option>
                                    </select>
                                    <button type="submit"
                                            class="btn btn-primary pull-right">{{ trans("companies::companies.apply") }}</button>

                                </div>

                                <div class="col-lg-6 col-md-4 hidden-sm hidden-xs"></div>

                                <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                                    <select class="form-control per_page_filter">
                                        <option value="" selected="selected">
                                            -- {{ trans("companies::companies.per_page") }} --
                                        </option>
                                        @foreach (array(10, 50, 100, 150) as $num)
                                            <option value="{{ $num }}"
                                                    @if ($num == $per_page) selected="selected" @endif>{{ $num }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table cellpadding="0" cellspacing="0" border="0"
                                       class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th style="width:35px"><input type="checkbox" class="i-checks check_all"
                                                                      name="ids[]"/></th>
                                        <th>{{ trans("companies::companies.attributes.transaction_id") }}</th>
                                        <th>{{ trans("app.transaction_type") }}</th>
                                        <th>{{ trans("companies::companies.attributes.user_trans") }}
                                            ({{ trans("companies::companies.attributes.name")}})
                                        </th>
                                        <th>{{ trans("app.before_transaction") }}</th>
                                        <th>{{ trans("app.points") }}</th>
                                        <th>{{ trans("app.after_transactions") }}</th>
                                        <th>{{ trans("companies::companies.attributes.created_at") }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($transactions as $transaction)
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="i-checks" name="id[]"
                                                       value="{{ $transaction->id }}"/>
                                            </td>

                                            <td>
                                                <a data-toggle="tooltip" data-placement="bottom"
                                                   class="text-navy" href="javascript:void(0)">
                                                    <strong>{{$transaction->id }}</strong>
                                                </a>
                                            </td>

                                            <td>
                                                {{$transaction->type}}
                                            </td>
                                            <td>
                                                <a href="?user_id={{ @$transaction->user->id }}" class="text-navy">
                                                    <small> {{ @$transaction->user->first_name.' '.@$transaction->user->last_name }}</small>
                                                </a>
                                                @if($transaction->user&&$transaction->user->in_company)
                                                   ( <a href="?company_id={{$transaction->user->company[0]->id}}">{{$transaction->user->company[0]->name}}</a>)
                                                @endif

                                            </td>
                                            <td>
                                                {{$transaction->before_points}}
                                            </td>
                                            <td>
                                                @if($transaction->before_points < $transaction->after_points)
                                                    <i class="fa fa-arrow-up text-success"></i>
                                                @else
                                                    <i class="fa fa-arrow-down text-danger"></i>

                                                @endif
                                                {{$transaction->points}}
                                            </td>
                                            <td>
                                                {{$transaction->after_points}}
                                            </td>

                                            <td>
                                                <small>{{ $transaction->created_at->format('Y-m-d h:i a') }}</small>
                                            </td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    {{ trans("companies::companies.page") }} {{ $transactions->currentPage() }} {{ trans("companies::companies.of") }} {{ $transactions->lastPage() }}
                                </div>
                                <div class="col-lg-12 text-center">
                                    {{ $transactions->appends(Request::all())->render() }}
                                </div>
                            </div>
                        @else
                            {{ trans("companies::companies.no_records") }}
                        @endif
                    </div>
                </div>
            </form>
        </div>

    </div>

@endsection


@push("footer")

    <script>

        $(document).ready(function () {

            $('[data-toggle="tooltip"]').tooltip();

            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
            $('.check_all').on('ifChecked', function (event) {
                $("input[type=checkbox]").each(function () {
                    $(this).iCheck('check');
                    $(this).change();
                });
            });
            $('.check_all').on('ifUnchecked', function (event) {
                $("input[type=checkbox]").each(function () {
                    $(this).iCheck('uncheck');
                    $(this).change();
                });
            });
            $(".filter-form input[name=per_page]").val($(".per_page_filter").val());
            $(".per_page_filter").change(function () {
                var base = $(this);
                var per_page = base.val();
                $(".filter-form input[name=per_page]").val(per_page);
                $(".filter-form").submit();
            });
        });

    </script>

@endpush

