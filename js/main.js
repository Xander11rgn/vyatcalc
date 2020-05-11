const sumInput = document.querySelector('#sum');
const termInput = document.querySelector('#term');
const percentInput = document.querySelector('#percent');
const lastnameInput = document.querySelector('#lastname');
const firstnameInput = document.querySelector('#firstname');
const middlenameInput = document.querySelector('#middlename');
const telInput = document.querySelector('#tel');


sumInput.addEventListener('input', function () {
  let str = sumInput.value;
  let lastChar = parseInt(str[str.length - 1]);
  if (!Number.isInteger(lastChar)) {
    sumInput.value = str.replace(str[str.length - 1], '');

  }
});

percentInput.addEventListener('input', function () {
  let str = percentInput.value;
  let lastChar = str[str.length - 1];

  if ((!Number.isInteger(parseInt(lastChar)) && lastChar != '.') || (lastChar == '.' && str.length == 1)) {
    percentInput.value = str.replace(str[str.length - 1], '');
  }

  if (lastChar == '.') {
    for (i = 0; i < str.length - 1; i++) {
      if (str[i] == '.') {
        percentInput.value = str.substring(0, str.length - 1);
        break;
      }
    }
  }
});


firstnameInput.addEventListener('input', checkLetter.bind(null, firstnameInput));
lastnameInput.addEventListener('input', checkLetter.bind(null, lastnameInput));
middlenameInput.addEventListener('input', checkLetter.bind(null, middlenameInput));

function checkLetter(input, event) {
  const str = input.value;
  const lastChar = str[str.length - 1];
  const pattern = /^[a-zA-Zа-яА-Я]/;
  if (!lastChar.match(pattern)) {
    input.value = str.substring(0, str.length - 1);
  }
}


const maskOptions = {
  mask: '+7 (000)-000-00-00',
  lazy: true,
};
const mask = new IMask(telInput, maskOptions);


let date = new Date();
const options = {
  year: 'numeric',
  month: 'long',
  timezone: 'UTC',
  day: 'numeric'
};
document.querySelector('.result-date').innerHTML = date.toLocaleDateString('ru', options);

sumInput.addEventListener('input', result);
percentInput.addEventListener('input', result);
termInput.addEventListener('input', result);


const resultSum = document.querySelector('.result-sum');
const resultPercent = document.querySelector('.result-percent');
const resultDate = document.querySelector('.result-date');

let i;
let p;
let y;
let dateForChart;

function result() {
  if (sumInput.value == '' || percentInput.value == '' || percentInput.value == '0' || termInput.value == '') {
    return;
  }

  const sum = parseInt(sumInput.value);
  const term = parseInt(termInput.value) * 12;
  const percent = parseFloat(percentInput.value);

  i = percent / (100 * 12); //ежемесячная процентная ставка
  p = sum * (i + i / ((i + 1) ** term - 1)); //ежемесячный платёж
  y = p * term - sum; //сумма выплаченных процентов
  date = new Date();
  dateForChart = date.toDateString();
  date.setMonth(date.getMonth() + term - 1);
  date = date.toLocaleDateString('ru', options);

  const prevP = {
    valP: resultSum.innerHTML
  };
  const prevY = {
    valY: resultPercent.innerHTML
  };
  const prevDate = {
    valDate: resultDate.innerHTML
  };

  anime({
    targets: [prevP, prevY],
    valP: p,
    valY: y,
    easing: 'easeOutQuart',
    update: function () {
      resultSum.innerHTML = prevP["valP"].toFixed(2) + ' р.';
      resultPercent.innerHTML = prevY["valY"].toFixed(2) + ' р.';
    }
  });

  anime({
    targets: prevDate,
    valDate: date,
    round: 1,
    easing: 'easeOutQuart',
    update: function () {
      resultDate.innerHTML = prevDate["valDate"];
    }
  });




  const sumValue = sumInput.value;
  const termValue = termInput.value;
  const percentValue = percentInput.value;
  const lastnameValue = lastnameInput.value;
  const firstnameValue = firstnameInput.value;
  const middlenameValue = middlenameInput.value;
  const telValue = telInput.value;

  $.ajax({
    url: 'php/chart_generator.php',
    type: 'POST',
    cache: false,
    data: {
      'sum': sumValue,
      'term': termValue,
      'percent': percentValue,
      'lastname': lastnameValue,
      'firstname': firstnameValue,
      'middlename': middlenameValue,
      'tel': telValue,
      'i': i,
      'p': p,
      'y': y,
      'date': dateForChart
    },
    dataType: 'html',
    success: function (data) {
      $(".popup__content").html(data);
    }

  });
}


const requestButton = document.querySelector('.results__request');
const clearButton = document.querySelector('.results__clear');
const chartButton = document.querySelector('.results__chart');



clearButton.addEventListener('click', function () {
  removeError();
  const inputsArray = [sumInput, percentInput, lastnameInput, firstnameInput, middlenameInput, telInput];
  termInput.value = 1;
  inputsArray.forEach(el => el.value = '');
  const date = new Date();
  resultSum.innerHTML = 0 + ' р.';
  resultPercent.innerHTML = 0 + ' р.';
  resultDate.innerHTML = date.toLocaleDateString('ru', options);
});



document.querySelector(".exit").addEventListener('click', function () {
  document.querySelector(".popup").classList.remove("active-popup");
});

document.querySelector(".popup").addEventListener('click', function (e) {
  if (e.target == this) {
    document.querySelector(".popup").classList.remove("active-popup");
  }
});



chartButton.addEventListener('click', function () {
  removeError();
  if (sumInput.value == '' || percentInput.value == '' || percentInput.value == '0' || termInput.value == '') {
    sumInput.style.backgroundColor = 'rgb(233, 153, 153)';
    percentInput.style.backgroundColor = 'rgb(233, 153, 153)';
    error("Для расчёта графика платежей необходимо заполнить все необходимые поля.");
  } else {
    document.querySelector(".popup").classList.add("active-popup");
  }

});


sumInput.addEventListener('focus', function () {
  removeError();
  if (sumInput.value == '') {
    sumInput.style.backgroundColor = 'rgb(233, 153, 153)';
  } else {
    sumInput.style.backgroundColor = 'rgb(95, 196, 125)';
  }
});

sumInput.addEventListener('blur', function () {
  sumInput.style.backgroundColor = 'rgb(203, 203, 204)';
});

sumInput.addEventListener('keyup', function () {
  if (sumInput.value == '') {
    sumInput.style.backgroundColor = 'rgb(233, 153, 153)';
  } else {
    sumInput.style.backgroundColor = 'rgb(95, 196, 125)';
  }
});


percentInput.addEventListener('focus', function () {
  removeError();
  if (percentInput.value == '') {
    percentInput.style.backgroundColor = 'rgb(233, 153, 153)';
  } else {
    percentInput.style.backgroundColor = 'rgb(95, 196, 125)';
  }
});

percentInput.addEventListener('blur', function () {
  percentInput.style.backgroundColor = 'rgb(203, 203, 204)';
});

percentInput.addEventListener('keyup', function () {
  if (percentInput.value == '') {
    percentInput.style.backgroundColor = 'rgb(233, 153, 153)';
  } else {
    percentInput.style.backgroundColor = 'rgb(95, 196, 125)';
  }
});


lastnameInput.addEventListener('focus', function () {
  removeError();
  if (lastnameInput.value == '') {
    lastnameInput.style.backgroundColor = 'rgb(233, 153, 153)';
  } else {
    lastnameInput.style.backgroundColor = 'rgb(95, 196, 125)';
  }
});

lastnameInput.addEventListener('blur', function () {
  lastnameInput.style.backgroundColor = 'rgb(203, 203, 204)';
});

lastnameInput.addEventListener('keyup', function () {
  if (lastnameInput.value == '') {
    lastnameInput.style.backgroundColor = 'rgb(233, 153, 153)';
  } else {
    lastnameInput.style.backgroundColor = 'rgb(95, 196, 125)';
  }
});



firstnameInput.addEventListener('focus', function () {
  removeError();
  if (firstnameInput.value == '') {
    firstnameInput.style.backgroundColor = 'rgb(233, 153, 153)';
  } else {
    firstnameInput.style.backgroundColor = 'rgb(95, 196, 125)';
  }
});

firstnameInput.addEventListener('blur', function () {
  firstnameInput.style.backgroundColor = 'rgb(203, 203, 204)';
});

firstnameInput.addEventListener('keyup', function () {
  if (firstnameInput.value == '') {
    firstnameInput.style.backgroundColor = 'rgb(233, 153, 153)';
  } else {
    firstnameInput.style.backgroundColor = 'rgb(95, 196, 125)';
  }
});



middlenameInput.addEventListener('focus', function () {
  removeError();
  middlenameInput.style.backgroundColor = 'rgb(95, 196, 125)';
});

middlenameInput.addEventListener('blur', function () {
  middlenameInput.style.backgroundColor = 'rgb(203, 203, 204)';
});



telInput.addEventListener('focus', function () {
  removeError();
  if (telInput.value.length < 18) {
    telInput.style.backgroundColor = 'rgb(233, 153, 153)';
  } else {
    telInput.style.backgroundColor = 'rgb(95, 196, 125)';
  }
});

telInput.addEventListener('blur', function () {
  telInput.style.backgroundColor = 'rgb(203, 203, 204)';
});

telInput.addEventListener('keyup', function () {
  if (telInput.value.length < 18) {
    telInput.style.backgroundColor = 'rgb(233, 153, 153)';
  } else {
    telInput.style.backgroundColor = 'rgb(95, 196, 125)';
  }
});



requestButton.addEventListener('click', sendMail);

function sendMail() {
  removeError();
  if (lastnameInput.value != '' && firstnameInput.value != '' && telInput.value.length == 18) {
    const sum = sumInput.value;
    const term = termInput.value;
    const percent = percentInput.value;
    const lastname = lastnameInput.value;
    const firstname = firstnameInput.value;
    const middlename = middlenameInput.value;
    const tel = telInput.value;

    $.ajax({
      url: 'php/request.php',
      type: 'POST',
      cache: false,
      beforeSend: function () {
        document.querySelector('.loader').classList.add("active-loader");

      },
      data: {
        'sum': sum,
        'term': term,
        'percent': percent,
        'lastname': lastname,
        'firstname': firstname,
        'middlename': middlename,
        'tel': tel,
        'i': i,
        'p': p,
        'y': y,
        'date': dateForChart
      },
      dataType: 'text',
      success: function (data) {
        if (data.substring(data.length - 7, data.length) == 'Success') {
          popup('Ваша заявка успешно принята.');

        } else {
          popup('<p style="color:red">Ваша заявка не доставлена.</p>');
        }
        document.querySelector('.loader').classList.remove("active-loader");
      }

    });
  } else {
    lastnameInput.style.backgroundColor = 'rgb(233, 153, 153)';
    firstnameInput.style.backgroundColor = 'rgb(233, 153, 153)';
    telInput.style.backgroundColor = 'rgb(233, 153, 153)';
    error('Для отправки заявки необходимо заполнить все обязательные поля.')
  }
}


function error(text) {
  const prev = document.querySelector('.error');
  try {
    prev.parentNode.removeChild(prev);
  } catch (error) {

  }

  const container = document.createElement('div');
  container.innerHTML = '<div class="error">' + text + '</div>';
  const elem = container.firstChild;
  document.querySelector('.results__buttons').appendChild(elem);
}

function removeError() {
  lastnameInput.style.backgroundColor = '#CBCBCC';
  firstnameInput.style.backgroundColor = '#CBCBCC';
  telInput.style.backgroundColor = '#CBCBCC';
  sumInput.style.backgroundColor = '#CBCBCC';
  percentInput.style.backgroundColor = '#CBCBCC';
  const prev = document.querySelector('.error');
  try {
    prev.parentNode.removeChild(prev);
  } catch (error) {

  }
}

function popup(text) {
  const prev = document.querySelector('.message');
  try {
    prev.parentNode.removeChild(prev);
  } catch (error) {

  }
  const container = document.createElement('div');
  container.innerHTML = '<div class="message">' + text +
    '<br><input class="message-ok" type="button" value="OK"/> \
                        </div>';
  const elem = container.firstChild;


  const button = elem.querySelector('.message-ok');
  button.addEventListener('click', function () {

    elem.style.opacity = '0';
    elem.style.transition = 'all 0.5s';

  })
  document.body.appendChild(elem);

}