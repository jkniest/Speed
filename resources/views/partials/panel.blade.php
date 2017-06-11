<div class="panel">

    <p class="panel-heading">

        @if(isset($icon))
            <span class="icon">
                <i class="fa fa-{{$icon}}"></i>
            </span>
        @endif

        {{ $title }}

    </p> {{-- p.panel-heading --}}

    <div class="panel-block">

        {{ $slot }}

    </div> {{-- div.panel-block --}}

</div> {{-- div.panel --}}