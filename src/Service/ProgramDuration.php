<?php

namespace App\Service;

use App\Entity\Episode;
use App\Entity\Program;
use App\Repository\EpisodeRepository;
use App\Repository\ProgramRepository;

class ProgramDuration
{
    public function calculate(Program $program): string
    {
        $totalDuration = 0;

        foreach ($program->getSeasons() as $season) {
            foreach ($season->getEpisodes() as $episode) {
                $totalDuration += $episode->getDuration();
            }
        }
        $duration = '';

        $days = intdiv($totalDuration, 1440);
        $hours = intdiv(($totalDuration % 1440), 60);
        $minutes = $totalDuration % 60;


        if ($days > 0) {
            $duration .= $days . ' jour' . ($days > 1 ? 's' : '') . ' ';
        }

        if ($hours > 0) {
            $duration .= $hours . ' heure' . ($hours > 1 ? 's' : '') . ' ';
        }

        if ($minutes > 0) {
            $duration .= $minutes . ' minute' . ($minutes > 1 ? 's' : '');
        }

        return trim($duration);
    }
}
