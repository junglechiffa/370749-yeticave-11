<?php echo $lot;?>
  <main>
    <nav class="nav">
      <ul class="nav__list container">
      <?php foreach ($categorys as $value): ?>
        <li class="nav__item">
          <a href="all-lots.html"><?= htmlspecialchars($value['name']); ?></a>
        </li>
      <?php endforeach ;?>
      </ul>
    </nav>

    <form class="form form--add-lot container form--invalid" enctype="multipart/form-data" action="add.php" method="post"> <!-- form--invalid -->
      <h2>Добавление лота</h2>
      <div class="form__container-two">
        <div class="form__item"> <!-- form__item--invalid -->
          <label for="lot-name">Наименование <sup>*</sup></label>
          <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" value="<?= htmlspecialchars($lot['lot_name']); ?>">
          <span class="form__error"><?php echo $error['lot_name']; ?></span>
        </div>
        <div class="form__item <?php if(isset($error['category'])){echo "form__item--invalid";} ?>">
          <label for="category">Категория <sup>*</sup></label>
          <select id="category" name="category">
            <option>Выберите категорию</option>
          <?php foreach ($categorys as $value): ?>
            <option <?php if($value['id'] == $lot['category']){echo "selected ";}?>value="<?php echo $value['id']; ?>">
              <?= htmlspecialchars($value['name']); ?>  
            </option>
          <?php endforeach ;?>
          </select>
          <span class="form__error">Выберите категорию</span>
        </div>
      </div>
      <div class="form__item form__item--wide <?php if(isset($error['message'])){echo "form__item--invalid";} ?>">
        <label for="message">Описание <sup>*</sup></label>
        <textarea id="message" name="message" placeholder="Напишите описание лота"> <?= htmlspecialchars($lot['message']); ?></textarea>
        <span class="form__error"><?php echo $error['message']; ?></span>
      </div>

      <div class="form__item form__item--file <?php if(isset($error['lot_pic'])){echo "form__item--invalid";} ?>">
        <label>Изображение <sup>*</sup></label>
        <div class="form__input-file">
          <input class="visually-hidden" type="file" id="lot-img" name="lot_pic" value="<?= htmlspecialchars($lot['lot_pic']); ?>" >
          <label for="lot-img">
            Добавить
          </label>

        </div>
      </div>
      <div class="form__container-three">
        <div class="form__item form__item--small <?php if(isset($error['lot_rate'])){echo "form__item--invalid";} ?>">
          <label for="lot-rate">Начальная цена <sup>*</sup></label>
          <input id="lot-rate" type="text" name="lot-rate" placeholder="0" value="<?= htmlspecialchars($lot['lot_rate']); ?>">
          <span class="form__error"><?php echo $error['lot_rate']; ?></span>
        </div>
        <div class="form__item form__item--small <?php if(isset($error['lot_step'])){echo "form__item--invalid";} ?>">
          <label for="lot-step">Шаг ставки <sup>*</sup></label>
          <input id="lot-step" type="text" name="lot-step" placeholder="0" value="<?= htmlspecialchars($lot['lot_step']); ?>">
          <span class="form__error"><?php echo $error['lot_step']; ?></span>
        </div>
        <div class="form__item <?php if(isset($error['lot_date'])){echo "form__item--invalid";} ?>">
          <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
          <input class="form__input-date" id="lot-date" type="text" name="lot-date" placeholder="Введите дату в формате ГГГГ-ММ-ДД" value="<?= htmlspecialchars($lot['lot_date']); ?>">
          <span class="form__error"><?php echo $error['lot_date']; ?></span>
        </div>
      </div>
      <span class="form__error form__error--bottom"><?php if(isset($error) and count($error) !== 0){echo 'Пожалуйста, исправьте ошибки в форме.';} ?>
        <?php if(isset($error['file'])){echo $error['file'];} ?></span>
      <button type="submit" class="button">Добавить лот</button>
    </form>

  </main>


