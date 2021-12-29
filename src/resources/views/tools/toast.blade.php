@if(session()->has('toast'))
    <div aria-live="polite" aria-atomic="true" style="position: relative; z-index: 10">
        <!-- Position it -->
        <div style="position: absolute; top: 0; right: 25px;">

            <!-- Then put toasts within -->
            @foreach(Session::get('toast') as $message)
                <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="10000">
                    <div class="toast-header">
                        <strong class="mr-auto">{{$message->type}}</strong>
                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="toast-body">
                        {{$message->description}}
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endif
