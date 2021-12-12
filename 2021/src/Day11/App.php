<?php

namespace AoC_2021\Day11;

final class App
{
    private int $totalFlashCount = 0;
    private int $iterationNr = 0;
    private int $rowCount;

    public function __construct(private array $grid)
    {
        $this->rowCount = count($this->grid);
    }

    public function iterate(int $iterationCount): void
    {
        for ($i = 0; $i < $iterationCount; $i++) {
            $this->nextStep();
        }
    }

    public function iterateUntilAllFlashed(): int
    {
        while ($this->allFlashed() === false) {
            $this->nextStep();
        }

        return $this->iterationNr;
    }

    private function nextStep(): void
    {
        $this->iterationNr++;

        $this->increasePower();

        while ($this->flashesLeftToHandle() > 0) {
            $this->handleFlashes();
        }
    }

    private function increasePower(): void
    {
        array_walk_recursive($this->grid, function (int &$power) {
            $power = $this->increasedValue($power);

            if ($power > 9) {
                $power = -1;
            }
        });
    }

    private function increasedValue(int $power): int
    {
        $power++;

        if ($power > 9) {
            $power = -1;
        }

        return $power;
    }

    private function flashesLeftToHandle(): int
    {
        $flashesLeft = 0;

        array_walk_recursive($this->grid, function (int $power) use (&$flashesLeft) {
            if ($power < 0) {
                $flashesLeft++;
            }
        });

        return $flashesLeft;
    }

    private function handleFlashes(): void
    {
        foreach ($this->grid as $y => $row) {
            foreach ($row as $x => $octopus) {
                if ($octopus === -1) {
                    $this->handleFlash($x, $y);
                    $this->setPower($x, $y, 0);
                    $this->totalFlashCount++;
                }
            }
        }
    }

    private function handleFlash(int $x, int $y): void
    {
        $surroundings = $this->getSurroundingOctopusses($x, $y);

        foreach ($surroundings as [$surroundingY, $surroundingX]) {
            $power = $this->power($surroundingX, $surroundingY);

            if ($power > 0) {
                $this->setPower($surroundingX, $surroundingY, $this->increasedValue($power));
            }
        }
    }

    private function getSurroundingOctopusses(int $x, int $y): array
    {
        $ret = [
            // top
          [$y - 1, $x - 1],
          [$y - 1, $x],
          [$y - 1, $x + 1],

            // middle
          [$y, $x - 1],
          [$y, $x + 1],

            // bottom
          [$y + 1, $x - 1],
          [$y + 1, $x],
          [$y + 1, $x + 1],
        ];

        return array_filter($ret, function (array $coords) {
            return $coords[0] >= 0 && $coords[0] < $this->rowCount
                   && $coords[1] >= 0 && $coords[1] < $this->rowCount;
        });
    }

    private function power(int $x, $y): int
    {
        return $this->grid[$y][$x];
    }

    private function setPower(int $x, int $y, int $power): void
    {
        $this->grid[$y][$x] = $power;
    }

    public function totalFlashCount(): int
    {
        return $this->totalFlashCount;
    }

    public function dump(): array
    {
        return $this->grid;
    }

    public function display(): void
    {
        foreach ($this->grid as $row) {
            echo join("", $row) . "\n";
        }
    }

    private function allFlashed(): bool
    {
        $notFlashedCount = 0;

        array_walk_recursive($this->grid, function (int $power) use (&$notFlashedCount) {
            if ($power !== 0) {
                $notFlashedCount++;
            }
        });

        return $notFlashedCount === 0;
    }
}