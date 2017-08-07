<?php
namespace ContactForm\Models;

use Assert\Assertion;
use Assert\AssertionFailedException;
use ContactForm\Libs\Database;

class Question {

    /**
     * Status of the Validation
     */
    const NOT_VALID = 0;
    const VALID = 1;

    /**
     * @param string $name
     */
    public $name;

    /**
     * @param string $email
     */
    public $email;

    /**
     * @param string $subject
     */
    public $subject;

    /**
     * @param string $message
     */
    public $message;

    /**
     * Connection with the Database
     *
     * @param Database $db
     */
    private $db;

    /**
     * @param array $validation
     */
    private $validation;

    public function __construct() {
        $this->db = new Database();
    }

    private function validate()
    {
        $validation = array('status' => Question::VALID);
        try {
            Assertion::notEmpty($this->name, 'Name is required field');
        } catch(AssertionFailedException $e) {
            $validation['name'] = $e->getMessage();
        }

        try {
            Assertion::email($this->email, 'Email address is not valid');
        } catch(AssertionFailedException $e) {
            $validation['email'] = $e->getMessage();
        }

        try {
            Assertion::notEmpty($this->subject, 'Subject is required field');
        } catch(AssertionFailedException $e) {
            $validation['subject'] = $e->getMessage();
        }

        try {
            Assertion::notEmpty($this->message, 'Message is required field');
        } catch(AssertionFailedException $e) {
            $validation['message'] = $e->getMessage();
        }

        // Check if there are validation errors
        if (count($validation) > 1) {
            $validation['status'] = Question::NOT_VALID;
            $this->validation = $validation;
            return false;
        }

        return true;
    }

    public function save()
    {
        // If there are no validation errors save data in DB
        if ($this->validate()) {
            // Check if we're connected to the Database
            if($this->db->isConnected){
                $query = "INSERT INTO question (name, email, subject, message) VALUES (?,?,?,?)";
                $params = array(
                    $this->name,
                    $this->email,
                    $this->subject,
                    $this->message
                    );
                $this->db->insert($query,$params);

                return array('status' => Question::VALID);
            }
        }

        return $this->validation;
    }
}