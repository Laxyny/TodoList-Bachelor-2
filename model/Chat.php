<?php

class Chat
{
	public $chatId;
	public $privateMessage;
	public $chatroomId;
	public $userId;
	public $message;
	public $image;
	public $date;

	public function __construct($chatId, $privateMessage, $chatroomId, $userId, $message, $image, $date)
	{
		$this->chatId = $chatId;
		$this->privateMessage = $privateMessage;
		$this->chatroomId = $chatroomId;
		$this->userId = $userId;
		$this->message = $message;
		$this->image = $image;
		$this->date = $date;
	}
}
