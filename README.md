Yii 2 Basic Project Template is a skeleton [Yii 2](https://www.yiiframework.com/) application best for
rapidly creating small projects.

Catalog books

REQUIREMENTS
------------

Install and run Docker

INSTALLATION
------------

Clone repozitory
~~~
git clone https://github.com/artem-kuleshov/infotech-catalog-books.git .
~~~

Run docker compose up
~~~
docker-compose up app -d
~~~

Run composer install

~~~
docker-compose run composer install
~~~

Run yii migrate

~~~
docker-compose run yii migrate
~~~

Show result in browser by link
localhost:8888

Now you may register users, add books and test app
