<?php

class Bans
{
	public $banId;
	public $userId;
	public $reason;
	public $date;

	public function __construct($banId, $userId, $reason, $date)
	{
		$this->banId = $banId;
		$this->userId = $userId;
		$this->reason = $reason;
		$this->date = $date;
	}
}
