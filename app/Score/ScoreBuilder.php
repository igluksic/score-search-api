<?php
namespace App\Score;

use App\Models\Score;
use App\Score\DataProcessors\ScoreDataProcessor;

class ScoreBuilder
{
    private $reader;

    public function __construct(string $dataReader, string $query)
    {
        $score = Score::where('query_string', $query)->first() ?? Score::create(['query_string' => $query, 'positive_results' => null, 'negative_results' => null]);
        $this->reader = new $dataReader($query, $score);
    }

    public function getInstance()
    {
        return new ScoreDataProcessor( $this->reader );
    }
}