## Included packages
- Save url slug with [Eloquent sluggable](https://github.com/cviebrock/eloquent-sluggable).
- Create simply forms with Laravel collective [Forms and HTML (5.3)](https://laravelcollective.com/docs/5.3/html)
- Generate IDE helper file with Laravel 5 [IDE Helper Generator](https://github.com/barryvdh/laravel-ide-helper)
- Debug sql queries, sessions etc. with [Clockwork](https://github.com/itsgoingd/clockwork) library
- Transform [PHP Vars to JavaScript](https://github.com/laracasts/PHP-Vars-To-Js-Transformer)
- Retrieve [Gravatar images](https://github.com/creativeorange/gravatar)
- Handle images with [Intervention image](https://github.com/Intervention/image)
- Add [Google Recaptcha](https://github.com/greggilbert/recaptcha) to your forms
- Handle login through facebook, twitter etc. with [Laravel Socialite](https://github.com/laravel/socialite)
- Extended (non official) Eloquent relation [BelongsToThrough](https://github.com/znck/belongs-to-through)
- Set presentable data for your models with [Laracasts Presenter](https://github.com/laracasts/Presenter)

## Instalation
First, you'll need to install the package via Composer:

```shell
$ git clone https://github.com/hscomp/default-project-laravel-5.4.git
```

Install Composer dependencies:

```shell
$ composer install
```

Create and save your .env file in project root.
```shell
.env
```

Generate application key:

```shell
php artisan key:generate
```

Generate ide helper file:

```shell
php artisan ide-helper:generate
```

Publish all configuration files:

```shell
php artisan vendor:publish
```

Set env settings:
```shell
RECAPTCHA_PUBLIC_KEY=your_google_recaptcha_public_key
RECAPTCHA_PRIVATE_KEY=your_google_recaptcha_private_key
FACEBOOK_ID=your_facebook_application_id
FACEBOOK_SECRET=your_facebook_secret_key
FACEBOOK_URL=facebook_callback_url_after_redirecting_back
TWITTER_ID=your_twitter_id
TWITTER_SECRET=your_twitter_application_secret_key
TWITTER_URL=twitter_callback_url_after_redirecting_back
```
