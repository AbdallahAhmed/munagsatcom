<div class="col-xs-12 col-md-3">
    <div class="side-box">
        <div class="profile-side">
            <ul>
                <li @if (\Route::current()->getName() == 'user.show') class="active" @endif><a class="" href="{{route('user.show')}}">بيانات عامة </a></li>
                <li @if (\Route::current()->getName() == 'user.requests') class="active" @endif><a href="{{route('user.requests')}}">طلبات الاضافه</a></li>
                <li><a href="user-profile3.html">بحث عن الشركة</a></li>
                <li><a href="user-profile4.html">الرسائل</a></li>
                <li><a href="user-profile5.html">المراكز الخدمية التى تم اضافتها </a></li>
                <li><a href="user-profile6.html">النقاط المستخدمة </a></li>
            </ul>
        </div>
    </div>
</div>