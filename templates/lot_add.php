<main>
    <nav class="nav">
      <ul class="nav__list container">
          <? foreach ($categories as $val): ?>
              <li class="nav__item">
                  <a href="all-lots.html"><?=$val['title']?></a>
              </li>
          <? endforeach ?>
      </ul>
    </nav>
    <?php $classname = count($errors) ? "form--invalid" : "";?>
    <form class="form form--add-lot container <?=$classname;?>" action="add.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
      <h2>Добавление лота</h2>
      <div class="form__container-two">

       <!-- Наименование лота -->
        <?php $classname = isset($errors['title']) ? "form__item--invalid" : "";
        $title = $_POST['lot']['title'] ?? ''; ?>
        <div class="form__item <?=$classname;?>"> <!-- form__item--invalid -->
          <label for="lot-name">Наименование</label>
          <input id="lot-name" type="text" name="lot[title]" value="<?=strip_tags($title)?>" placeholder="Введите наименование лота" required>
          <span class="form__error">Введите наименование лота</span>
        </div>

        <!-- Категория лота -->
        <?php $classname = isset($errors['category']) ? "form__item--invalid" : "";
        $category = $_POST['lot']['category'] ?? ''; ?>
        <div class="form__item <?=$classname;?>">
          <label for="category">Категория</label>
          <select id="category" name="lot[category]" required>
            <option>Выберите категорию</option>
            <? foreach ($categories as $val): ?>
            <option value="<?=$val['id']?>"
                <? if ($val['id'] === $category) : print('selected'); endif; ?>
            ><?=$val['title']?></option>
            <? endforeach ?>
          </select>
          <span class="form__error">Выберите категорию</span>
        </div>
      </div>

      <!-- Описание лота -->
      <?php $classname = isset($errors['description']) ? "form__item--invalid" : "";
      $description = $_POST['lot']['description'] ?? ''; ?>
      <div class="form__item form__item--wide <?=$classname;?>">
        <label for="message">Описание</label>
        <textarea id="message" name="lot[description]" placeholder="Напишите описание лота" required><?=strip_tags($description)?></textarea>
        <span class="form__error">Напишите описание лота</span>
      </div>

      <!-- Фотография лота -->
      <?php $classname = !isset($errors['file']) && isset($_FILES['picture']['name']) ? "form__item--uploaded" : "form__item--invalid"; ?>
      <div class="form__item form__item--file <?=$classname;?>"> <!-- form__item--uploaded -->
        <label>Изображение</label>
        <div class="preview">
          <button class="preview__remove" type="button">x</button>
          <div class="preview__img">
            <img src="img/avatar.jpg" width="113" height="113" alt="Изображение лота">
          </div>
        </div>
        <div class="form__input-file">
          <input class="visually-hidden" type="file" id="photo2" name="picture" value="">
          <label for="photo2">
            <span>+ Добавить</span>
          </label>
        </div>
        <span class="form__error">
         <? if (isset($errors['file'])) : print($errors['file']); endif; ?>
        </span>
      </div>


      <div class="form__container-three">

        <!-- Начальная цена -->
        <?php $classname = isset($errors['starting_price']) ? "form__item--invalid" : "";
        $starting_price = $_POST['lot']['starting_price'] ?? ''; ?>
        <div class="form__item form__item--small <?=$classname;?>">
          <label for="lot-rate">Начальная цена</label>
          <input id="lot-rate" type="number" name="lot[starting_price]" value="<?=strip_tags($starting_price)?>" placeholder="0" required>
          <span class="form__error">Введите начальную цену</span>
        </div>

        <!-- Шаг ставки -->
        <?php $classname = isset($errors['bet_increment']) ? "form__item--invalid" : "";
        $bet_increment = $_POST['lot']['bet_increment'] ?? ''; ?>
        <div class="form__item form__item--small <?=$classname;?>">
          <label for="lot-step">Шаг ставки</label>
          <input id="lot-step" type="number" name="lot[bet_increment]" value="<?=strip_tags($bet_increment)?>" placeholder="0" required>
          <span class="form__error">Введите шаг ставки</span>
        </div>

        <!-- Дата окончания торгов -->
        <?php $classname = isset($errors['datetime_finish']) ? "form__item--invalid" : "";
        $datetime_finish = $_POST['lot']['datetime_finish'] ?? ''; ?>
        <div class="form__item <?=$classname;?>">
          <label for="lot-date">Дата окончания торгов</label>
          <input class="form__input-date" id="lot-date" type="date"
                 name="lot[datetime_finish]" value="<?=strip_tags($datetime_finish)?>" required>
          <span class="form__error"><? if (isset($errors['datetime_finish'])) : print($errors['datetime_finish']); endif; ?></span>
        </div>
      </div>

      <?php if (count($errors)) {?>
      <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
      <?php }?>

      <button type="submit" class="button">Добавить лот</button>
    </form>
  </main>