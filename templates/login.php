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
    <?php $classname = count($errors) ? "form--invalid" : "" ?>
    <form class="form container <?=$classname;?>" action="login.php" method="post"> <!-- form--invalid -->
        <h2>Вход</h2>

        <!-- Ввод email -->
        <?php $classname = isset($errors['email']) ? "form__item--invalid" : "";
        $email = $_POST['email'] ?? ''; ?>
        <div class="form__item <?=$classname;?>"> <!-- form__item--invalid -->
            <label for="email">E-mail*</label>
            <input id="email" type="text" name="email" value = "<?=htmlspecialchars($email);?>" placeholder="Введите e-mail" required>
            <span class="form__error"><?=$errors['email']; ?></span>
        </div>

        <!-- Ввод пароля -->
        <?php $classname = isset($errors['password']) ? "form__item--invalid" : ""; ?>
        <div class="form__item form__item--last <?=$classname;?>">
            <label for="password">Пароль*</label>
            <input id="password" type="password" name="password" placeholder="Введите пароль" required>
            <span class="form__error"><?=$errors['password']; ?></span>
        </div>

        <button type="submit" class="button">Войти</button>
    </form>
</main>