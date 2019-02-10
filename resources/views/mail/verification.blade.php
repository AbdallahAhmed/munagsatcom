Hi  {{$user->first_name}} ,<br>Your verification  code is  <b>{{$user->code}}</b> or You verification is link <a
        href="{{route('user.verify.link',['lang'=>app()->getLocale(),'key'=>urlencode(\Crypt::encryptString($user->email)),'code'=>$user->code])}}">Here</a> Link<br>BR ,
<br>Monaasat