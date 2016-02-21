<?php

/**
 * Mail class for Cosmo Immigration
 * @author suhail
 * @version 1.0.0
 */
class CIMail {
	
	/** @var string */
	private $to;
	
	/** @var string */
	private $from;
	
	/** @var string */
	private $subject;
	
	/** @var string */
	private $body;
	
	/** @var array */
	private $headers;
	
	/** @var string */
	private $phoneNumber;
	
	/** @var string */
	private $emailAddress;
	
	/** @var string */
	private $query;
	
	public function __construct(){
		$this->to = 'info@cosmoimmigration.com';
		$this->from = 'no-reply@cosmoimmigration.com';	
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
	
	public function setPhoneNumber($phoneNumber){
		$this->phoneNumber = $phoneNumber;
	}
	
	public function setEmailAddress($emailAddress) {
		$this->emailAddress = $emailAddress;
	}
	
	public function setQuery($query){
		$this->query = $query;
	}
	
	private function getBody() {
		return "<em>Hey,</em> <br /> <br /> This could be a potential client. <br />".
			   "Contact Number: <strong>". $this->phoneNumber."</strong> <br />".
			   "Email Address: <strong>".$this->emailAddress."</strong> <br />".
			   "Message: <strong>".$this->query."</strong><br /> <br />".
			   "<em>Regards,<br /> CosmoImmigration: Contact-Us </em><br />";
	}
	
	/**
	 * Call this function to send email after setting the mandatory parameters.
	 * @return boolean
	 * @since version 1.0.0
	 */
	public function send() {
		$headers = "From: ".$this->from."\r\n";
		$headers .= "Cc: nitin@cosmoimmigration.com \r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$status = mail($this->to, $this->subject, $this->getBody(), $headers);
		return $status;
	}
}