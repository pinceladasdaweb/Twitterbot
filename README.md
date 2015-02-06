Twitterbot
===========

A simple twitter bot script written in PHP.

How to use
-----------------

* Run create_table.sql file to create the structure of the database.
* Run [composer install](https://getcomposer.org/doc/00-intro.md) in the directory of your application to install the dependencies.
* Open connection.php file and fill the variables with data from your database and your [Twitter OAuth settings] (https://dev.twitter.com/docs/auth/oauth/faq).
* Add to database Tweets you want.
* Enjoy.

Tip
-----------------

* Set a cron job to visit a URL of your Twitterbot. View [example here](http://mycuteblog.com/setting-a-cron-job-to-visit-a-url/).
* Stay tuned to the [limits of the Twitter API](https://dev.twitter.com/rest/public/rate-limiting).
