# Mailgun Extension for Yii 2

Mailgun integration for the Yii framework

[![Build Status](https://travis-ci.com/boundstate/yii2-mailgun.svg?branch=master)](https://travis-ci.com/boundstate/yii2-mailgun)

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

```
composer require boundstate/yii2-mailgun
```

The [Mailgun API Client](https://github.com/mailgun/mailgun-php) is not hard coupled to Guzzle, Buzz or any other library that sends
HTTP messages. You must also install the [PSR-7 implementation and HTTP client](https://packagist.org/providers/php-http/client-implementation)
you want to use.

If you just want to get started quickly you should install [Buzz](https://github.com/kriswallsmith/Buzz) and [nyholm/psr7](https://github.com/Nyholm/psr7):

```bash
composer require kriswallsmith/buzz nyholm/psr7
```

## Usage

Configure it in the application configuration:

```php
'components' => [
    ...
    'mailer' => [
        'class' => 'boundstate\mailgun\Mailer',
        'key' => 'key-example',
        'domain' => 'mg.example.com',
    ],
    ...
],
```

To send an email, you may use the following code:

```php
Yii::$app->mailer->compose('contact/html', ['contactForm' => $form])
    ->setFrom('from@domain.com')
    ->setTo($form->email)
    ->setSubject($form->subject)
    ->send();
```