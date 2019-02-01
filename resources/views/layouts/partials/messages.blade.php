@if((session()->has('messages')))
    <div class="alert alert-{{session()->has('status')?session('status'):'danger'}}" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <ul class="message-alert">
            @foreach(session('messages') as $message)
                <li>{{$message}}</li>
            @endforeach
        </ul>
    </div>
@endif