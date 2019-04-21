<div class="col-xs-12 col-md-3">
    <div class="side-box">
        <div class="profile-side">
            <ul>
                <li @if (\Route::current()->getName() == 'company.show') class="active" @endif><a
                            href="{{route('company.show', ['slug' => $company->slug])}}">
                        {{trans('app.company_details')}}
                    </a></li>
                <li @if (\Route::current()->getName() == 'company.chances') class="active" @endif><a
                            href="{{route('company.chances', ['id' => $company_id])}}">
                        {{trans('app.chances.my_chances')}}
                    </a></li>
                <li @if (\Route::current()->getName() == 'company.tenders') class="active" @endif><a
                            href="{{route('company.tenders', ['id' => $company_id])}}">
                        {{trans('app.my_tender')}}
                    </a></li>
                @if(fauth()->user()->is_owner)
                    <li @if (\Route::current()->getName() == 'company.employees' ||  \Route::current()->getName()=='company.employees.add') class="active" @endif>
                        <a
                                href="{{route('company.employees', ['id' => $company_id])}}">
                            {{trans('app.employees')}}
                        </a></li>
                @endif
                <li @if (\Route::current()->getName() == 'company.centers') class="active" @endif><a
                            href="{{route('company.centers', ['id' => $company_id])}}">
                        {{trans('app.mycenters')}}
                    </a></li>

                <?php
                use App\Models\Companies_empolyees;
                $role = [];
                if (fauth()->check()) {
                    $role = Companies_empolyees::where([
                        ['employee_id', fauth()->user()->id],
                        ['accepted', 1],
                        ['status', 1]
                    ])->get();
                }
                ?>
                @if($role && $role[0]->role == 1&&fauth()->user()->can_buy)
                    <li @if (\Route::current()->getName() == 'chances.create') class="active " @endif>
                        <a href="{{route('chances.create',['id'=>$company_id])}}">
                            {{trans('app.add_chance')}}
                        </a></li>

                    <li @if (\Route::current()->getName() == 'centers.create') class="active" @endif><a
                                href="{{route('centers.create',['id'=>$company_id])}}">
                            {{trans('app.add_center')}}</a></li>
                @endif
            </ul>
        </div>
    </div>
</div>
