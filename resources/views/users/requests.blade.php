@extends('layouts.master')

@section('title')

@section('content')
    <section class="container">
        <div class="row">
            @include('users.sidebar')
            <div class="col-xs-12 col-md-9">
                @if($requests->total())
                <div class="profile-box">
                    <form name="form" id="form" method="post" action="{{route('user.requests.update')}}">
                        {{csrf_field()}}
                        <div class="profile-item">
                            <div class="unit-table">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col"> اسم الشركة</th>
                                        <th scope="col"> البريد الالكترونى</th>
                                        <th scope="col"> القبول</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($requests as $company)
                                        <tr>
                                            <td>{{$company->name}}</td>
                                            <td>{{$company->email}}</td>
                                            <td>
                                                <div class="radio"><input type="radio" value="{{$company->id}}"
                                                                          name="accepted"></div>
                                            </td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div>
                            <p>بقبولك لأي شركة سوف يتم حذفك من شركتك الحالية و الانضمام الى الشركة المختارة </p>
                        </div>
                        <div class="text-center">
                            {{$requests->appends(Request::all())->render()}}
                            <div class="modal fade" id="myModal" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title"> تاكيد القبول</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>هل انت متأكد لقبول الشركة و الخروج من الشركة الحالية اذا كنت مشترك؟</p>
                                        </div>
                                        <div class="modal-footer text-center">
                                            <button type="submit" form="form" class="uperc padding-md fbutcenter">نعم
                                            </button>
                                            <button type="" class="uperc padding-md fbutcenter1"
                                                    data-dismiss="modal">
                                                لا
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="form-group-lg text-center">
                            <button type="submit" name="save" class="uperc padding-md fbutcenter"> حفظ</button>
                        </div>
                    </form>
                </div>
                    @else
                    <div class="text-center">
                        <p> لا يوجد طلبات اضافة</p>
                    </div>
                    @endif
            </div>
        </div>
    </section>
    @push('scripts')
        <script>
            $('[name="save"]').on('click', function (e) {
                e.preventDefault();
                if ($('[name="accepted"]').prop('checked'))
                    $("#myModal").modal('show');

            })
        </script>
    @endpush
@endsection