<div class="w100">

    @component('partials.components.panel', ['title' => 'Settings', 'icon' => 'cog'])

        <div class="container p1 w100" style="min-height: 200px;">

            <div class="columns">

                <div class="column is-half">

                    @component('partials.components.input', [
                        'name' => 'name',
                        'icon' => 'address-card',
                        'showLabel' => true,
                        'value' => $server->name,
                        'id' => $server->id . '_name'
                    ])
                        Name
                    @endcomponent

                    <button class="button is-success" @click="save" id="{{$server->id}}_save">
                        @iconSmall(save)&nbsp;Save
                    </button>


                    <button class="button" @click="cancel">
                        @iconSmall(times)&nbsp;
                                         Cancel
                    </button>

                </div>

                <div class="column is-half">

                    @component('partials.components.input', [
                        'name' => 'apikey',
                        'icon' => 'user',
                        'showLabel' => true,
                        'value' => $server->token,
                        'disabled' => true
                    ])
                        API Schlüssel
                    @endcomponent

                </div>

            </div>

        </div> {{-- div.container.p1 --}}

    @endcomponent

</div> {{-- div.w100 --}}