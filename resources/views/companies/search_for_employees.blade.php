@extends('layouts.master')

@section('title',$company->name)

@section('content')
    <section class="container">
        <div class="row">
            @include('companies.sidebar', ['company_id' => $company->id])
            <div class="col-xs-12 col-md-9">
                @if(count($employees)>0)
                <div class="profile-box">
                    <div class="profile-item">
                        <form action="{{route('company.employees.search', ['id' => $company->id])}}">
                            <div class="profile-search">
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
                                    <button type="submit"  class="uperc padding-md fbutcenter"> {{trans('app.search')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="profile-item">
                        <div class="unit-table">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col"> {{trans('app.select')}}</th>
                                    <th scope="col"> {{trans('app.active')}}</th>
                                    <th scope="col">{{trans('app.employee_name')}}</th>
                                    <th scope="col">{{trans('app.add_chance')}}</th>
                                    <th scope="col">{{trans('app.view_only')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($employees as $employer)
                                    <tr id="{{$employer->id}}">
                                        <td>
                                            <div class="checkbox"><input type="checkbox" data-id="{{$employer->id}}"
                                                                         name="selected"></div>
                                        </td>
                                        <td>
                                            <div class="checkbox"><input type="checkbox" value="22"
                                                                         name="status{{$employer->id}}"></div>
                                        </td>
                                        <td>{{$employer->name}}</td>
                                        <td>
                                            <div class="radio"><input type="radio" value="1"
                                                                      name="role{{$employer->id}}"></div>
                                        </td>
                                        <td>
                                            <div class="radio"><input type="radio" value="0"
                                                                      name="role{{$employer->id}}" checked></div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="text-center">
                        @if(count($employees)>0)
                            {{$employees->appends(Request::all())->render()}}
                        @endif
                    </div>

                    <div class="form-group-lg text-center">
                        <button type="submit" name="add" class="uperc padding-md fbutcenter"> {{trans('app.add')}}</button>
                        <button type="submit" name="send" class="uperc padding-md fbutcenter"> {{trans('app.send_request')}}</button>
                    </div>

                </div>
                    @else
                    <div class="text-center">
                        <p>{{trans('app.no_employees_found')}}</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
    @push('scripts')
        <script>
            $(function () {
                $('[name="add"]').on('click', function (e) {
                    e.preventDefault();
                    var selected = [];
                    var employees = [];
                    $("input:checkbox[name=selected]:checked").each(function () {
                        selected.push($(this).data('id'));
                    });
                    for (i = 0; i < selected.length; i++) {
                        id = selected[i];
                        role = ($("input:radio[name=role" + id + "]:checked").val());
                        status = $("[name='status" + id + "']").prop('checked') === true ? 1 : 0;
                        employees.push({
                            'company_id': "{{$company->id}}",
                            'employee_id': id,
                            'role': role,
                            'status': status,
                            accepted: '1'
                        })
                    }
                    if (selected.length > 0) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type: "post",
                            url: "{{route('company.employees.add', ['id' => $company->id])}}",
                            data: {'employees': employees},
                            success: function () {
                                location.reload();
                            }
                        });
                    }
                })
                $('[name="send"]').on('click', function (e) {
                    e.preventDefault();
                    var selected = [];
                    var employees = [];
                    $("input:checkbox[name=selected]:checked").each(function () {
                        selected.push($(this).data('id'));
                    });
                    for (i = 0; i < selected.length; i++) {
                        id = selected[i];
                        role = ($("input:radio[name=role" + id + "]:checked").val());
                        status = $("[name='status" + id + "']").prop('checked') === true ? 1 : 0;
                        employees.push({
                            'company_id': "{{$company->id}}",
                            'employee_id': id,
                            'role': role,
                            'status': status,
                            accepted: '0'
                        })
                    }
                    if (selected.length > 0) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type: "post",
                            url: "{{route('company.employees.send', ['id' => $company->id])}}",
                            data: {'employees': employees},
                            success: function () {
                                location.reload();
                            }
                        });
                    }
                })
            })
        </script>
    @endpush
@endsection