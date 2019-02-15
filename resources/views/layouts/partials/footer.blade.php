<!--Begin:footer-->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="mail-text">{{trans('app.phone')}} : <span>920008769</span><br>
                    <span class="mail"><a href="mailto:info@munagasatcom.com">info@munagasatcom.com</a></span>
                </div>
                <div>
                    <ul class="footer-link">
                        <li><a href=" https://www.facebook.com/munagasatcom"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="https://www.instagram.com/munagasatcom/"><i class="fa fa-instagram"></i></a></li>
                        <li><a href="https://twitter.com/munagasatcom"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="https://www.youtube.com/channel/UCRDuD-lLU3KaS1FehTqkxNg"><i
                                        class="fa fa-youtube"></i></a></li>
                        <li><a href="https://www.linkedin.com/company/munagasatcom"><i class="fa fa-linkedin"></i></a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-4 col-md-push-4">
                <div class="partner">
                    <ul>
                        <li><img src="{{asset('/assets')}}/images/r2ia.jpeg"
                                 alt="مدينة الملك عبدالعزيز للعلوم والتقنية"></li>
                        <li><img src="{{asset('/assets')}}/images/badr.jpeg" alt="بادر"></li>
                        <li><img src="{{asset('/assets')}}/images/3.jpeg" alt="رؤية"></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-4 col-md-pull-4" style="text-align: center;">
                <ul class="copyright-ul">
                    <li>
                        <a href="{{route('page.show', ['slug' => 'شروط الاستخدام'])}}">{{trans('app.terms')}}</a>
                    </li>
                    <li><a href="{{route('page.show', ['slug' => 'سياسة-الخصوصية'])}}">{{trans('app.policy')}}</a></li>
                    <li><a href="{{route('page.show', ['slug' => 'الأسئلة-الشائعة'])}}">{{trans('app.q_a')}}</a></li>
                </ul>
                <div class="copyright"><a href="javascript:void(0)"> {{trans('app.rights')}}©{{date('Y')}}  </a></div>
            </div>
        </div>
    </div>
</footer>
<!--End:footer-->