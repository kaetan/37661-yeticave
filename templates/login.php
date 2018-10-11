<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $val): ?>
            <li class="nav__item">
                <a href="all-lots.html"><?=$val['title']?></a>
            </li>
            <? endforeach ?>
        </ul>
    </nav>
    <form class="form container" action="login.php" method="post"> <!-- form--invalid -->
        <h2>Вход</h2>

        <!-- Ввод email -->
        <div class="form__item"> <!-- form__item--invalid -->
            <label for="email">E-mail*</label>
            <input id="email" type="text" name="email" placeholder="Введите e-mail" >
            <span class="form__error">Введите e-mail</span>
        </div>

        <!-- Ввод пароля -->
        <div class="form__item form__item--last">
            <label for="password">Пароль*</label>
            <input id="password" type="text" name="password" placeholder="Введите пароль" >
            <span class="form__error">Введите пароль</span>
        </div>

        <button type="submit" class="button">Войти</button>
    </form>
</main>