const API_PATH = '/api/';

// Elements.
const elmUrl         = document.getElementById('url'),
    elmBtnUrl        = document.getElementById('btn-url'),
    elmValidationMsg = document.getElementById('validation-msg'),
    elmHashUrl       = document.getElementById('hash-url'),
    elmRemainigUrls  = document.getElementById('remaining-urls'),
    elmTimer         = document.getElementById('timer')
;

let interval;

/**
 * It starts coutdown timer.
 *
 * @author Nikola Nikolić <rogers94@gmail.com>
 * @param  integer time Time in seconds.
 * @return void
 */
 function startTimer(time) {
    elmTimer.textContent = toTimeFormat(time);

    interval = setInterval(function () {
        time--;
        if (time < 0) {
            clearInterval(interval);

            time = CRONJOB_TIME;
            startTimer(time);
            return;
        }

        elmTimer.textContent = toTimeFormat(time);

    }, 1000);
}

/**
 * It formats number to time format with leading zero's.
 *
 * @author Nikola Nikolić <rogers94@gmail.com>
 * @param  integer time Time in seconds.
 * @return string       Formated time.
 */
function toTimeFormat(time = 0) {
    let hours   = Math.floor(time / 3600),
        minutes = Math.floor((time - (hours * 3600)) / 60),
        seconds = time - (hours * 3600) - (minutes * 60)
    ;

    if (hours < 10) {
        hours = '0' + hours;
    }

    if (minutes < 10) {
        minutes = '0' + minutes;
    }

    if (seconds < 10) {
        seconds = '0' + seconds;
    }

    return hours + ':' + minutes + ':' + seconds;
}

/**
 * It is used for savig URL.
 *
 * @author Nikola Nikolić <rogers94@gmail.com>
 * @return void
 */
function shortenUrlButton() {
    elmHashUrl.href         = '#';
    elmHashUrl.textContent  = '';
    elmHashUrl.dataset.show = 0;

    if ((elmUrl.value.length <= 10) && (elmUrl.value.length >= 2048)) {
        elmValidationMsg.textContent  = 'You have to enter a URL that is between 10 and 2048 characters long!';
        elmValidationMsg.dataset.show = 1;

        elmUrl.value = '';
        elmUrl.focus();
        return;
    }

    sendRequest('POST', 'save');
}

/**
 * It is used for sending AJAX requests.
 *
 * @author Nikola Nikolić <rogers94@gmail.com>
 * @param  string method HTTP method.
 * @param  string api    API route path.
 * @return void
 */
function sendRequest(method = 'GET', api = 'get') {
    let request = '',
        xhttp = new XMLHttpRequest()
    ;

    if (method === 'POST') {
        request = JSON.stringify({
            url: encodeURIComponent(elmUrl.value),
        });
    }

    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let response = JSON.parse(this.responseText);
            renderResponse(response);
        }
    };

    xhttp.open(method, API_PATH + api, true);
    xhttp.setRequestHeader('Content-type', 'application/json');
    xhttp.send(request);
}

/**
 * It is for rendering AJAX response.
 *
 * @author Nikola Nikolić <rogers94@gmail.com>
 * @param  object response AJAX response.
 * @return void
 */
function renderResponse(response) {
    elmHashUrl.dataset.show       = 0;
    elmValidationMsg.dataset.show = 0;

    if (response.error.length) {
        elmValidationMsg.textContent  = response.error;
        elmValidationMsg.dataset.show = 1;

        elmUrl.value = '';
        elmUrl.focus();
        return;
    }

    elmUrl.value = '';
    elmUrl.focus();

    startTimer(response.timer.number);

    if (response.hash.length) {
        let hashUrl = APP_PATH + response.hash;

        elmHashUrl.href         = hashUrl;
        elmHashUrl.textContent  = hashUrl;
        elmHashUrl.dataset.show = response.hash.length ? 1 : 0;
    }

    elmRemainigUrls.textContent = response.urls.remaining;

    elmBtnUrl.disabled = elmUrl.disabled = response.urls.remaining <= 0;
}

startTimer(time);

elmBtnUrl.addEventListener('click', shortenUrlButton);
