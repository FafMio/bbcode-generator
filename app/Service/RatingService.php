<?php

class RatingService
{

    public function __construct() {}

    /**
     * Convert number 0-10 to stars
     *
     * @param $count
     * @return string
     */
    public function getStars($count) :string
    {
        $note = "00";

        if($count > 1) $note = "05";
        if($count > 2) $note = "10";
        if($count > 3) $note = "15";
        if($count > 4) $note = "20";
        if($count > 5) $note = "25";
        if($count > 6) $note = "30";
        if($count > 7) $note = "35";
        if($count > 8) $note = "40";
        if($count > 9) $note = "45";
        if($count > 10) $note = "50";

        return "https://static.hephe.net/images/note/$note.png";
    }
}