<div class="panel">

    <div class="panel-heading">

        @if(isset($icon))
            <span class="icon">
                <i class="fa fa-{{$icon}}"></i>
            </span>
        @endif

        {{ $title }}

    </div> {{-- div.panel-heading --}}

    <div class="panel-block">

        {{ $slot }}

    </div> {{-- div.panel-block --}}

    {{isset($beneath) ? $beneath : ''}}

</div> {{-- div.panel --}}