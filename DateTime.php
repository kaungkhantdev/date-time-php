<?php

class JDateTimeHelper
{
    /**
     * Set the default timezone to UTC
     */
    public function __construct() {
        date_default_timezone_set('UTC');
    }

    /**
     * Date Time Formats
     */
    protected $defaultDateTimeFormat = "Y-m-d H:i:s"; // It is MySQL DateTime format

    protected $dateTimeFormatForUI = "d-M-Y g:i A";
    protected $dateFormatForUI = "d-M-Y";
    protected $timeFormatForUI = "g:i A";

    /**
     * Convert Timezone Offset Value to Seconds
     *
     * $timezoneOffsetValue must be float values
     * such as +6.5, +8.0, -5.0 with (+/-) sign
     *
     * @param float     $timezoneOffsetValue
     * @return float
     */
    public function convertTimezoneOffsetToSeconds($timezoneOffsetValue)
    {
        return $timezoneOffsetValue * 3600;
    }

    /**
     * Convert Datetime with specific Timezone Offset to Unix Timestamp
     * $dateTime format is "Y-m-d H:i:s"
     *
     * $timezoneOffset
     *     - It is the timezone of $dateTime
     *     - It must be float values
     *       such as +6.5, +8.0, -5.0 with (+/-) sign
     *
     * @param string    $dateTimeValue
     * @param float     $timezoneOffset
     * @return float
     */
    public function convertDateTimeToUnixTimestamp($dateTimeValue, $timezoneOffset)
    {
        $datetimeToTimestamp    = floatval(strtotime($dateTimeValue));
        $convertTimestamp       = $this->convertTimezoneOffsetToSeconds($timezoneOffset);

        return $datetimeToTimestamp - $convertTimestamp;
    }

    /**
     * Get current Date Time in UTC+0
     * Example Return Value : "2023-06-23 02:25:37"
     * format is "Y-m-d H:i:s"
     *
     * @return string
     */
    public function getCurrentDateTimeInUTC()
    {
        $timestamp = time();
        return gmdate($this->defaultDateTimeFormat, $timestamp);
    }

    /**
     * Get Differences between 2 date time values in Seconds
     *
     * $timezoneOffset1 is the Timezone Offset of $dateTimeValue1
     * $timezoneOffset2 is the Timezone Offset of $dateTimeValue2
     *
     * @param string    $dateTimeValue1
     * @param float     $timezoneOffset1
     * @param string    $dateTimeValue2
     * @param float     $timezoneOffset2
     * @return float
     */
    public function getDateTimeDiffInSec($dateTimeValue1,$timezoneOffset1,
                                            $dateTimeValue2,$timezoneOffset2)
    {
        $first  = $this->convertDateTimeToUnixTimestamp($dateTimeValue1, $timezoneOffset1);
        $second = $this->convertDateTimeToUnixTimestamp($dateTimeValue2, $timezoneOffset2);

        return $second - $first ;
    }

    /**
     * Convert Seconds to Days
     *
     * @param integer $second
     */
    public function convertSecondsToDays($second)
    {
        $minute = $second / 60;
        $hour = $minute / 60;
        $day = $hour / 24;
        return $day;
    }

    /**
     * Get Formatted Date for UI
     * $dateTimeValue must be in default format "Y-m-d H:i:s"
     * return format "d-M-Y"
     *
     * @param string $dateTimeValue
     */
    public function getFormattedDateForUI($dateTimeValue)
    {
        return $this->dateTimeFormatter($dateTimeValue,
                                            $this->defaultDateTimeFormat,
                                            $this->dateFormatForUI);
    }

    /**
     * Get Formatted Time for UI
     * $dateTimeValue must be in default format "Y-m-d H:i:s"
     * return format "H:i A"
     *
     * @param string $dateTimeValue
     */
    public function getFormattedTimeForUI($dateTimeValue)
    {
        return $this->dateTimeFormatter($dateTimeValue,
                                            $this->defaultDateTimeFormat,
                                            $this->timeFormatForUI);
    }

    /**
     * Get Formatted Date Time for UI
     * $dateTimeValue must be in default format "Y-m-d H:i:s"
     * return format "d-M-Y H:i A"
     *
     * @param string $dateTimeValue
     */
    public function getFormattedDateTimeForUI($dateTimeValue)
    {
        return $this->dateTimeFormatter($dateTimeValue,
                                            $this->defaultDateTimeFormat,
                                            $this->dateTimeFormatForUI);
    }

    /**
     * Function to format DateTime value
     * from "Source Format" to "Destination Format"
     *
     * @param string $dateTimeValue
     * @param string $sourceFormat
     * @param string $destinationFormat
     */
    public function dateTimeFormatter($dateTimeValue,$sourceFormat,$destinationFormat){
        $tempDateTimeValue = date_create_from_format($sourceFormat, $dateTimeValue);
        return date_format($tempDateTimeValue,$destinationFormat);
    }

    /**
     * Timezone name explode
     * @TODO What to explode? Need example values.
     *
     * @param string $explode_key
     * @param string $timezone_name
     */
    public function explodeMysqlTimezoneName( $timezone_name, $explode_key)
    {
        $string = $timezone_name;
        return explode($explode_key, $string);
    }
}