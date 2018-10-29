<?php

namespace App\Score\Interfaces;

interface DataReaderInterface
{
    public function readEndpoint(string $actualQuery);
    public function getPositiveNumber();
    public function getNegativeNumber();
    public function getTotalNumber();
    public function getScore();
    public function getErrors();
    public function getStatusCode();
}