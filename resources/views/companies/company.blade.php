@extends('layouts.master')

@section('title',trans('app.register'))

@section('content')
    <section class="container">
        <div class="row">
            @include('companies.sidebar', ['company_id' => $company->id])
            <div class="col-xs-12 col-md-9">
                <div class="profile-box">

                    <div class="profile-item">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card-img"><img src="images/mr2.png" alt=""></div>
                            </div>
                            <div class="col-md-9">
                                <div class="details-item">
                                    <ul>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">اسم الشركة</div>
                                            <div class="one_xlarg"> شركة حمومة المحدوده</div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">رقم الهاتف</div>
                                            <div class="one_xlarg tel"> 000 0000 0000</div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">رقم الجوال</div>
                                            <div class="one_xlarg tel"> 000 0000 0000</div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="one_xsmall title">العنوان</div>
                                            <div class="one_xlarg"> شارع الملك عبد العزيز- الرياض</div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="text-left">
                                    <div class="form-group-lg">
                                        <button type="submit" form="" class="uperc padding-md fbutcenter"> تحديث
                                            بيانات
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="profile-item">
                        <div class="feildcont">
                            <form>
                                <h3>تغير كلمة المرور </h3>
                                <div class="form-group-lg row">
                                    <label class="col-xs-12 col-md-3"> كلمة المرور الحاليه </label>
                                    <div class="new-f-group col-xs-12 col-md-9">
                                        <div class="form-group">
                                            <span class="icony"><i class="fa fa-fw field-icon toggle-password fa-eye"
                                                                   toggle="#password-field3"></i></span>
                                            <input type="password" class="effect-9 form-control" id="password-field3"
                                                   placeholder="***">
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group-lg row">
                                    <label class="col-xs-12 col-md-3">كلمة المرور الجديده </label>
                                    <div class="new-f-group col-xs-12 col-md-9">
                                        <div class="form-group">
                                            <span class="icony"><i class="fa fa-fw field-icon toggle-password fa-eye"
                                                                   toggle="#password-field"></i></span>
                                            <input type="password" class="effect-9 form-control" id="password-field"
                                                   placeholder="***">
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group-lg row">
                                    <label class="col-xs-12 col-md-3">تاكيد كلمة المرور</label>
                                    <div class="new-f-group col-xs-12 col-md-9">
                                        <div class="form-group">
                                            <span class="icony"><i class="fa fa-fw field-icon toggle-password fa-eye"
                                                                   toggle="#password-field2"></i></span>
                                            <input type="password" class="effect-9 form-control" id="password-field2"
                                                   placeholder="***">
                                            <span class="focus-border"><i></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-left">
                                    <div class="form-group-lg">
                                        <button type="submit" form="" class="uperc padding-md fbutcenter"> تحديث كلمة
                                            المرور
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="profile-item profile-attch">
                        <h3>مرفقات اواراق الشركة</h3>

                        <ul>
                            <li><a href="">اسم الملف </a></li>
                            <li><a href="">اسم الملف </a></li>
                            <li><a href="">اسم الملف </a></li>
                        </ul>
                    </div>


                </div>
            </div>
        </div>
    </section>
@endsection