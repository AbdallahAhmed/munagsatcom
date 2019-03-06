@foreach($offers as $key=>$offers)
    <div class="row numoffer-item">
        <div class="col-md-9">
            <ul>
                <li>
                    <div class="row">
                        <div class="col-md-4">{{trans('app.company_personal')}}</div>
                        <div class="col-md-8">
                            @php
                                $user=\App\User::find($key);
                            @endphp
                            {{$user->first_name.' '.$user->last_name}}
                            @if($user->in_company)
                                / {{$user->company[0]->name}}
                            @endif
                        </div>
                    </div>
                </li>
                @foreach($offers as $offer)
                    <li><a href="{{@uploads_url(($media=\Dot\Media\Models\Media::find($offer->media_id))->path)}}"><i class="fa fa-paperclip"></i>
                        {{$media->title}}
                        </a></li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-3">
            <button type="submit"  class="uperc padding-md fbutcenter" style="top: 29px;">{{trans('app.approved')}}</button>
        </div>
    </div>

@endforeach