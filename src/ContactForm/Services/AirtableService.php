<?php
namespace ContactForm\Services;

use Armetiz\AirtableSDK\Airtable;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class AirtableService {

    /**
     * @var string
     */
    private $table;

    /**
     * @param Airtable $airtable
     */
    private $airtable;

    /**
     * @param Logger $logger
     */
    private $logger;

    public function __construct($table)
    {
        $this->table = $table;

        // Create a log channel
        $logger = new Logger('Airtable');
        $logger->pushHandler(new StreamHandler(__DIR__.'/../logs/airtable.log'));
        $this->logger = $logger;

        try {
            $this->airtable = new Airtable(getenv('AIRTABLE_KEY'), getenv('AIRTABLE_BASE'));
        } catch (\Exception $e) {
            $this->logger->error('Airtable connection issue: '.$e->getMessage());
        }
    }

    public function save(array $data)
    {
        try {
            $this->airtable->createRecord($this->table, $data);
        } catch (\Exception $e) {
            $this->logger->error('Airtable save issue: '.$e->getMessage());
        }
    }

    public function clear()
    {
        try {
            $this->airtable->flushRecords($this->table);
        } catch (\Exception $e) {
            $this->logger->error('Airtable clear issue: '.$e->getMessage());
        }
    }
}