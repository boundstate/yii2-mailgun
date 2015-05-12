# Mailgun

Mailgun integration for the Yii framework

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist boundstate/yii2-mailgun "*"
```

or add

```
"boundstate/yii2-mailgun": "*"
```

to the require section of your `composer.json` file.

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