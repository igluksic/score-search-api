<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Models\Score;
use App\Score\DataReaders\GitHubIssueReader;
use App\Score\ScoreBuilder;

class ScoreTest extends TestCase
{
    use DatabaseTransactions; // begins transaction but does not commit them to DB

    public function testGithubReaderFromDatabase()
    {
        $score = Score::create(['query_string' => 'tometestingquerystringfortests', 'positive_results' => 20, 'negative_results' => 30]);
        $gitHubIssueReader = new GitHubIssueReader('tometestingquerystringfortests', $score);


        $this->assertEquals(
            $gitHubIssueReader->getPositiveNumber(), 20, 'Wrongly ready positive number'
        );

        $this->assertEquals(
            $gitHubIssueReader->getNegativeNumber(), 30, 'Wrongly read negative number'
        );

        $this->assertEquals(
            $gitHubIssueReader->getTotalNumber(), 50, 'Wrongly calculated total number'
        );

    }

    public function testScoreBuilder()
    {
        $score = Score::create(['query_string' => 'tometestingquerystringfortests', 'positive_results' => 28, 'negative_results' => 45]);

        $processorGithub = (new ScoreBuilder(GitHubIssueReader::class, 'tometestingquerystringfortests'))->getInstance();

        $this->assertEquals(
            $processorGithub->getPostiveScore(), 3.84, 'Positive score not calculated correctly'
        );

    }
}
