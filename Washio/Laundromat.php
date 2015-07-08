<?php

namespace Washio;

use GuzzleHttp\Client;

class Laundromat
{
    /**
     * @var GuzzleHttp\Client
     */
    protected $http;

    /**
     * The location of this laundromat
     *
     * @var string
     */
    protected $location;

    /**
     * Create an instance of this laundromat
     *
     * @param Client $http
     */
    public function __construct($baseUrl, $location)
    {
        $this->http = new Client([
            'base_uri'  => $baseUrl,
            'cookies'   => true
        ]);

        $this->location = $location;
    }

    /**
     * Log in to the laundromat
     *
     * @param  string $username
     * @param  string $password
     */
    public function login($username, $password)
    {
        $this->http->post('aLog.asp', [
            'form_params'      => [
                    'username'  => $username,
                    'password'  => $password
                ]
        ]);
    }

    /**
     * Send a get request to the reservation page
     */
    protected function visitReservationPage()
    {
        $this->http->get('Reservation.asp', [
            'cookies'   => true
        ]);
    }

    /**
     * Get a list of all my available washing times
     *
     * @return array
     */
    public function getOwnWashingTimes()
    {
        $response = $this->http->get('SoegReservation.asp');

        $dom = new \DOMDocument;

        // Helps to ignore misformed HTML
        libxml_use_internal_errors(true);

        $dom->loadHTML((string) $response->getBody());

        $tables = $dom->getElementsByTagName('table');

        $table = $tables->item($tables->length - 1);

        $rows = $table->getElementsByTagName('tr');

        $times = [];

        foreach ($rows as $index => $row) {
            if($index > 0) {

                $tds = iterator_to_array($row->getElementsByTagName('td'));

                $dateString = $this->getStrippedString($tds[0]->textContent);
                $timeString = str_replace("Kl. ", "", $this->getStrippedString($tds[1]->textContent));

                $timeString = $timeString === '07:0' ? '07:00' : $timeString;

                $time = \DateTime::createFromFormat('d/m-Y H:i', "$dateString $timeString");

                $times[] = new Wash($time, $this->location);
            }
        }

        return $times;
    }

    /**
     * Get the washing times for the specified date
     *
     * @param  string $date
     *
     * @return array
     */
    public function getWashingTimes($date)
    {
        $response = $this->http->get("Reservation.asp", [
            'query'     => ['Dato' => $date]
        ]);

        return $this->getTimesFromHTML($response->getBody());
    }

    /**
     * Gets washing times from a DOM tree
     *
     * @param  string $DOM
     *
     * @return array
     */
    protected function getTimesFromHTML($DOM)
    {
        $dom = new \DOMDocument;

        libxml_use_internal_errors(true);

        $dom->loadHTML((string) $DOM);

        $tables = $dom->getElementsByTagName('table');

        $table = $tables->item($tables->length - 1);

        $rows = $table->getElementsByTagName('tr');

        $times = [];

        foreach ($rows as $index => $row) {
            if($index > 1) {
                $tds = iterator_to_array($row->getElementsByTagName('td'));

                $times[] = str_replace("&nbsp;", "", htmlentities($tds[1]->textContent));
            }
        }

        return $times;
    }

    protected function getStrippedString($content)
    {
        return str_replace("&nbsp;", "", htmlentities($content));
    }
}
