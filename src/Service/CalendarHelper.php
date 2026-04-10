<?php

namespace App\Service;

class CalendarHelper
{
    /**
     * Custom week number calculation.
     * Rule: The week containing January 1st (Monday to Sunday) is always Week 1.
     * This follows the user's request where 29 déc. 2025 – 4 janv. 2026 is Week 01.
     */
    public static function getCustomWeekNumber(\DateTimeInterface $date): int
    {
        $d = \DateTime::createFromInterface($date);
        
        // Find the Monday of the current week (normalized to 00:00:00)
        $mondayOfCurrentWeek = (clone $d)->modify('monday this week')->setTime(0, 0, 0);
        
        // Find the Sunday of the current week to determine the "effective" year
        // If a week overlaps, the year of its final day (Sunday) wins for numbering
        $sundayOfCurrentWeek = (clone $mondayOfCurrentWeek)->modify('+6 days');
        $year = (int)$sundayOfCurrentWeek->format('Y');
        
        // Find the Monday of the week containing January 1st of that year
        $jan1 = new \DateTime($year . '-01-01');
        $mondayOfW1 = (clone $jan1)->modify('monday this week')->setTime(0, 0, 0);
        
        // Calculate weeks difference
        $daysDiff = $mondayOfCurrentWeek->getTimestamp() - $mondayOfW1->getTimestamp();
        $weeksDiff = (int)round($daysDiff / (7 * 86400));
        
        return 1 + $weeksDiff;
    }

    /**
     * Get the year associated with the week of a date.
     * Usually matches the Sunday's year for year-overlapping weeks.
     */
    public static function getCustomYearForWeek(\DateTimeInterface $date): int
    {
        $d = \DateTime::createFromInterface($date);
        $sundayOfCurrentWeek = (clone $d)->modify('monday this week')->modify('+6 days');
        return (int)$sundayOfCurrentWeek->format('Y');
    }

    /**
     * Get French public holidays for a given year.
     * Returns an array [ 'YYYY-MM-DD' => 'Holiday Name' ]
     */
    public static function getHolidays(int $year): array
    {
        $easterDays = easter_days($year);
        $easterDate = new \DateTime("$year-03-21");
        $easterDate->modify("+$easterDays days");

        $holidays = [
            // Fixed dates
            "$year-01-01" => "Jour de l'An",
            "$year-05-01" => "Fête du Travail",
            "$year-05-08" => "Victoire 1945",
            "$year-07-14" => "Fête Nationale",
            "$year-08-15" => "Assomption",
            "$year-11-01" => "Toussaint",
            "$year-11-11" => "Armistice 1918",
            "$year-12-25" => "Noël",
        ];

        // Moving dates (related to Easter)
        $lundiPaques = (clone $easterDate)->modify('+1 day');
        $ascension = (clone $easterDate)->modify('+39 days');
        $lundiPentecote = (clone $easterDate)->modify('+50 days');

        $holidays[$lundiPaques->format('Y-m-d')] = "Lundi de Pâques";
        $holidays[$ascension->format('Y-m-d')] = "Ascension";
        $holidays[$lundiPentecote->format('Y-m-d')] = "Lundi de Pentecôte";

        ksort($holidays);
        return $holidays;
    }
}
