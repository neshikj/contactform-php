<?php
namespace ContactForm\Services;

use Mailgun\Mailgun;
use Mailgun\Exception;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class MailerService {

    /**
     * @param string $key
     */
    private $key;

    /**
     * @param string $domain
     */
    private $domain;

    /**
     * @param string $helpdeskEmail
     */
    private $helpdeskEmail;

    /**
     * @param Logger $logger
     */
    private $logger;

    public function __construct()
    {
        $this->key = getenv('MAILGUN_KEY');
        $this->domain = getenv('MAILGUN_DOMAIN');
        $this->helpdeskEmail = getenv('APP_HELPDESK_EMAIL');

        // Create a log channel
        $logger = new Logger('Mailgun');
        $logger->pushHandler(new StreamHandler(__DIR__.'/../logs/mailer.log'));
        $this->logger = $logger;
    }

    public function send($name, $email, $subject, $message) {

        // Instantiate the client.
        $mailgun = new Mailgun($this->key);

        // Make the call to the client.
        // We can stlye the message and make it prettier and add more info about the sender but it's ok for now
        try {
            $res = $mailgun->sendMessage($this->domain,
                array(
                    'from'    => $name . " <$email>",
                    'to'      => $this->helpdeskEmail,
                    'subject' => $subject,
                    'text'    => $message
                ));

            // Check Mailgun HTTP response codes in case it gave something else than 200 OK

            // We can either put some text as a notice on the frontent and save the error together with the
            // affected user id in database so we can do some action after or investigate

            // Good thing will be to send it to an email address that acts as a monitoring tool so it can be
            // seen right away or create a cronjob that will parse the error log or fetch from DB and do something
            if ($res->http_response_code !== 200) {
                $this->logger->notice('Mailgun code: '.$res->http_response_code.'; Message: '.$res->message.' Customer: '.$email);

                return false;
            }
        } catch(\Exception $e) {
            $this->logger->error('Mailgun exception: '. $e->getMessage());

            return false;
        }

        return true;
    }
}