<div class="level">

    <div class="level-left">

        <div class="level-item">

            @icon(server)

            {{$server->name}}&nbsp;

            <small>
                (Last test: {{Carbon\Carbon::parse($server->last_test)->format('d.m.Y H:m')}})
            </small>

        </div> {{-- div.level-item --}}

    </div> {{-- div.level-left --}}

    <div class="level-right">

        <div class="level-item">

            @icon(cog)

            @icon(times)

        </div> {{-- div.level-item --}}

    </div> {{-- div.level-right --}}

</div> {{-- div.level --}}