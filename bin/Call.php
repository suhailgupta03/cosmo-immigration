<?php

class Call {
	
	private $fullName;
	private $phoneNumber;
	private $queryRegarding;
	
	public function __construct($fullName,$phoneNumber,$queryRegarding){
		$this->fullName = $fullName;
		$this->phoneNumber = $phoneNumber;
		$this->queryRegarding;
	}
	public function scheduleCall() {
			try {
				// Update the details in the db
			}catch(Exception $exc){
				
			}
	}
	
}