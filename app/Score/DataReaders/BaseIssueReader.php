<?php
namespace App\Score\DataReaders;

use App\Models\Score;

abstract class BaseIssueReader
{
    protected $query;
    protected $score;
    protected $errors = [];
    protected $statusCode = 200;

    const POSITIVE_IDENTIFICATION_SUFFIX = 'rocks';
    const NEGATIVE_IDENTIFICATION_SUFFIX = 'sucks';

    public function __construct(string $query, Score $score)
    {
        $this->query = $query;
        $this->score = $score;
    }

    public function processScore (string $entry, $totalCount)
    {
        $this->score->update([$entry => $totalCount]);
        return $totalCount;
    }

    public function getScore() : Score
    {
        return $this->score;
    }

    public function setError(string $text)
    {
        $this->errors[] = $text;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    abstract function readEndpoint(string $actualQuery);
    abstract function getPositiveNumber();
    abstract function getNegativeNumber();
    abstract function getTotalNumber();
}