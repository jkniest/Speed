<form action="{{route('login')}}" method="POST">

    @component('partials.input', ['name' => 'name', 'icon' => 'user'])
        Username
    @endcomponent

    @component('partials.input', ['name' => 'password', 'icon' => 'lock'])
        Password
    @endcomponent

    <div class="field">

        <p class="control">

            <button class="button is-success">
                Login
            </button>

        </p> {{-- p.control --}}

    </div> {{-- div.field --}}

</form> {{-- form[action=login] --}}

