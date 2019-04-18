@if (count($files))
    @foreach ($files as $row)
        <div class="dz-preview dz-image-preview" media-id="{{ $row->id }}">
            @if(!config('media.s3.status'))
                @php
                    $isExist=file_exists(uploads_path($row->path)) || !empty($row->provider);
                @endphp
                <span class="badge top-left {{$isExist?'badge-success':'badge-danger'}}" style="{{$isExist?'background: green;':''}}"><i
                        class="fa  {{$isExist?'fa-check-circle ':'fa-times-circle-o'}}"></i></span>

            @endif
            <input type="hidden" name="media_url" value="{{ $row->url }}"/>
            <input type="hidden" name="media_thumbnail" value="{{ $row->thumbnail }}"/>
            <input type="hidden" name="media_path" value="{{ $row->path }}"/>
            <input type="hidden" name="media_type" value="{{ $row->type }}"/>
            <input type="hidden" name="media_provider" value="{{ $row->provider }}"/>
            <input type="hidden" name="media_provider_id" value="{{ $row->provider_id }}"/>
            <input type="hidden" name="media_duration" value="{{ $row->duration }}"/>
            <input type="hidden" name="media_id" value="{{ $row->id }}"/>
            <input type="hidden" name="media_title" value="{{ $row->title }}"/>
            <input type="hidden" name="media_description" value="{{ $row->description }}"/>
            <input type="hidden" name="media_created_date" value="{{ $row->created_at }}"/>

            <i class="fa fa-check right-mark"></i>

            <div class="dz-details">
                <div class="dz-thumbnail-wrapper">

                    <div class="dz-thumbnail">

                        @if (in_array($row->type, array("video", "audio")))
                            <i class="vid fa fa-play-circle"></i>
                        @endif

                        <img src="{{ $row->thumbnail }}">

                    </div>
                </div>
            </div>

        </div>
    @endforeach
@elseif(count($files) == 0 and $page == 1)
    <div class="no-media text-center">
        <i class="fa fa-file"></i>
    </div>
@endif
<style>
    .top-left{
        position: absolute;
        left: 1px;
    }
</style>
