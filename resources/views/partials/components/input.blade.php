<div class="field is-fullwidth">

    @if(isset($showLabel))
        <label class="label" for="#form-{{$name}}">
            {{$slot}}
        </label>
    @endif

    <p class="control has-icons-left">

        @php
            $type = $type ?? 'text';
        @endphp

        <input type="{{$type}}"
               class="input"
               required name="{{$name}}"
               placeholder="{{$slot}}"
               {{isset($id) ? 'id='.$id.'' : ''}}
               {{isset($disabled) && $disabled ? 'disabled' : ''}}
               @if(isset($value))
               value="{{$value}}"
               @else
               value="{{$type != 'password' ? old($name) : ''}}"
            @endif
        >

        <span class="icon is-small is-left">
            <i class="fa fa-{{$icon}}"></i>
        </span>

    </p> {{-- p.control --}}

</div> {{-- div.field --}}