<?php

namespace Day_8\Part_1;

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

    public function getAntinodes(): array
    {
        $antinodes = [];
        foreach ($this->frequencies as $frequency) {
            $antennas = $this->getAntennasWithFrequency($frequency);
            foreach ($antennas as $key => $antenna) {
                $othersAntennas = $antennas;
                unset($othersAntennas[$key]);
                foreach ($othersAntennas as $otherAntenna) {
                    $antinode = $antenna->getAntinodeForAntenna($otherAntenna);
                    if (0 <= $antinode->getX() && $antinode->getX() <= $this->xMax && 0 <= $antinode->getY(
                        ) && $antinode->getY() <= $this->yMax && !array_key_exists(
                            $antinode->getPosition(),
                            $antinodes,
                        )) {
                        $antinodes[$antinode->getPosition()] = $antinode;
                    }
                }
            }
        }
        return $antinodes;
    }
}