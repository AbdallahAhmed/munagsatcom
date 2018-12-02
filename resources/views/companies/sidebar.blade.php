<div class="col-xs-12 col-md-3">
    <div class="side-box">
        <div class="profile-side">
            <ul>
                <li class="active"><a class="" href="{{route('company.show', ['id' => $company_id])}}">بيانات الشركة</a></li>
                <li><a href="{{route('company.chances', ['id' => $company_id])}}">الفرص</a></li>
                <li><a href="{{route('company.tenders', ['id' => $company_id])}}">المناقصات</a></li>
                <li><a href="{{route('company.employees', ['id' => $company_id])}}">الموظفين</a></li>
                <li><a href="{{route('company.centers', ['id' => $company_id])}}">المراكز الخدمية</a></li>
                <li><a href="{{route('company.requests', ['id' => $company_id])}}">طلبات الاضافة</a></li>
                <li><a href="{{route('company.employer.search', ['id' => $company_id])}}">البحث عن موظف</a></li>
                <li><a href="{{route('company.add_delegate', ['id' => $company_id])}}"> اضافة مندوب </a></li>
                <li><a href="{{route('company.messages', ['id' => $company_id])}}">الرسائل</a></li>
            </ul>
        </div>
    </div>
</div>
