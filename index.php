<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Расчет кредита по схеме "Аннуитет"</title>
    <link
      href="https://fonts.googleapis.com/css?family=Open+Sans:400,700&display=swap&subset=cyrillic"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/style.css?<?php echo time();?>" />
  </head>
  <body>
    <div class="wrapper">
      <header class="header">
        <div class="container">
          <div class="header__contacts">
            <div>Макаров Антон Владимирович</div>
            <a href="tel:89127353963">8-912-735-39-63</a>
            <a href="mailto:xander11rgn-cool@yandex.ru"
              >xander11rgn-cool@yandex.ru</a
            >
          </div>
        </div>
      </header>

      <main class="calc-form">
        <div class="container">
          <div class="input">
            <div class="input__caption">Исходные данные</div>
            <div class="input__block">
              <div class="input__labels">
                <label class="input__label" for="sum">Сумма кредита, руб</label>
                <label class="input__label" for="term"
                  >Срок кредитования, лет</label
                >
                <label class="input__label" for="percent"
                  >Процентная ставка, % в год</label
                >
                <label class="input__label" for="lastname"
                  >Фамилия
                  <b
                    title="Обязательное поле для отправки заявки"
                    class="required-star"
                    >*</b
                  ></label
                >
                <label class="input__label" for="firstname"
                  >Имя
                  <b
                    title="Обязательное поле для отправки заявки"
                    class="required-star"
                    >*</b
                  ></label
                >
                <label class="input__label" for="middlename">Отчество</label>
                <label class="input__label" for="tel"
                  >Контактный телефон
                  <b
                    title="Обязательное поле для отправки заявки"
                    class="required-star"
                    >*</b
                  ></label
                >
              </div>

              <div class="input__inputs">
                <input
                  type="text"
                  placeholder="100000"
                  name="sum"
                  id="sum"
                  class="input__input"
                />

                <select name="term" id="term" class="input__input">
                  <option value="1" selected>1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                  <option value="13">13</option>
                  <option value="14">14</option>
                  <option value="15">15</option>
                  <option value="16">16</option>
                  <option value="17">17</option>
                  <option value="18">18</option>
                  <option value="19">19</option>
                  <option value="20">20</option>
                </select>

                <input
                  type="text"
                  placeholder="10"
                  name="percent"
                  id="percent"
                  class="input__input"
                />
                <input
                  type="text"
                  placeholder="Иванов"
                  name="lastname"
                  id="lastname"
                  class="input__input"
                />
                <input
                  type="text"
                  placeholder="Иван"
                  name="firstname"
                  id="firstname"
                  class="input__input"
                />
                <input
                  type="text"
                  placeholder="Иванович"
                  name="middlename"
                  id="middlename"
                  class="input__input"
                />
                <input
                  class="input__input phone-mask"
                  type="tel"
                  placeholder="+7 (123) 456-78-90"
                  name="tel"
                  id="tel"
                />
              </div>
            </div>
          </div>
          <br />

          <div class="results">
            <div class="results__caption">Результаты</div>
            <div class="results__block">
              <div class="results__labels">
                <label class="results__label"
                  >Cумма ежемесячных отчислений по кредиту равна:</label
                ><mark class="results__marked result-sum">0 р.</mark>
                <label class="results__label"
                  >Сумма выплаченных процентов равна:</label
                ><mark class="results__marked result-percent">0 р.</mark>
                <label class="results__label">Дата последнего платежа:</label
                ><mark class="results__marked result-date"></mark>
              </div>
              <div class="results__buttons">
                <input
                  type="button"
                  value="Очистка"
                  class="results__clear"
                  title="Очистка всех полей"
                />

                <input
                  type="button"
                  value="Оставить заявку"
                  class="results__request"
                  title="Необходимо ввести фамилию, имя и номер телефона"
                  
                />
              </div>
              <center>
                <input
                  type="button"
                  value="Вывести график платежей"
                  class="results__chart"
                  title="Откроется во всплывающем окне"
                  
                />
              </center>
            </div>
          </div>
        </div>
      </main>

      <footer class="footer">
        <div class="container">
          <div class="footer__contacts">
            <div>
              Разработано: Макаров Антон Владимирович
            </div>
            <div class="footer__links">
              Контакты:&nbsp
              <div class="footer__phone">
                телефон - <a href="tel:89127353963">8-912-735-39-63</a>
              </div>
              <div>
                email -
                <a href="mailto:xander11rgn-cool@yandex.ru"
                  >xander11rgn-cool@yandex.ru</a
                >
              </div>
            </div>
          </div>
        </div>
      </footer>
    </div>

    <div class="popup">
      <div class="popup__block">
        <span class="exit">&times;</span>
        <div class="popup__content"></div>
      </div>
    </div>
    <div class="loader">
      <div class="loader__block">
        <div class="loader__gif">
        <img src="img/load.gif" alt="loading">
      </div>  
      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
    <script src="js/anime.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
    <script src="https://unpkg.com/imask"></script>
    <script src="js/main.js?<?php echo time();?>"></script>
  </body>
</html>