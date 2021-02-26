<?php

namespace Source\Models\External;

use Source\Core\Model;

/**
 * Class responsible for consuming external API from "Mercado Editorial.org"
 *
 * @author Gustavo Pinheiro
 */
class BookApi extends Model {
    /*     * * @var string */

    public $uri;

    /*     * * @var string */
    public $accessKey;

    /*     * * @var string */
    public $endpoint;

    public function __construct() {
        $this->uri = "https://sandbox.mercadoeditorial.org/";
        $this->endpoint = "api/v1.2/book";
    }
    
    /**
     * Responsible for returning the complete uri based on parameters for GET request
     * @param string $begin
     * @param string $interval
     * @param string $firstParam
     * @param string $secondParam
     * @return string
     */
    public function searchByDate(string $begin = "now", string $interval = "P6M", string $firstParam = 'data_inicio', string $secondParam = 'data_termino'): string
    {
        $startDate = new \DateTime($begin);
        $startDate->setTimeZone(new \DateTimeZone('America/Sao_Paulo'));
        $startDateForm = $startDate->format("Ymd");

        $diff = new \DateInterval($interval);

        $endDate = (new \DateTime($begin))->sub($diff);
        $endDate->setTimeZone(new \DateTimeZone('America/Sao_Paulo'));
        $endDateForm = $endDate->format("Ymd");

        $uri = $this->uri.$this->endpoint."?{$firstParam}={$endDateForm}&{$secondParam}={$startDateForm}";
        return $uri;
    }

}
