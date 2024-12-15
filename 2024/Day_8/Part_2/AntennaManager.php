<?php

namespace Day_8\Part_2;

readonly class AntennaManager
{
    /**
     * @param Antenna[] $antennas
     */
    private function __construct(
        private array $antennas,
        private int $xMax,
        private int $yMax,
        private array $frequencies,
    ) {}

    public static function init(string $filepath): self
    {
        if (!file_exists($filepath)) {
            throw new \Exception("File not found: $filepath");
        }

        $content = file_get_contents($filepath);
        $lines = explode("\n", $content);

        $antennas = [];
        $frequencies = [];
        $yMax = 0;
        $xMax = 0;
        foreach ($lines as $y => $line) {
            $positions = str_split(trim($line));
            foreach ($positions as $x => $frequency) {
                if ($frequency !== '.') {
                    if (!in_array($frequency, $frequencies, true)) {
                        $frequencies[] = $frequency;
                    }
                    $antenna = new Antenna($frequency, $x, $y);
                    $antennas[] = $antenna;
                }
                $xMax = max($xMax, $x);
            }
            $yMax = max($yMax, $y);
        }

        return new self($antennas, $xMax, $yMax, $frequencies);
    }

    /**
     * @return Antenna[]
     */
    private function getAntennasWithFrequency(string $frequency): array
    {
        $antennas = [];
        foreach ($this->antennas as $antenna) {
            if ($antenna->getFrequency() === $frequency) {
                $antennas[] = $antenna;
            }
        }
        return $antennas;
    }

    /**
     * @return Antenna[]
     */
    public function getAntinodes(): array
    {
        $totalAntinodes = [];
        foreach ($this->frequencies as $frequency) {
            $antennas = $this->getAntennasWithFrequency($frequency);
            foreach ($antennas as $key => $antenna) {
//                $othersAntennas = $antennas;
//                unset($othersAntennas[$key]);
                foreach ($antennas as $key2 => $otherAntenna) {
                    if($key === $key2){
                        continue;
                    }
                    $antinodes = $antenna->getAntinodesForAntenna($otherAntenna, $this->xMax, $this->yMax);
                    foreach ($antinodes as $antinode) {
                        if (!array_key_exists($antinode->getPosition(), $totalAntinodes)) {
                            $totalAntinodes[$antinode->getPosition()] = $antinode;
                        }
                    }
                }
            }
        }

        foreach($this->antennas as $antenna){
            if(!array_key_exists($antenna->getPosition(), $totalAntinodes)){
                $totalAntinodes[$antenna->getPosition()] = $antenna;
            }
        }
        return $totalAntinodes;
    }

    public function debug(): void
    {
        $grid = [];
        for ($y = 0; $y <= $this->yMax; $y++) {
            for ($x = 0; $x <= $this->xMax; $x++) {
                $grid[$y][$x] = '.';
            }
        }

        foreach ($this->getAntinodes() as $antinode) {
            $grid[$antinode->getY()][$antinode->getX()] = $antinode->getFrequency();
        }
        foreach ($this->antennas as $antenna) {
            $grid[$antenna->getY()][$antenna->getX()] = $antenna->getFrequency();
        }

        $str = '';
        foreach ($grid as $antennas) {
            $str .= implode("", $antennas) . "\n";
        }
        echo $str;
        file_put_contents(__DIR__ . '/debug.txt', $str);
    }
}