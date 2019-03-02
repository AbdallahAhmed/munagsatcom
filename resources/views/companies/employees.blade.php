@extends('layouts.master')

@section('title',trans('app.employees'))
@section('content')
    <section class="container">
        <div class="row">
            @include('companies.sidebar', ['company_id' => $company->id])
            <div class="col-xs-12 col-md-9">
                <div class="profile-box">
                    @if(!fauth()->user()->is_owner)
                    <div class="alert alert-info">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{trans('app.only_admin_can_edit')}}
                    </div>
                    @endif

                    <div class="profile-item">

                        <div class="profile-search">

                            <form method="get" action="{{route('company.employees', ['id' => $company->id])}}">
                                <h3>{{trans('app.search_employee')}}</h3>

                                <div class="form-group row">
                                    <label class="col-xs-12 col-md-3">{{trans('app.employee_name')}}</label>
                                    <div class="col-xs-12 col-md-7">
                                        <div class="icon-addon">
                                            @if($name)
                                                <input type="text" name="name" value="{{$name}}"
                                                       placeholder="{{trans('app.enter_employee_name')}}...."
                                                       class="form-control">
                                            @else
                                                <input name="name" type="text"
                                                       placeholder="{{trans('app.enter_employee_name')}}...."
                                                       class="form-control">
                                            @endif
                                            <div class="searh-icn"><i class="fa fa-search"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xs-12 col-md-3">{{trans('app.fields.email')}} </label>
                                    <div class="col-xs-12 col-md-7">
                                        <div class="icon-addon">
                                            @if($email)
                                                <input name="email" type="text" value="{{$email}}"
                                                       placeholder="{{trans('app.enter_employee_email')}}...."
                                                       class="form-control">
                                            @else
                                                <input name="email" type="text"
                                                       placeholder="{{trans('app.enter_employee_email')}}...."
                                                       class="form-control">
                                            @endif
                                            <div class="searh-icn"><i class="fa fa-search"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group-lg text-center">

                                    <button type="submit"
                                            class="uperc padding-md fbutcenter">{{trans('app.search')}}</button>

                                </div>
                                <div class="form-group-lg text-left">
                                    <a href="{{route('company.employees.add',['id'=>$company->id])}}"
                                       class=" btn btn-primary uperc padding-md fbutcenter">{{trans('app.add_employee')}}</a>
                                </div>
                            </form>
                        </div>


                    </div>

                    <div class="profile-item">
                        <div class="unit-table">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col"> {{trans('app.active')}}</th>
                                    <th scope="col">{{trans('app.employee_name')}}</th>
                                    <th scope="col">{{trans('app.can_pay')}}</th>
                                    <th scope="col">{{trans('app.view_only')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(fauth()->user()->is_owner)
                                    @foreach($employees as $employer)
                                        <tr id="{{$employer->user->id}}">
                                            <td>
                                                <div class="checkbox">
                                                    <input type="checkbox" style="opacity: 0;"
                                                           id="{{$employer->employee_id}}"
                                                           {{$employer->user->id==fauth()->id()?'disabled="true"':''}}  name="selected">
                                                    <input type="checkbox"
                                                           {{$employer->user->id==fauth()->id()?'disabled="true"':''}} {{$employer->id==fauth()->id()?'disabled':''}}  name="status{{$employer->employee_id}}"
                                                           @if($employer->status) checked @endif>
                                                </div>
                                            </td>
                                            <td>{{$employer->user->name}}</td>
                                            <td>
                                                <div class="radio">
                                                    <input type="radio"
                                                           {{$employer->user->id==fauth()->id()?'disabled':''}} value="1"
                                                           name="role{{$employer->employee_id}}"
                                                           @if($employer->role) checked @endif>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="radio">
                                                    <input type="radio"
                                                           {{$employer->user->id==fauth()->id()?'disabled':''}}  value="0"
                                                           name="role{{$employer->employee_id}}"
                                                           @if(!$employer->role) checked @endif>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    @foreach($employees as $employer)
                                        <tr id="{{$employer->user->id}}">
                                            <td>
                                                <div class="checkbox">
                                                    <input type="checkbox" style="opacity: 0;"
                                                           id="{{$employer->employee_id}}" disabled="true"
                                                           name="selected">
                                                    <input type="checkbox" disabled="true"
                                                           name="status{{$employer->employee_id}}"
                                                           @if($employer->status) checked @endif>
                                                </div>
                                            </td>
                                            <td>{{$employer->user->name}}</td>
                                            <td>
                                                <div class="radio">
                                                    <input type="radio"
                                                           disabled="true" value="1"
                                                           name="role{{$employer->employee_id}}"
                                                           @if($employer->role) checked @endif>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="radio">
                                                    <input type="radio"
                                                           disabled value="0"
                                                           name="role{{$employer->employee_id}}"
                                                           @if(!$employer->role) checked @endif>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="text-center" style="display: none;" id="success">
                        <p class="alert-success">{{trans('app.saved_successfully')}}</p>
                    </div>
                    <div class="text-center">
                        {{$employees->appends(Request::all())->render()}}
                    </div>

                    <div class="form-group-lg text-center">
                        <button type="submit" id="save"
                                class="uperc padding-md fbutcenter"> {{trans('app.save')}}</button>
                    </div>

                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            $(function () {
                $('#save').on('click', function (e) {
                    e.preventDefault();
                    var selected = [];
                    var employees = [];
                    $("input:checkbox[name=selected]").each(function () {
                        selected.push($(this).attr('id'));
                    });
                    for (i = 0; i < selected.length; i++) {
                        id = selected[i];

                        role = $("[name=role" + id + "]:checked").val();
                        status = $("[name='status" + id + "']").prop('checked') ? 1 : 0;
                        console.log(status);
                        employees.push({
                            'company_id': "{{$company->id}}",
                            'employee_id': id,
                            'role': role,
                            'status': status,
                            accepted: '1'
                        });
                    }
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "post",
                        url: "{{route('company.employees', ['id' => $company->id])}}",
                        data: {'employees': employees},
                        success: function () {
                            $('#success').show();
                            setTimeout(function () {
                                $('#success').hide();
                            }, 3000)
                        }
                    });
                })
            })
        </script>
    @endpush
@endsection