<div class="col-xs-12 col-md-3">
    <div class="side-box">
        <div class="profile-side">
            <ul>
                <li @if (\Route::current()->getName() == 'company.show') class="active" @endif><a class="" href="{{route('company.show', ['id' => $company_id])}}">
                        {{trans('app.company_details')}}
                    </a></li>
                <li @if (\Route::current()->getName() == 'company.chances') class="active" @endif><a href="{{route('company.chances', ['id' => $company_id])}}">
                        {{trans('app.chances.the_chances')}}
                    </a></li>
                <li @if (\Route::current()->getName() == 'company.tenders') class="active" @endif><a href="{{route('company.tenders', ['id' => $company_id])}}">
                        {{trans('app.name')}}
                    </a></li>
                <li @if (\Route::current()->getName() == 'company.employees') class="active" @endif><a href="{{route('company.employees', ['id' => $company_id])}}">
                        {{trans('app.employees')}}
                    </a></li>
                <li @if (\Route::current()->getName() == 'company.centers') class="active" @endif><a href="{{route('company.centers', ['id' => $company_id])}}">
                        {{trans('app.centers.centers')}}
                    </a></li>
                <li @if (\Route::current()->getName() == 'company.requests') class="active" @endif><a href="{{route('company.requests', ['id' => $company_id])}}">
                        {{trans('app.requests')}}
                    </a></li>
                <li @if (\Route::current()->getName() == 'company.employer.search') class="active" @endif><a href="{{route('company.employees.search', ['id' => $company_id])}}">
                        {{trans('app.search_employee')}}
                    </a></li>
                <li @if (\Route::current()->getName() == 'company.add_delegate') class="active" @endif><a href="{{route('company.add_delegate', ['id' => $company_id])}}">
                        {{trans('app.add_delegate')}}
                    </a></li>
                <li @if (\Route::current()->getName() == 'company.messages') class="active" @endif><a href="{{route('company.messages', ['id' => $company_id])}}">
                        {{trans('app.messages')}}
                    </a></li>
            </ul>
        </div>
    </div>
</div>
