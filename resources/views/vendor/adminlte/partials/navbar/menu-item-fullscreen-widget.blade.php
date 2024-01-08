<li class="nav-item">
    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
    </a>
</li>
<!--Comprobamos si el status esta a true y existe más de un lenguaje-->
@if (config('locale.status') && count(config('locale.languages')) > 1)
<li class="nav-item">
    @foreach (array_keys(config('locale.languages')) as $lang)
    @if ($lang != App::getLocale())
    <a class="nav-link" href="{{ route('web.dashboard.lang.swap', $lang) }}">
        {{ $lang }}
    </a>
    @endif
    @endforeach
</li>
@endif
