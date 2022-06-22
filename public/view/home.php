<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Shortener</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="/public/css/app.css">
</head>
<body>

    <header>
        <div class="container">
            <span class="logo-holder">URL Shortener</span>
        </div>
    </header>

    <main class="container">
        <div class="content">
            <h1>Shorten URLs</h1>

            <div class="form-group">
                <span class="icon-holder">
                    <i class="fa fa-link"></i>
                </span>
                <input type="text" id="url" placeholder="Your link here (max 2048 characters)" autofocus />
                <button id="btn-url">Shorten</button>
            </div>

            <p id="validation-msg" data-show="<?= (empty($data['error']) ? '0' : '1') ?>"><?= $data['error'] ?></p>

            <a href="<?= $data['url'] ?>" target="_blank" id="hash-url" data-show="<?= (empty($data['hash']) ? '0' : '1') ?>"><?= APP_PATH . '/' . $data['hash'] ?></a>

            <p class="remaining-urls-holder">Remainig URLs: <strong id="remaining-urls"><?= $data['urls']['remaining'] ?></strong>.</p>

            <p>URLs will be deleted in</p>

            <div id="timer"><?= $data['timer']['formated'] ?></div>
        </div>
    </main>
    
    <footer>
        <img src="/public/imgs/wave.svg" id="wave">
    </footer>

    <script src="/public/js/main.js"></script>

</body>
</html>
