<?php

interface Notification
{
    public function send(string $text);
}

class PushNotification implements Notification
{
    public function send(string $text)
    {
        echo $text;
    }
}

class NotificationDecorator implements Notification
{
    protected $notification;

    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    public function send(string $text)
    {
        $this->notification->send($text);
    }
}


class SMSNotification extends NotificationDecorator
{
    public function send(string $text)
    {
        parent::send($text);
        echo "SMS: $text";
    }
}

class EmailNotification extends NotificationDecorator
{
    public function send(string $text)
    {
        parent::send($text);
        echo "Email: $text";
    }
}

class TelegramNotification extends NotificationDecorator
{
    public function send(string $text)
    {
        parent::send($text);
        echo "Telegram: $text";
    }
}


// Test Client Code
$text = "Hello this is a notification\n";

$pushNotification = new PushNotification();
// $pushNotification->send($text);

$emailNotification = new EmailNotification($pushNotification);
// $emailNotification->send($text);

$smsNotification = new SMSNotification($emailNotification);
// $smsNotification->send($text);

$telegramNotification = new TelegramNotification($smsNotification);
$telegramNotification->send($text);