# RestoRate

# technologies ### Tech Specification

  - Symfony 5.4
  - php 7.4
  - Mysql 5.7

### Features

  - CRUD (Create / Read / Delete) Restaurant 
  - CRUD (Create / Read / Delete) Review
  - Login form
  - Fixtures ( User - Restaurant - City - Review )


### Installation

to use this project please follow the instrection below

```sh
$ git clone git@github.com:MarouaneTagragant/RestoRate.git
$ cd RestoRate
$ composer install
```
Update .env and set your database credentials

```sh
$ php bin/console doctrine:schema:drop --force 
$ php bin/console doctrine:schema:create
$ php bin/console doctrine:fixtures:load --no-interaction
```

And finally to start the server so that you can consult the executed project the following command
```sh
$ php bin/console serve:run
```
Verify the deployment by navigating to your server address in your preferred browser.
```sh
http://127.0.0.1:8000
```

License
----

MIT