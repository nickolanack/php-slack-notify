# php-slack-notify
A very simple slack - incoming webhook notifier for php


Usage:
```php
<?php 

include_once __DIR__.'/vendor/autoload.php';
(new Slack($webhookUrl))->post('Hello World');


```
