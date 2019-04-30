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
                    <li><a href="{{@uploads_url(($media=\Dot\Media\Models\Media::find($offer->media_id))->path)}}"><i
                                    class="fa fa-paperclip"></i>
                            {{$media->title}}
                        </a></li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-3">
            @if($is_approved)
                @if($key == $is_approved)
                    <h3>{{trans('app.done_approved')}}</h3>
                @endif
            @else
                <button type="submit" data-uid="{{$key}}" data-cid="{{$offer->chance_id}}"
                        class="uperc approve padding-md fbutcenter"
                        style="top: 29px;">{{trans('app.approved')}}</button>
            @endif

        </div>
    </div>
@endforeach
@if(!$is_approved)
    <div class="modal-footer">
        <button type="button" id="save" class="btn btn-primary">{{trans('app.save')}}</button>
    </div>
@endif
<script>
    var cid = "";
    var uid = "";
    $('.approve').on('click', function () {
        cid = $(this).data('cid');
        uid = $(this).data('uid');
        $('.approve').html('{{trans('app.approved')}}')
        $(this).html('{{trans('app.press_save')}}')
    })
    $('#save').on('click', function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "post",
            url: "{{route('chances.offers.approve', ['company_id' => $company_id])}}",
            data: {chance_id: cid, user_id: uid},
            success: function (data) {
                $modal = $('#offers')
                $modal.modal('hide')
            },
            error: function () {
                alert("Internal Server Error")
            }
        })
    })
</script>