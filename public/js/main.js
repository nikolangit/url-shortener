const API_PATH = '/api/';

const elmUrl         = document.getElementById('url'),
    elmBtnUrl        = document.getElementById('btn-url'),
    elmValidationMsg = document.getElementById('validation-msg'),
    elmHashUrl       = document.getElementById('hash-url'),
    elmRemainigUrls  = document.getElementById('remaining-urls'),
    elmTimer         = document.getElementById('timer')
;

let interval;

function to_time_format(time = 0) {
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

function shortenUrlButton() {
    elmHashUrl.href             = '#';
    elmHashUrl.textContent      = '';
    elmHashUrl.style.visibility = 'hidden';

    if ((elmUrl.value.length <= 10) && (elmUrl.value.length >= 2048)) {
        elmValidationMsg.textContent      = 'You have to enter a valid URL!';
        elmValidationMsg.style.visibility = 'visible';

        elmUrl.focus();
        return;
    }

    sendRequest('POST', 'save');
}

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

            elmHashUrl.style.visibility       = 'hidden';
            elmValidationMsg.style.visibility = 'hidden';

            if (response.error.length) {
                elmValidationMsg.textContent      = response.error;
                elmValidationMsg.style.visibility = 'visible';

                elmUrl.value.focus();
                return;
            }

            elmHashUrl.href             = response.url;
            elmHashUrl.textContent      = 'http://url-shortener.loc/' + response.hash;
            elmHashUrl.style.visibility = 'visible';

            elmRemainigUrls.textContent = response.urls.remaining;

            elmBtnUrl.disabled = elmUrl.disabled = response.urls.remaining <= 0;

            elmTimer.textContent = to_time_format(response.timer.number);
            interval = setInterval(() => {
                response.timer--;
                if (response.timer < 0) {
                    clearInterval(interval);
                }
        
                elmTimer.textContent = to_time_format(response.timer.number);
        
            }, 1000);
        }
    };

    xhttp.open(method, API_PATH + api, true);
    xhttp.setRequestHeader('Content-type', 'application/json');
    xhttp.send(request);
}

sendRequest();

elmBtnUrl.addEventListener('click', shortenUrlButton);
