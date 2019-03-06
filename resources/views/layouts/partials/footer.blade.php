
<footer>
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-md-4 ">
                <ul>
                    <li><i class="fa fa-phone"></i> <a href="#">{{route('contact-us')}}</a></li>
                    <li><i class="fa fa-question"></i> <a href="{{route('page.show', ['slug' => 'الأسئلة-الشائعة'])}}">
                            {{trans('app.q_a')}}</a></li>
                    <li><i class="fa fa-mobile"></i> 920008769 </li>
                    <li class="mail"><i class="fa fa-envelope"></i><a href="mailto:info@munagasatcom.com"> info@munagasatcom.com </a></li>
                </ul>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="partner">
                    <ul>
                        <li><img src="/assets/images/partn-logo1.png" alt="مدينة الملك عبدالعزيز للعلوم والتقنية"></li>
                        <li><img src="/assets/images/partn-logo2.png" alt="بادر"></li>
                        <li><img src="/assets/images/partn-logo3.png"  alt="رؤية"></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 text-left">
                <div class="mtop">
                    <ul class="copyright-ul">
                        <li>
                            <a href="{{route('page.show', ['slug' => 'شروط الاستخدام'])}}">{{trans('app.terms')}}</a>
                        </li> -
                        <li><a href="{{route('page.show', ['slug' => 'سياسة-الخصوصية'])}}">{{trans('app.policy')}}</a></li>
                    </ul>
                </div>
                <ul class="footer-socail">
                    <li><a href=" https://www.facebook.com/munagasatcom"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="https://www.instagram.com/munagasatcom/"><i class="fa fa-instagram"></i></a></li>
                    <li><a href="https://twitter.com/munagasatcom"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="https://www.youtube.com/channel/UCRDuD-lLU3KaS1FehTqkxNg"><i class="fa fa-youtube"></i></a></li>
                    <li><a href="https://www.linkedin.com/company/munagasatcom"><i class="fa fa-linkedin"></i></a>
                    </li>
                </ul>
            </div>
            <div class="col-sm-12 col-md-12">
                <div class="copyright"><a href="javascript:void(0)"> {{trans('app.rights')}}©{{date('Y')}}  </a></div>

            </div>
        </div>
    </div>
</footer>