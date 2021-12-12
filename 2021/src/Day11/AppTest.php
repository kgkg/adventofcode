<?php

namespace AoC_2021\Day11;

include "./App.php";

use PHPUnit\Framework\TestCase;

final class AppTest extends TestCase
{
    private string $exampleOne = "
        5483143223
        2745854711
        5264556173
        6141336146
        6357385478
        4167524645
        2176841721
        6882881134
        4846848554
        5283751526
    ";

    private string $exampleTwo = "
        2264552475
        7681287325
        3878781441
        6868471776
        7175255555
        7517441253
        3513418848
        4628736747
        1133155762
        8816621663
    ";

    public function test_example_1_should_be_correct_after_1_iteration(): void
    {
        // given
        $expectedGridString = "
            6594254334
            3856965822
            6375667284
            7252447257
            7468496589
            5278635756
            3287952832
            7993992245
            5957959665
            6394862637
        ";

        $expectedGrid = $this->parseGrid($expectedGridString);

        $app = new App($this->parseGrid($this->exampleOne));

        // when
        $app->iterate(1);

        // then
        $this->assertSame($expectedGrid, $app->dump());
    }

    public function test_example_1_should_be_correct_after_2_iterations(): void
    {
        // given
        $expectedGridString = "
            8807476555
            5089087054
            8597889608
            8485769600
            8700908800
            6600088989
            6800005943
            0000007456
            9000000876
            8700006848
        ";

        $expectedGrid = $this->parseGrid($expectedGridString);

        $app = new App($this->parseGrid($this->exampleOne));

        // when
        $app->iterate(2);

        // then
        $this->assertSame($expectedGrid, $app->dump());
    }

    public function test_example_1_should_be_correct_after_10_iterations(): void
    {
        // given
        $expectedGridString = "
            0481112976
            0031112009
            0041112504
            0081111406
            0099111306
            0093511233
            0442361130
            5532252350
            0532250600
            0032240000
        ";

        $expectedGrid = $this->parseGrid($expectedGridString);

        $app = new App($this->parseGrid($this->exampleOne));

        // when
        $app->iterate(10);

        // then
        $this->assertSame($expectedGrid, $app->dump());
        $this->assertSame(204, $app->totalFlashCount());
    }

    public function test_example_1_should_be_correct_after_100_iterations(): void
    {
        // given
        $expectedGridString = "
            0397666866
            0749766918
            0053976933
            0004297822
            0004229892
            0053222877
            0532222966
            9322228966
            7922286866
            6789998766
        ";

        $expectedGrid = $this->parseGrid($expectedGridString);

        $app = new App($this->parseGrid($this->exampleOne));

        // when
        $app->iterate(100);

        // then
        $this->assertSame($expectedGrid, $app->dump());
        $this->assertSame(1656, $app->totalFlashCount());
    }

    public function test_example_1_should_return_first_iteration_when_all_are_flashed(): void
    {
        // given
        $app = new App($this->parseGrid($this->exampleOne));
        $expectedIterationNr = 195;

        // when
        $iterationNr = $app->iterateUntilAllFlashed();

        // then
        $this->assertSame($expectedIterationNr, $iterationNr);
    }

    public function test_example_2_should_be_correct_after_100_iterations(): void
    {
        // given
        $expectedGridString = "
            4570064397
            5734436439
            7322222643
            1322222364
            8322222304
            6822222987
            5678887655
            5555555555
            6655555555
            0655555555
        ";

        $expectedGrid = $this->parseGrid($expectedGridString);

        $app = new App($this->parseGrid($this->exampleTwo));

        // when
        $app->iterate(100);

        // then
        $this->assertSame($expectedGrid, $app->dump());
        $this->assertSame(1632, $app->totalFlashCount());
    }

    public function test_example_2_should_return_first_iteration_when_all_are_flashed(): void
    {
        // given
        $app = new App($this->parseGrid($this->exampleTwo));
        $expectedIterationNr = 303;

        // when
        $iterationNr = $app->iterateUntilAllFlashed();

        // then
        $this->assertSame($expectedIterationNr, $iterationNr);
    }


    private function parseGrid(string $gridAsString): array
    {
        $rows = preg_split("/\n/", $gridAsString);

        $ret = [];

        foreach ($rows as $row) {
            $row = trim($row);
            if (strlen($row) > 0) {
                $digits = str_split($row);
                $ret[] = array_map(fn($power) => intval($power), $digits);
            }
        }

        return $ret;
    }
}