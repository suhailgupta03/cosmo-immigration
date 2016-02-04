<?php

/**
 * Mail class for Cosmo Immigration
 * @author suhail
 * @version 1.0.0
 */
class Mail {
	
	/** @var string */
	private $to;
	
	/** @var string */
	private $subject;
	
	/** @var string */
	private $body;
	
	/** @var array */
	private $headers;
	
	public function __construct(){
		$this->to = 'info@cosmoimmigration.com';
	}
	
	public function setSubject($subject) {
		$this->subject = $subject;
	}
	
	public function setBody($body){
		$this->body = $body;	
	}
	
	public function setHeaders($headers){
		$this->headers = $headers;	
	}
	
	/**
	 * Call this function to send email after setting the mandatory parameters.
	 * @return boolean
	 * @since version 1.0.0
	 */
	public function send() {
		
	}
}