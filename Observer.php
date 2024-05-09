<?php

interface Observer
{
    public function update();
    public function getName(): string;
}

interface Observable
{
    public function addObserver(Observer $observer);
    public function removeObserver(Observer $observer);
    public function updateObservers();
}

class NoticeBoard implements Observable
{
    protected array $observers = [];
    protected array $notices = [];

    public function addObserver(Observer $observer)
    {
        array_push($this->observers, $observer);
    }

    public function removeObserver(Observer $observer)
    {
        $index = array_search($observer, $this->observers);
        unset($this->observers[$index]);
    }

    public function updateObservers()
    {
        foreach ($this->observers as $observer) {
            $observer->update();
        }
    }

    // notice board functionalities
    public function postNotice(string $notice)
    {
        array_push($this->notices, $notice);
        $this->updateObservers();
    }

    public function removeNotice(string $notice)
    {
        $index = array_search($notice, $this->notices);
        unset($this->notices[$index]);
        $this->updateObservers();
    }

    public function getNotices(): array
    {
        return $this->notices;
    }
}

class EmailListener implements Observer
{
    protected string $name;
    protected NoticeBoard $noticeBoard;

    public function __construct(string|null $name, NoticeBoard $noticeBoard)
    {
        $this->name = $name ?? random_bytes(16);
        $this->noticeBoard = $noticeBoard;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function update()
    {
        echo static::getName() . ': ' . "Notice Board Update\n";
        foreach ($this->noticeBoard->getNotices() as $notice) {
            echo $notice . "\n";
        }
        echo "\n\n";
    }
}

class SMSListener implements Observer
{
    protected string $name;
    protected NoticeBoard $noticeBoard;

    public function __construct(string|null $name, NoticeBoard $noticeBoard)
    {
        $this->name = $name ?? random_bytes(16);
        $this->noticeBoard = $noticeBoard;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function update()
    {
        echo static::getName() . ': ' . "Notice Board Update\n";
        foreach ($this->noticeBoard->getNotices() as $notice) {
            echo $notice . "\n";
        }
        echo "\n\n";
    }
}


// test client code

// initialize observable
$noticeBoard = new NoticeBoard();

echo "Posting first notice.\n\n";
// post a notice
$noticeBoard->postNotice("1. Hello this is the first notice.\n");

// initialize listeners
$emailListener1 = new EmailListener('Email Listener 1', $noticeBoard);
$emailListener2 = new EmailListener('Email Listener 2', $noticeBoard);

$smsListener1 = new SMSListener('SMS Listener 1', $noticeBoard);
$smsListener2 = new SMSListener('SMS Listener 2', $noticeBoard);

// add listeners
$noticeBoard->addObserver($emailListener1);
$noticeBoard->addObserver($emailListener2);
$noticeBoard->addObserver($smsListener1);
$noticeBoard->addObserver($smsListener2);

// remove a listener before calling notify
$noticeBoard->removeObserver($smsListener2);
$noticeBoard->removeObserver($emailListener2);

echo "Posting a second notice.\n\n";
$noticeBoard->postNotice("2. Here's a second notice");

echo "Removing first notice.\n\n";
$noticeBoard->removeNotice("1. Hello this is the first notice.\n");

