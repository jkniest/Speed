<div class="container p1 w100" style="height: 200px;">

    <nav class="level is-mobile" style="height: 100%;">

        <div class="level-item has-text-centered">

            <div>

                <p class="heading">

                    <span class="icon is-small">
                        <i class="fa fa-caret-down"></i>
                    </span> {{-- span.icon --}}

                    Download

                    <span class="icon is-small">
                        <i class="fa fa-caret-down"></i>
                    </span> {{-- span.icon --}}

                </p> {{-- p.heading --}}

                <p class="title">{{number_format($download)}}</p>

            </div> {{-- div --}}

        </div> {{-- div.level-item --}}

        <div class="level-item has-text-centered">

            <div>

                <p class="heading">

                    <span class="icon is-small">
                        <i class="fa fa-caret-up"></i>
                    </span> {{-- span.icon --}}

                    Upload

                    <span class="icon is-small">
                        <i class="fa fa-caret-up"></i>
                    </span> {{-- span.icon --}}

                </p>

                <p class="title">{{number_format($upload)}}</p>

            </div> {{-- div --}}

        </div> {{-- div.level-item --}}

        {{ $slot }}

    </nav> {{-- nav.level --}}

</div> {{-- div.container.p1 --}}
