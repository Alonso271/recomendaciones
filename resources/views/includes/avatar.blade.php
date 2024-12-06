@if(Auth::user()->image)
    <div class='container-avatar'>
        <img src='{{  Auth::user()->image }}' class='avatar'>
    </div>
@endif

