# Mailgun Extension for Yii 2

This extension provides a [Mailgun](https://www.mailgun.com/) mail solution for [Yii framework 2.0](http://www.yiiframework.com).

[![Latest Stable Version](https://poser.pugx.org/boundstate/yii2-mailgun/v/stable)](https://packagist.org/packages/boundstate/yii2-mailgun)
[![Total Downloads](https://poser.pugx.org/boundstate/yii2-mailgun/downloads)](https://packagist.org/packages/boundstate/yii2-mailgun)
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

To use this extension, simply add the following code in your application configuration:

```php
return [
    //....
    'components' => [
        'mailer' => [
            'class' => 'boundstate\mailgun\Mailer',
            'key' => 'key-example',
            'domain' => 'mg.example.com',
        ],
    ],
];
```

You can then send an email as follows:

```php
Yii::$app->mailer->compose('contact/html', ['contactForm' => $form])
    ->setFrom('from@domain.com')
    ->setTo($form->email)
    ->setSubject($form->subject)
    ->send();
```

You can also specify an array of addresses and/or speicfy names:

```php
$message->setTo(['bob@example.com' => 'Bob']);
```

> **Warning**: By default all recipients' email address will show up in the `to` field for each recipient.
> Enable batch sending to avoid this.

### Batch Sending

When [batch sending](https://documentation.mailgun.com/en/latest/user_manual.html#batch-sending) is enabled, 
Mailgun sends each recipient an individual email with only their email in the `to` field.

To use batch sending, set the `messageClass` to `boundstate\mailgun\BatchMessage` in your application configuration:

```php
'mailer' => [
    'class' => 'boundstate\mailgun\Mailer',
    'messageClass' => 'boundstate\mailgun\BatchMessage',
    // ...
]
```

Composing a batch email is similar to regular emails, 
except you may define and use recipient variables:

```php
Yii::$app->mailer->compose('hello')
    ->setTo([
      'bob@example.com' => [
        'id': 3,
        'full_name' => 'Bob'
      ],
      'jane@example.com' => [
        'id': 4,
        'full_name' => 'Jane'
      ],
    ])
    ->setSubject('Hi %recipient.full_name%')
    ->send();
```


For further instructions refer to the [Mailgun docs](https://documentation.mailgun.com/) and the [related section in the Yii Definitive Guide](http://www.yiiframework.com/doc-2.0/guide-tutorial-mailing.html).