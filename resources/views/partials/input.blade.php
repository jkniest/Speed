<div class="field is-fullwidth">

    <p class="control has-icons-left">

        @php
            $type = $type ?? 'text';
        @endphp

        <input type="{{$type}}"
               class="input"
               required name="{{$name}}"
               placeholder="{{$slot}}"
               value="{{$type != 'password' ? old($name) : ''}}"
        >

        <span class="icon is-small is-left">
            <i class="fa fa-{{$icon}}"></i>
        </span>

    </p> {{-- p.control --}}

</div> {{-- div.field --}}