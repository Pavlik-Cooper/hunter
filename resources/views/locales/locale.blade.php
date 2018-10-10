
<li class="nav-item dropdown">
    <a id="navbarDropdown" class="nav-link text-light dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>

        {{ \App\Http\Middleware\LocaleMiddleware::getLocale() === null ? 'en' : \App\Http\Middleware\LocaleMiddleware::getLocale()  }} <span class="caret"></span>
    </a>

    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

        <a class="dropdown-item" href="<?= route('setlocale', ['lang' => 'en']) ?>">English</a>
        <a class="dropdown-item" href="<?= route('setlocale', ['lang' => 'ru']) ?>">Русский</a>
        <a class="dropdown-item" href="<?= route('setlocale', ['lang' => 'uk']) ?>">Українська</a>
    </div>
</li>