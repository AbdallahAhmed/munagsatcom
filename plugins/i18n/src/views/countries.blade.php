<li class="dropdown">
    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#" aria-expanded="false">
        fff
    </a>
    <ul class="dropdown-menu dropdown-alerts dropdown-locales">
        <div class="aro"></div>

        @foreach (\Dot\I18n\Models\Place::where("parent", 0)->get() as $country)

                <li>
                    <a href="">
                        {{ $country->name }}
                    </a>
                </li>

        @endforeach

    </ul>
</li>

