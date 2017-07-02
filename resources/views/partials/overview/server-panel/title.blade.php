<div class="level level-mobile">

    <div class="level-left">

        <div class="level-item">

            @icon(server)&nbsp;

        </div>

        <div class="level-item">
            @{{data.name}}&nbsp;
        </div>

        <div class="level-item">
            <small>
                (Last test: {{Carbon\Carbon::parse($server->last_test)->format('d.m.Y H:i')}})
            </small>
        </div>

    </div> {{-- div.level-left --}}

    <div class="level-right">

        <div class="level-item">

            <div @click="toggleSettings" class="is-clickable">
                @icon(cog)
            </div>

            <div @click="destroy" class="is-clickable">
                @icon(times)
            </div>

        </div> {{-- div.level-item --}}

    </div> {{-- div.level-right --}}

</div> {{-- div.level --}}