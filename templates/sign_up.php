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
    <?php $classname = count($errors) ? "form--invalid" : "";?>
    <form class="form container <?=$classname;?>" action="sign_up.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
        <h2>Регистрация нового аккаунта</h2>

        <!-- Ввод email -->
        <?php $classname = isset($errors['email']) ? "form__item--invalid" : "";
        $email = $_POST['signup']['email'] ?? ''; ?>
        <div class="form__item <?=$classname;?>"> <!-- form__item--invalid -->
            <label for="email">E-mail*</label>
            <input id="email" type="text" name="signup[email]" placeholder="Введите e-mail" value="<?=htmlspecialchars($email);?>" required>
            <span class="form__error"><?=$errors['email'];?></span>
        </div>

        <!-- Ввод пароля -->
        <?php $classname = isset($errors['password']) ? "form__item--invalid" : "";?>
        <div class="form__item <?=$classname;?>">
            <label for="password">Пароль*</label>
            <input id="password" type="password" name="signup[password]" placeholder="Введите пароль" required>
            <span class="form__error">Введите пароль</span>
        </div>

        <!-- Ввод имени пользователя -->
        <?php $classname = isset($errors['username']) ? "form__item--invalid" : "";
        $username = $_POST['signup']['username'] ?? ''; ?>
        <div class="form__item <?=$classname;?>">
            <label for="name">Имя*</label>
            <input id="name" type="text" name="signup[username]" placeholder="Введите имя" value="<?=htmlspecialchars($username);?>" required>
            <span class="form__error">Введите имя</span>
        </div>

        <!-- Ввод контактных данных -->
        <?php $classname = isset($errors['contacts']) ? "form__item--invalid" : "";
        $contacts = $_POST['signup']['contacts'] ?? ''; ?>
        <div class="form__item <?=$classname;?>">
            <label for="message">Контактные данные*</label>
            <textarea id="message" name="signup[contacts]" placeholder="Напишите как с вами связаться" required><?=htmlspecialchars($contacts);?></textarea>
            <span class="form__error">Напишите как с вами связаться</span>
        </div>

        <!-- Загрузка аватарки пользователя -->
        <?php $classname = isset($errors['userpic']) ? "form__item--invalid" : ""; ?>
        <div class="form__item form__item--file form__item--last <?=$classname;?>">
            <label>Аватар</label>
            <div class="preview">
                <button class="preview__remove" type="button">x</button>
                <div class="preview__img">
                    <img src="img/avatar.jpg" width="113" height="113" alt="Ваш аватар">
                </div>
            </div>
            <div class="form__input-file">
                <input class="visually-hidden" type="file" id="photo2" name="userpic" value="">
                <label for="photo2">
                    <span>+ Добавить</span>
                </label>
            </div>
            <span class="form__error">
                <? if (isset($errors['userpic'])) : print($errors['userpic']); endif; ?>
            </span>
        </div>

        <?php if (count($errors)) {?>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <?php }?>

        <button type="submit" class="button">Зарегистрироваться</button>
        <a class="text-link" href="login.php">Уже есть аккаунт</a>
    </form>
</main>