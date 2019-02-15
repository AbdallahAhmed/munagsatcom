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
                        {{trans('app.chances.the_chances')}}
                    </a></li>
                <li @if (\Route::current()->getName() == 'company.tenders') class="active" @endif><a
                            href="{{route('company.tenders', ['id' => $company_id])}}">
                        {{trans('app.name')}}
                    </a></li>
                <li @if (\Route::current()->getName() == 'company.employees') class="active" @endif><a
                            href="{{route('company.employees', ['id' => $company_id])}}">
                        {{trans('app.employees')}}
                    </a></li>
                <li @if (\Route::current()->getName() == 'company.centers') class="active" @endif><a
                            href="{{route('company.centers', ['id' => $company_id])}}">
                        {{trans('app.centers.centers')}}
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
                @if($role && $role[0]->role == 1)
                    <li @if (\Route::current()->getName() == 'chances.create') class="active" @endif><a
                                href="{{route('chances.create', ['id' => $company_id])}}">
                            {{trans('app.add_chance')}}
                        </a></li>
                    <li @if (\Route::current()->getName() == 'centers.create') class="active" @endif><a
                                href="{{route('centers.create', ['id' => $company_id])}}">
                            {{trans('app.add_center')}}</a></li>
                @endif
            </ul>
        </div>
    </div>
</div>
