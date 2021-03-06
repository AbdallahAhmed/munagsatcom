@extends('layouts.master')

@section('title',trans('app.add_chance'))
@section('content')
    <section class="container">
        <div class="res-box">
            <h2 class="text-center">{{trans('app.add_chance')}}</h2>
            <div class="feildcont">
                @if (!session('status'))

                    {{--   @if(fauth()->user()->can_buy)
                           @if(mypoints()>option('rules_add_chances',0))--}}
                    <form method="post" id="form-submit"
                          action="{{route('chances.create', ['id' => $company->id])}}"
                          enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="reg-part">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li class="alert-danger">{{ $error }}</li>
                                @endforeach
                                <li class="alert-info">
                                    {{trans("services::points.rules_add_chances")}}
                                    ({{option('rules_add_chances',0)}})
                                    {{trans('app.point')}}
                                </li>
                            </ul>
                            <div class="form-group-lg row">
                                <label class="col-xs-12 col-md-3"> {{trans('app.chances.chance_name')}}</label>
                                <div class="col-xs-12 col-md-9">
                                    <div class="new-f-group">
                                        <div class="form-group clearfix">
                                            <input type="text" value="{{@Request::old("name")}}" name="name"
                                                   class="effect-9 form-control"
                                                   placeholder=" {{trans('app.chances.chance_name')}}">
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-lg row">
                                <label class="col-xs-12 col-md-3"> {{trans('app.chances.internal_number')}}</label>
                                <div class="col-xs-12 col-md-9">
                                    <div class="new-f-group">
                                        <div class="form-group clearfix">
                                            <input name="number" value="{{@Request::old("number")}}" type="text"
                                                   placeholder="{{trans('app.chances.internal_number')}}"
                                                   class="effect-9 form-control">
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-lg row">
                                <label class="col-xs-12 col-md-3">{{trans('app.chances.closing_date')}}</label>
                                <div class="col-xs-12 col-md-6 new-f-group">
                                    <div class="form-group clearfix">
                                        <div class="input-append date" id="dp3" data-date="12-02-2012"
                                             data-date-format="dd-mm-yyyy">
                                            <input name="closing_date" data-date-format="dd-mm-yyyy"
                                                   class="effect-9 form-control" id="date"
                                                   placeholder="dd-mm-yyyy"
                                                   type="text" value="{{old('closing_date')}}">
                                            <span class="add-on"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-xs-12 col-md-3"> {{trans('app.sectors.sector')}}</label>
                                <div class="col-xs-12 col-md-9 new-f-group">
                                    <div class="form-group clearfix">
                                        <select type="text" name="sector_id" class="effect-9 form-control">
                                            <option value="{{null}}">{{trans('app.sectors.choose_sector')}}</option>
                                            @foreach($sectors as $sector)
                                                <option value="{{$sector->id}}" {{old('sector_id')==$sector->id?'selected':''}}>{{$sector->name}}</option>
                                            @endforeach
                                        </select><span class="focus-border"><i></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="reg-part">
                            <h3>    {{trans('app.add_file')}}</h3>

                            <div class="form-group-lg row">
                                <div class="col-xs-12 col-md-8">
                                    <div class="new-f-group">
                                        <div class="form-group clearfix">
                                            <input type="text" name="files_names[]" class="effect-9 form-control"
                                                   placeholder="{{trans('app.file_data')}}">
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-4">
                                    <div class="new-f-group">
                                        <div class="form-group clearfix">
                                            <input type="file" name="files[]"
                                                   class="effect-9 form-control"
                                                   placeholder="{{trans('app.file')}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a class="add_field_button" role="button" data-toggle="collapse" id="filess"
                               aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-plus"></i>
                                {{trans('app.add_file')}}
                            </a>
                        </div>
                        <div class="reg-part">
                            <h3>    {{trans('app.units.units')}}</h3>

                            <div class="form-group-lg row">
                                <div class="col-xs-12 col-md-4">
                                    <div class="new-f-group">
                                        <div class="form-group clearfix">
                                            <input type="text" name="units_name[]" class="effect-9 form-control"
                                                   placeholder="{{trans('app.unit_name')}}">
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-4 new-f-group">
                                    <div class="form-group clearfix">
                                        <select name="units[]" class="effect-9 form-control">
                                            <option value="{{null}}">{{trans('app.units.unit')}}</option>

                                            @foreach($units as $unit)
                                                <option value="{{$unit->id}}">{{$unit->name}}</option>
                                            @endforeach
                                        </select><span class="focus-border"><i></i></span>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-4">
                                    <div class="new-f-group">
                                        <div class="form-group clearfix">
                                            <input type="text" name="units_quantity[]"
                                                   class="effect-9 form-control"
                                                   placeholder="{{trans('app.quantity')}}">
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a class="add_field_button" role="button" data-toggle="collapse" id="units"
                               aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-plus"></i>
                                {{trans('app.add_new_units')}}
                            </a>
                            <a id="others" class="add_field_button" style="margin-right: 20px" role="button"
                               data-toggle="collapse"
                               aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-plus"></i>
                                {{trans('app.add_other_units')}}
                            </a>
                        </div>
                        <div class="form-group-lg text-center">
                            <a type="button" data-toggle="modal"
                               data-target="#add_chances"
                               class="uperc padding-md fbutcenter">{{trans('app.chances.publish')}}</a>
                        </div>
                        <style>
                            .modal-header .close {
                                margin-top: -24px;
                            }
                        </style>
                        <div class="modal fade" id="add_chances" tabindex="-1" role="dialog"
                             aria-labelledby="add_chances"
                             aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"
                                            id="exampleModalCenterTitle"> {{trans('app.chances.publish')}}</h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    @php
                                        $user=fauth()->user()->in_company?fauth()->user()->company[0]:fauth()->user();
                                        $points=tax(option('rules_add_chances',0),false);
                                    @endphp
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">{{ trans('app.cb_price') }}
                                                :  {{ (option('rules_add_chances',0)) }} {{trans('app.point')}}</div>

                                            <div class="col-md-6">{{ trans('app.tax') }}
                                                : {{ tax(option('rules_add_chances',0)) }} {{trans('app.point')}}</div>
                                        </div>
                                        <hr>
                                        <p> {{ trans('app.current_points') }}
                                            : {{ $user->points }} {{trans('app.point')}}</p>
                                        <hr>
                                        <p class="{{$user->points -$points<=0?'text-danger':''}}"> {{ trans('app.points_after_buy') }}
                                            : {{ $user->points - $points }} {{trans('app.point')}}</p>
                                        <hr>
                                        @if($user->points -$points>=0)
                                            <p class="fieldset" style="margin: 0;">
                                                <input type="checkbox" name="terms" id="accept-terms">
                                                <label for="accept-terms">{{trans('app.accept_with')}} <a
                                                            target="_blank"
                                                            href="{{route('page.show', ['slug' => 'الشروط والأحكام'])}}"
                                                            class="text-primary">{{trans('app.terms')}}</a></label>
                                            </p>
                                        @endif
                                        <p class="text-danger">{{$user->points - $points<0?trans('app.please_recharge'):''}}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit"
                                                class="btn btn-primary  submit-changes"
                                                id="{{$user->points - $points<0?'':'can-buy'}}"
                                                disabled>{{trans('app.chances.publish')}}</button>
                                        <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">{{trans('app.close')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    {{-- @else
                         <div class="alert alert-danger">
                             {{ trans('app.bankrupt') }}
                             <a href="{{route('user.recharge')}}">
                                 {{trans('app.recharge')}}
                             </a>
                         </div>
                     @endif

                 @else
                     <div class="alert alert-warning">
                         {{trans('app.you_cannot_add_chance')}}
                     </div>
                 @endif--}}
                @else
                    <div class="alert alert-success">
                        {!! session('status')  !!}
                    </div>
                @endif
            </div>
        </div>

    </section>
    @push('scripts')
        <script>
            $('#accept-terms').change(function (e) {
                var $base = $('#can-buy');
                if ($base.length && e.target.checked) {
                    $base.removeAttr('disabled')
                } else {
                    $base.attr('disabled', true)
                }
            });
            $('#dp3').datepicker({
                dateFormat: "dd-mm-yyy"
            });
            $('#date').datepicker({
                dateFormat: "dd-mm-yyy"
            });

            $('#others').on('click', function () {
                $('                            <div class="form-group-lg row">\n' +
                    '                                <div class="col-xs-12 col-md-4">\n' +
                    '                                    <div class="new-f-group">\n' +
                    '                                        <div class="form-group clearfix">\n' +
                    '                                            <input type="text" name="others_name[]" class="effect-9 form-control"\n' +
                    '                                                   placeholder="{{trans('app.unit_name')}}">\n' +
                    '                                            <span class="focus-border"><i></i></span>\n' +
                    '                                        </div>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="col-xs-12 col-md-4 new-f-group">\n' +
                    '                                    <div class="form-group clearfix">\n' +
                    '                                        <input type="text" name="others_units[]" class="effect-9 form-control"\n' +
                    '                                               placeholder="{{trans('app.the_unit')}}">\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="col-xs-12 col-md-4">\n' +
                    '                                    <div class="new-f-group">\n' +
                    '                                        <div class="form-group clearfix">\n' +
                    '                                            <input type="text" name="others_quantity[]" class="effect-9 form-control"\n' +
                    '                                                   placeholder="{{trans('app.quantity')}}">\n' +
                    '                                            <span class="focus-border"><i></i></span>\n' +
                    '                                        </div>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                            </div>\n').insertBefore('#units')
            })
            $('#units').on('click', function () {
                $(' <div class="form-group-lg row">\n' +
                    '                                <div class="col-xs-12 col-md-4">\n' +
                    '                                    <div class="new-f-group">\n' +
                    '                                        <div class="form-group clearfix">\n' +
                    '                                            <input type="text" name="units_name[]" class="effect-9 form-control"\n' +
                    '                                                   placeholder="{{trans('app.unit_name')}}">\n' +
                    '                                            <span class="focus-border"><i></i></span>\n' +
                    '                                        </div>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="col-xs-12 col-md-4 new-f-group">\n' +
                    '                                    <div class="form-group clearfix">\n' +
                    '                                        <select name="units[]" type="text" class="effect-9 form-control">\n' +
                    '                                            <option value="{{null}}">{{trans('app.units.unit')}}</option>\n' +
                    '                                            @foreach($units as $unit)\n' +
                    '                                                <option value="{{$unit->id}}">{{$unit->name}}</option>\n' +
                    '                                            @endforeach\n' +
                    '                                        </select><span class="focus-border"><i></i></span>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                                <div class="col-xs-12 col-md-4">\n' +
                    '                                    <div class="new-f-group">\n' +
                    '                                        <div class="form-group clearfix">\n' +
                    '                                            <input type="text" name="units_quantity[]" class="effect-9 form-control"\n' +
                    '                                                   placeholder="{{trans('app.quantity')}}">\n' +
                    '                                            <span class="focus-border"><i></i></span>\n' +
                    '                                        </div>\n' +
                    '                                    </div>\n' +
                    '                                </div>\n' +
                    '                            </div>').insertBefore('#units')
            })
            $('#filess').on('click', function () {
                $("<div class=\"form-group-lg row\">\n" +
                    "                                        <div class=\"col-xs-12 col-md-8\">\n" +
                    "                                            <div class=\"new-f-group\">\n" +
                    "                                                <div class=\"form-group clearfix\">\n" +
                    "                                                    <input type=\"text\" name=\"files_names[]\" class=\"effect-9 form-control\"\n" +
                    "                                                           placeholder=\"{{trans('app.file_name')}}\">\n" +
                    "                                                    <span class=\"focus-border\"><i></i></span>\n" +
                    "                                                </div>\n" +
                    "                                            </div>\n" +
                    "                                        </div>\n" +
                    "                                        <div class=\"col-xs-12 col-md-4\">\n" +
                    "                                            <div class=\"new-f-group\">\n" +
                    "                                                <div class=\"form-group clearfix\">\n" +
                    "                                                    <input type=\"file\" name=\"files[]\"\n" +
                    "                                                           class=\"effect-9 form-control\"\n" +
                    "                                                           placeholder=\"{{trans('app.file')}}\">\n" +
                    "                                                </div>\n" +
                    "                                            </div>\n" +
                    "                                        </div>\n" +
                    "                                    </div>").insertBefore('#filess')
            })
        </script>
    @endpush
@endsection
