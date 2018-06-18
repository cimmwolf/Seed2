<?php

/**
 * @var $this \yii\web\View
 * @var $content string
 */

use yii\helpers\Html;
use app\assets\MainAsset;

MainAsset::register($this);

$this->params['bodyClasses'] = $this->params['bodyClasses'] ?? [];
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="/img/favicon/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/img/favicon/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/img/favicon/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/img/favicon/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon-precomposed" sizes="60x60" href="/img/favicon/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="/img/favicon/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon-precomposed" sizes="76x76" href="/img/favicon/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="/img/favicon/apple-touch-icon-152x152.png">
    <link rel="icon" type="image/png" href="/img/favicon/favicon-196x196.png" sizes="196x196">
    <link rel="icon" type="image/png" href="/img/favicon/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="/img/favicon/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/img/favicon/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="/img/favicon/favicon-128.png" sizes="128x128">
    <meta name="application-name" content="&nbsp;">
    <meta name="msapplication-TileColor" content="#FFAC00">
    <meta name="msapplication-TileImage" content="/img/favicon/mstile-144x144.png">
    <meta name="msapplication-square70x70logo" content="/img/favicon/mstile-70x70.png">
    <meta name="msapplication-square150x150logo" content="/img/favicon/mstile-150x150.png">
    <meta name="msapplication-wide310x150logo" content="/img/favicon/mstile-310x150.png">
    <meta name="msapplication-square310x310logo" content="/img/favicon/mstile-310x310.png">

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    <link rel="preload" href="/fonts/futurapt-book.woff" as="font" type="font/woff" crossorigin>
    <style>
        @font-face {
            font-family: 'Futura PT Book';
            src: url('/fonts/futurapt-book.woff') format('woff');
            font-weight: normal;
            font-style: normal;
        }
    </style>
    <script>if ('fonts' in document) document.fonts.load('16px Futura PT Book');</script>

    <script>
        (function() {
            if ('registerElement' in document
                && 'import' in document.createElement('link')
                && 'content' in document.createElement('template')) {
                window.WebComponents = {ready: true}
            } else
                document.write('<script src="/bower_components/webcomponentsjs/webcomponents-lite.min.js"><\/script>');

            if (!('scrollBehavior' in document.documentElement.style))
                document.write('<script src="<?=$this->assetBundles['app\assets\SmoothScrollAsset']->baseUrl?>/smoothscroll.min.js"><\/script>');

            if (!window.HTMLPictureElement)
                document.write('<script src="//cdn.rawgit.com/scottjehl/picturefill/3.0.2/dist/picturefill.min.js" async><\/script>');

            var features = [];
            if (!('remove' in Element.prototype))
                features.push('Element.prototype.remove');

            if (!('IntersectionObserver' in window))
                features.push('IntersectionObserver');

            if (features.length > 0)
                document.write('<script src="//cdn.polyfill.io/v2/polyfill.min.js?features=' + features.join() + '"><\/script>')
        })();
    </script>

    <style>
        .top-banner:before {
            background-color: rgba(0, 0, 0, 0.2);
        }
    </style>

    <?php $this->head() ?>

    <style is="custom-style">
        :root {
            --goods-table-width: 800px;
            --primary-color: #FFAC00;
            --paper-tabs-selection-bar-color: #000;
            --paper-tab-ink: var(--primary-color);
            --paper-font-common-base: {
                font-size: 12pt;
                font-family: 'Futura PT Book', sans-serif;
            };
            --paper-font-body1: {
                @apply(--paper-font-common-base);
            };
            --paper-tabs-container: {
                margin-bottom: -1px;
            };
            --paper-tabs-content: {
                display: flex;
                justify-content: center;
                min-width: 100%;
            };
            --paper-tabs: {
                border-bottom: 1px solid #ccc;
                overflow: visible;
            };
            --paper-tab: {
                flex-grow: unset;
            };
            --paper-tab-content: {
                font-size: 14pt;
                text-transform: uppercase;
                font-weight: inherit !important;
            };
            --paper-radio-group-item-padding: {0};
            --paper-radio-button-radio-container: {
                vertical-align: top;
                margin-top: 4px;
            };
        }
    </style>
</head>
<body class="<?= implode(' ', $this->params['bodyClasses']) ?>">
<?php $this->beginBody() ?>

<?= $content ?>

<script>
    (function() {
        var links = document.querySelectorAll('a[href^="#"]');
        for (var i = 0, len = links.length; i < len; i++) {
            links[i].addEventListener('click', function(e) {
                e.preventDefault();
                var target = document.getElementById(e.currentTarget.getAttribute('href').replace('#', ''));

                if (target) {
                    target.scrollIntoView({block: 'start', behavior: "smooth"});
                }
            })
        }
    })();
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
