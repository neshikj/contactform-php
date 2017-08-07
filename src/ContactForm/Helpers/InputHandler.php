<?php
/**
 * This class handles POST data and takes actions to fulfill the scenario
 */

namespace ContactForm\Helpers;

use ContactForm\Models\Question;
use ContactForm\Services\MailerService;
use ContactForm\Services\AirtableService;

class InputHandler {

    public function run(Question $q)
    {
        $q->name = $_POST['contactName'];
        $q->email = $_POST['contactEmail'];
        $q->subject = $_POST['subject'];
        $q->message = $_POST['message'];

        $res = $q->save();

        if ($res['status'] == 1) {
            // Send email
            $mailer = new MailerService();
            $mailer->send($q->name, $q->email, $q->subject, $q->message);

            // Save to Airtable
            $airtable = new AirtableService('question');
            $airtable->save(array(
                'name' => $q->name,
                'email' => $q->email,
                'subject' => $q->subject,
                'message' => $q->message
            ));
        }

        return $res;
    }
}