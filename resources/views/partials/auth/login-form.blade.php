<form action="{{route('login')}}" method="POST">

    {{csrf_field()}}

    @component('partials.input', ['name' => 'name', 'icon' => 'user'])
        Username
    @endcomponent

    @component('partials.input', ['name' => 'password', 'icon' => 'lock', 'type' => 'password'])
        Password
    @endcomponent

    <div class="field">

        <p class="control">

            <button class="button is-success">
                Login
            </button>

        </p> {{-- p.control --}}

    </div> {{-- div.field --}}

    @if(count($errors))
        <div class="message is-danger">
            <div class="message-body">
                <b>Whoops!</b><br>
                {{$errors->first()}}

            </div> {{-- div.message-box --}}
        </div> {{-- div.message --}}
    @endif

</form> {{-- form[action=login] --}}

