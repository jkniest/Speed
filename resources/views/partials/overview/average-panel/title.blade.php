<div class="level">

    <div class="level-left">

        <div class="level-item">

            Average of all servers

        </div>

    </div>

    <div class="level-right">

        <div class="level-item">

            <form action="{{route('logout')}}" method="post" id="logout-form">
                {{csrf_field()}}
            </form>

            <a href="#" onclick="$('#logout-form').submit(); return false;">
                [Logout]
            </a>

        </div>

    </div>

</div>