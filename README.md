
DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



REQUIREMENTS
------------

* РHP 7.0
* Node 8.9
* Yarn 1.5
* Composer 1.6 


HOW TO RUN LOCALLY
------------

Чтобы запустить сайт локально выполните инструкции:

1. скачайте этот репозиторий;
2. установите необходимые пакеты командой `yarn install-packages`;
2. загрузите базу данных командой: `gulp sync-database`;
4. соберите сайт командой `gulp`;
3. запустите PHP сервер с роутером router.php.  
Пример: `php -S 127.0.0.1:80 -t web router.php` 