<div class="container p1 w100" style="height: 200px;">

    <nav class="level is-mobile" style="height: 100%;">

        <div class="level-item has-text-centered">

            <div>

                <p class="heading">

                    @iconSmall(caret-down)

                    Download

                    @iconSmall(caret-down)

                </p> {{-- p.heading --}}

                <p class="title">{{number_format($download)}}</p>

            </div> {{-- div --}}

        </div> {{-- div.level-item --}}

        <div class="level-item has-text-centered">

            <div>

                <p class="heading">

                    @iconSmall(caret-up)

                    Upload

                    @iconSmall(caret-up)

                </p>

                <p class="title">{{number_format($upload)}}</p>

            </div> {{-- div --}}

        </div> {{-- div.level-item --}}

    </nav> {{-- nav.level --}}

</div> {{-- div.container.p1 --}}
