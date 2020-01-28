# Deprecated in favour of improved and up-to-date kickstart package [EmberSy Fire](https://github.com/The-Don-Himself/Embersy-Fire) please use this one instead, thank you!


# Embersy
#### Embersy is your nifty kickstart package for building ambitious web apps. It comprises of an EmberJs 2.x frontend with a Symfony 3.x powered backend both latest versions and preconfigured to be production ready. 

~~### LIVE DEMO (Database purged periodically)~~
~~Ember Frontend: [https://embersy-frontend2.mybluemix.net](https://embersy-frontend2.mybluemix.net)~~
~~Symfony Backend: [https://embersy-backend2.mybluemix.net](https://embersy-backend2.mybluemix.net)~~


![Image](embersy.png?raw=true "EmberSy Screenshot")


### Production Use
Embersy is the same package powering [Campus Discounts](https://campus-discounts.com/) as such we have an active interest in maintaining it, that said pull requests are most welcome .

### What is [Ember](http://emberjs.com)?
Ember.js is a framework for creating ambitious web applications

### Why Ember?
Ember is used on many popular websites, including Discourse, Groupon, LinkedIn, Vine, Live Nation, Nordstrom, Twitch.tv and Chipotle. Although primarily considered a framework for the web, it is also possible to build desktop and mobile applications in Ember. The most notable example of an Ember desktop application is Apple Music, a feature of the iTunes desktop application. [Source](https://en.wikipedia.org/wiki/Ember.js)

### What is [Symfony](http://symfony.com/)?
Symfony is a set of PHP Components, a Web Application framework, a Philosophy, and a Community — all working together in harmony.

### Why Symfony?
Symfony is used by the open-source Q&A service Askeet and many more applications, including Delicious. At one time it was used for 20 million users of Yahoo! Bookmarks. As of February 2009, Dailymotion.com has ported part of its code to use Symfony, and is continuing the transition. Symfony is used by OpenSky, a social shopping platform, and by the massively multiplayer online browser game eRepublik, as well as by content management framework eZ Publish in version 5. Drupal 8, phpBB and a number of other large applications have incorporated components of Symfony. Symfony2 is also used by Meetic, one of the largest online dating platforms in the world, on most of its websites for implementing its business logic in the backend. Symfony components are also used in other web application frameworks including Laravel, Silex, and Drupal. As of February 12, 2013 the massive wiki-database video game website GiantBomb.com converted from Django to Symfony following an acquisition. [Source](https://en.wikipedia.org/wiki/Symfony)

### Features

Manual registration or authenticate via Oauth 1.0 or 2.0 in over 58 social networks via Symfony and pass token to Ember. Preconfigured PHP classes to transform objects to JSONAPI the recommended json response type by ember, for heavy relational data web apps, you’ll love JSONAPI. Cache like crazy, use Varnish (highly recommended) to cache Symfony responses, use the same Varnish to cache ember fastboot responses, cache invalidatation for both handled by Symfony. Cache scales unbelievably well for both logged in and non-logged in users especially if you put a CDN in front of Varnish. Production ready Varnish vlc configuration included. Database cache not included because of the wide variety to choose from but redis is highly recommended.

The standard ember and symfony frameworks were extended and preconfigured as below:-
#### Ember JS Addons
    - ember-cli-document-title
    - ember-cli-fastboot
    - ember-cli-head
    - ember-network
    - ember-simple-auth

##### Not Included But Recommended
    - ember-cli-concat
    - ember-moment
    - liquid-fire

#### Symfony Bundles & PHP Packages
    - friendsofsymfony/user-bundle
    - friendsofsymfony/rest-bundle
    - friendsofsymfony/oauth-server-bundle
    - friendsofsymfony/http-cache-bundle
    - hwi/oauth-bundle
    - guzzlehttp/guzzle
    - league/fractal
    - jms/di-extra-bundle
    - jms/serializer-bundle
    - ocramius/proxy-manager
    - nelmio/api-doc-bundle 

##### Not Included But Recommended
    - alcaeus/mongo-php-adapter
    - ext-mongo
    - doctrine/mongodb-odm
    - doctrine/mongodb-odm-bundle
    - doctrine/doctrine-migrations-bundle
    - snc/redis-bundle
    - predis/predis
    - php-amqplib/php-amqplib
    - php-amqplib/rabbitmq-bundle
    - jmikola/geojson
    - php-http/httplug
    - friendsofsymfony/elastica-bundle
    - willdurand/geocoder

    (Most of these are packages and bundles to work with other databases... because most ambitious web apps never really depend on one database anyway)

### Install
We are still compiling small parts of the kickstart to remove code that we currently use and adding a few comments here and there but once complete in a few days (within the week), installation would be a simple npm install and bower install for the Ember frontend and composer install for the Symfony backend. You can star or watch the repo to get updated.

### Deploy
Working to bring one click auto-deploy to the cloud soon....
