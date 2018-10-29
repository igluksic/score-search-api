<?php

namespace App\Score\DataProcessors;

use App\Models\Score;

class ScoreDataProcessor
{
    public $reader;

    protected $totalResults;
    protected $positiveResults;
    protected $negativeResults;

    public function __construct(\App\Score\Interfaces\DataReaderInterface $reader)
    {
        $this->reader = $reader;
        $this->totalResults = $this->reader->getTotalNumber();
        $this->negativeResults = $this->reader->getNegativeNumber();
        $this->positiveResults = $this->reader->getPositiveNumber();
    }

    public function getPostiveScore()
    {
        if ($this->getTotalResults() == 0) return 0; // no results whatsoever, stop division by zero
        return number_format($this->getPositiveResults() / $this->getTotalResults() * 10, 2);
    }

    public function getNegativeScore()
    {
        if ($this->getTotalResults() == 0) return 0; // no results whatsoever, stop division by zero
        return number_format($this->getNegativeResults() / $this->getTotalResults() * 10, 2);
    }

    public function getReaderErrors()
    {
        return $this->reader->getErrors();
    }

    public function getReaderStatusCode()
    {
        return $this->reader->getStatusCode();
    }

    public function getTotalResults()
    {
        return $this->totalResults;
    }

    public function getPositiveResults()
    {
        return $this->positiveResults;
    }

    public function getNegativeResults()
    {
        return $this->negativeResults;
    }

    public function getScore() :Score
    {
        return $this->reader->getScore();
    }
}