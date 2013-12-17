<?php

if(!defined('DATE_CALC_BEGIN_WEEKDAY')) {
define('DATE_CALC_BEGIN_WEEKDAY', 0);
}

function getDisplayTime( $db_time )
{
	if( $db_time == '00:00:00' || $db_time == NULL )
	{
		return ' TBA ';
	}
	else
	{	
		$AMPM = 'AM';
		$hour = substr($db_time,0,2);
		$min  = substr($db_time,3,2);
		if( $hour > 11 )
		{
			$AMPM = 'PM';
			if( $hour > 12 )
			{
				$hour = $hour - 12;
			}
		}			
		return ( $hour . ':' . $min . ' ' . $AMPM );
	}

}

function getDisplayDate( $db_date )
{
	// %B = full month name, %d = day number, %Y = full year
	// i.e. January 01, 2007
	if( $db_date == '0000-00-00' || $db_date == NULL )
	{
		return ' ';
	}
	else
	{
		$temp = new shsDate(substr($db_date,8,2), substr($db_date,5,2), substr($db_date,0,4));
		return $temp->dateFormat(substr($db_date,8,2), substr($db_date,5,2), substr($db_date,0,4), "%B %d, %Y");
	}
	
}

// shsDate class is based on the UNIX timestamp and supporting functions in PHP

// notes:  the following is already available in PHP

// getdate
// get current date info 
// year
// mon (numeric)
// month (name)
// mday (numeric day of the month)
// weekday (week day name)
// wday (numeric day of the week, sunday=0)
// hours
// minutes
// seconds

// class that wraps and suppliments PHP date functions
class shsDate
{

	var $dateArray;
	var $dateStamp;

//	static $instances = 0;
  //  public $instance;
	//public function __construct() {
      // $this->instance = ++self::$instances;
    //}

	// initializes date with current date
    function shsDate($day="", $month="", $year="")
    {
		if( empty($day) || empty($month) || empty($year) )
		{
			$this->dateArray = getdate();
			$day   = $dateArray['mday'];
			$month = $dateArray['mon'];
			$year  = $dateArray['year'];
		}
		shsDate::shsSetDate($day, $month, $year);
    } 
	function shsSetDate($dd, $mm, $yyyy)
	{
		$this->dateStamp = mktime(0,0,0, $mm, $dd, $yyyy);
		$this->dateArray = getdate($this->dateStamp);
	}

	function isValid()
	{
		return isValidDate( $dateArray['mday'], $dateArray['mon'], $dateArray['year']);
	}
		
    function isValidDate($day, $month, $year)
    {
        if($year < 0 || $year > 9999) {
            return false;
        }
        if(!checkdate($month,$day,$year)) {
            return false;
        }

        return true;
    } 

    function isLeapYear($year="")
    {
        if(strlen($year) != 4) {
            $year = $dateArray['year'];
        }

        if(preg_match("/\D/",$year)) {
            return false;
        }

        return (($year % 4 == 0 && $year % 100 != 0) || $year % 400 == 0);
    }

	// return numeric week day
    function dayOfWeek()
    {
   		return $this->dateArray['wday'];
    } 

    function weekOfYear($day="",$month="",$year="")
    {
	   if(empty($year) || empty($month) || empty($day) ) {
	   		$day   = $dateArray['mday'];
			$month = $dateArray['mon'];
			$year  = $dateArray['year'];
       }

        $week_year = $year - 1501;
        $week_day = $week_year * 365 + floor($week_year / 4) - 29872 + 1
            - floor($week_year / 100) + floor(($week_year - 300) / 400);

        $week_number = ceil((shsDate::julianDate($day,$month,$year)
            + floor(($week_day + 4) % 7)) / 7);

        return $week_number;
    } 

    // Returns number of days since 31 December of year before given date.
    function julianDate($day="",$month="",$year="")
    {
	   if(empty($year) || empty($month) || empty($day) ) {
	   		$day   = $dateArray['mday'];
			$month = $dateArray['mon'];
			$year  = $dateArray['year'];
       }

        $days = array(0,31,59,90,120,151,181,212,243,273,304,334);

        $julian = ($days[$month - 1] + $day);

        if($month > 2 && shsDate::isLeapYear($year)) {
            $julian++;
        }

        return($julian);
    } 

    function quarterOfYear($day="",$month="",$year="")
    {
	   if(empty($year) || empty($month) || empty($day) ) {
	   		$day   = $dateArray['mday'];
			$month = $dateArray['mon'];
			$year  = $dateArray['year'];
       }
		
        $year_quarter = (intval(($month - 1) / 3 + 1));

        return $year_quarter;
    } 
	
	
	// Returns date of begin of next month of given date.
    function beginOfNextMonth($day="",$month="",$year="",$format="%Y%m%d")
    {
  	   if(empty($year) || empty($month) || empty($day) ) {
	   		$day   = $dateArray['mday'];
			$month = $dateArray['mon'];
			$year  = $dateArray['year'];
       }

        if($month < 12) {
            $month++;
            $day=1;
        } else {
            $year++;
            $month=1;
            $day=1;
        }

        return shsDate::dateFormat($day,$month,$year,$format);
    } 

    // Returns date of the last day of next month of given date.
    function endOfNextMonth($day="",$month="",$year="",$format="%Y%m%d")
    {
	   if(empty($year) || empty($month) || empty($day) ) {
	   		$day   = $dateArray['mday'];
			$month = $dateArray['mon'];
			$year  = $dateArray['year'];
       }

        if($month < 12) {
            $month++;
        } else {
            $year++;
            $month=1;
        }

        $day = shsDate::daysInMonth($month,$year);

        return shsDate::dateFormat($day,$month,$year,$format);
    } 

    // Returns date of the first day of previous month of given date.
    function beginOfPrevMonth($day="",$month="",$year="",$format="%Y%m%d")
    {
	   if(empty($year) || empty($month) || empty($day) ) {
	   		$day   = $dateArray['mday'];
			$month = $dateArray['mon'];
			$year  = $dateArray['year'];
       }

        if($month > 1) {
            $month--;
            $day=1;
        } else {
            $year--;
            $month=12;
            $day=1;
        }

        return shsDate::dateFormat($day,$month,$year,$format);
    } 


    function nextWeekday($day="",$month="",$year="",$format="%Y%m%d")
    {
	   if(empty($year) || empty($month) || empty($day) ) {
	   		$day   = $dateArray['mday'];
			$month = $dateArray['mon'];
			$year  = $dateArray['year'];
       }

        $days = shsDate::dateToDays($day,$month,$year);

        if(shsDate::dayOfWeek($day,$month,$year) == 5) {
            $days += 3;
        } elseif(shsDate::dayOfWeek($day,$month,$year) == 6) {
            $days += 2;
        } else {
            $days += 1;
        }

        return(shsDate::daysToDate($days,$format));
    } 

    function prevWeekday($day="",$month="",$year="",$format="%Y%m%d")
    {
	   if(empty($year) || empty($month) || empty($day) ) {
	   		$day   = $dateArray['mday'];
			$month = $dateArray['mon'];
			$year  = $dateArray['year'];
       }

        $days = shsDate::dateToDays($day,$month,$year);

        if(shsDate::dayOfWeek($day,$month,$year) == 1) {
            $days -= 3;
        } elseif(shsDate::dayOfWeek($day,$month,$year) == 0) { 
            $days -= 2;
        } else {
            $days -= 1;
        }

        return(shsDate::daysToDate($days,$format));
    }
	
    function nextDayOfWeek($dow,$day='',$month="",$year="",$format="%Y%m%d",$onOrAfter=false)
    {
	   if(empty($year) || empty($month) || empty($day) ) {
	   		$day   = $dateArray['mday'];
			$month = $dateArray['mon'];
			$year  = $dateArray['year'];
       }

        $days = shsDate::dateToDays($day,$month,$year);
        $curr_weekday = shsDate::dayOfWeek($day,$month,$year);

        if($curr_weekday == $dow) {
            if(!$onOrAfter) {
                $days += 7;
            }
        }
        elseif($curr_weekday > $dow) {
            $days += 7 - ( $curr_weekday - $dow );
        } else {
            $days += $dow - $curr_weekday;
        }

        return(shsDate::daysToDate($days,$format));
    }
	
	
    function prevDayOfWeek($dow,$day="",$month="",$year="",$format="%Y%m%d",$onOrBefore=false)
    {
	   if(empty($year) || empty($month) || empty($day) ) {
	   		$day   = $dateArray['mday'];
			$month = $dateArray['mon'];
			$year  = $dateArray['year'];
       }

        $days = shsDate::dateToDays($day,$month,$year);
        $curr_weekday = shsDate::dayOfWeek($day,$month,$year);

        if($curr_weekday == $dow) {
            if(!$onOrBefore) {
                $days -= 7;
            }
        }
        elseif($curr_weekday < $dow) {
            $days -= 7 - ( $dow - $curr_weekday );
        } else {
            $days -= $curr_weekday - $dow;
        }

        return(shsDate::daysToDate($days,$format));
    }
	
    function nextDayOfWeekOnOrAfter($dow,$day="",$month="",$year="",$format="%Y%m%d")
    {
        return(shsDate::nextDayOfWeek($dow,$day="",$month="",$year="",$format="%Y%m%d",true));
    } 
	
    function prevDayOfWeekOnOrBefore($dow,$day="",$month="",$year="",$format="%Y%m%d")
    {
        return(shsDate::prevDayOfWeek($dow,$day="",$month="",$year="",$format="%Y%m%d",true));
    } 

    function nextDay($day="",$month="",$year="",$format="%Y%m%d")
    {
	   if(empty($year) || empty($month) || empty($day) ) {
	   		$day   = $dateArray['mday'];
			$month = $dateArray['mon'];
			$year  = $dateArray['year'];
       }

        $days = shsDate::dateToDays($day,$month,$year);

        return(shsDate::daysToDate($days + 1,$format));
    } 
	
    function prevDay($day="",$month="",$year="",$format="%Y%m%d")
    {
	   if(empty($year) || empty($month) || empty($day) ) {
	   		$day   = $dateArray['mday'];
			$month = $dateArray['mon'];
			$year  = $dateArray['year'];
       }

        $days = shsDate::dateToDays($day,$month,$year);

        return(shsDate::daysToDate($days - 1,$format));
    } 

    function nextWeek($day="",$month="",$year="",$format="%Y%m%d")
    {
	   if(empty($year) || empty($month) || empty($day) ) {
	   		$day   = $dateArray['mday'];
			$month = $dateArray['mon'];
			$year  = $dateArray['year'];
       }

        $days = shsDate::dateToDays($day,$month,$year);

        return(shsDate::daysToDate($days + 7,$format));
    } 
	
    function prevWeek($day="",$month="",$year="",$format="%Y%m%d")
    {
	   if(empty($year) || empty($month) || empty($day) ) {
	   		$day   = $dateArray['mday'];
			$month = $dateArray['mon'];
			$year  = $dateArray['year'];
       }

        $days = shsDate::dateToDays($day,$month,$year);

        return(shsDate::daysToDate($days - 7,$format));
    } 

    function dateDiff($day1,$month1,$year1,$day2,$month2,$year2)
    {
        if(!shsDate::isValidDate($day1,$month1,$year1)) {
            return -1;
        }
        if(!shsDate::isValidDate($day2,$month2,$year2)) {
            return -1;
        }

        return(abs((shsDate::dateToDays($day1,$month1,$year1))
                    - (shsDate::dateToDays($day2,$month2,$year2))));
    } 
	
	// return int 0 on equality, 1 if date 1 is greater, -1 if smaller
    function compareDates($day1,$month1,$year1,$day2,$month2,$year2)
    {
        $ndays1 = shsDate::dateToDays($day1, $month1, $year1);
        $ndays2 = shsDate::dateToDays($day2, $month2, $year2);
        if ($ndays1 == $ndays2) {
            return 0;
        }
        return ($ndays1 > $ndays2) ? 1 : -1;
    } 

    function daysInMonth($month="",$year="")
    {
	   if(empty($year) || empty($month) || empty($day) ) {
	   		$day   = $dateArray['mday'];
			$month = $dateArray['mon'];
			$year  = $dateArray['year'];
       }

        if($month == 2) {
            if(shsDate::isLeapYear($year)) {
                return 29;
             } else {
                return 28;
            }
        } elseif($month == 4 or $month == 6 or $month == 9 or $month == 11) {
            return 30;
        } else {
            return 31;
        }
    } 

    // Returns the number of rows on a calendar month
    function weeksInMonth($month="",$year="")
    {
	   if(empty($year) || empty($month) || empty($day) ) {
	   		$day   = $dateArray['mday'];
			$month = $dateArray['mon'];
			$year  = $dateArray['year'];
       }

        if(DATE_CALC_BEGIN_WEEKDAY == 1) {
            if(shsDate::firstOfMonthWeekday($month,$year) == 0) {
                $first_week_days = 1;
            } else {
                $first_week_days =
                    7 - (shsDate::firstOfMonthWeekday($month,$year) - 1);
            }
        } else {
            $first_week_days = 7 - shsDate::firstOfMonthWeekday($month,$year);
        }

        return ceil(((shsDate::daysInMonth($month,$year) - $first_week_days) / 7) + 1);
    } 

    // Find the day of the week for the first of the month of given date.
    function firstOfMonthWeekday($month="",$year="")
    {
	   if(empty($year) || empty($month) || empty($day) ) {
	   		$day   = $dateArray['mday'];
			$month = $dateArray['mon'];
			$year  = $dateArray['year'];
       }

        return(shsDate::dayOfWeek("01",$month,$year));
    } 

    // Return date of first day of month of given date.
    function beginOfMonth($month="",$year="",$format="%Y%m%d")
    {
	   if(empty($year) || empty($month) || empty($day) ) {
	   		$day   = $dateArray['mday'];
			$month = $dateArray['mon'];
			$year  = $dateArray['year'];
       }

        return(shsDate::dateFormat("01",$month,$year,$format));
    } 

    // Find the month day of the beginning of week for given date,
    function beginOfWeek($day="",$month="",$year="",$format="%Y%m%d")
    {
	   if(empty($year) || empty($month) || empty($day) ) {
	   		$day   = $dateArray['mday'];
			$month = $dateArray['mon'];
			$year  = $dateArray['year'];
       }

        $this_weekday = shsDate::dayOfWeek($day,$month,$year);

        if(DATE_CALC_BEGIN_WEEKDAY == 1) {
            if($this_weekday == 0) {
                $beginOfWeek = shsDate::dateToDays($day,$month,$year) - 6;
            } else {
                $beginOfWeek = shsDate::dateToDays($day,$month,$year)
                    - $this_weekday + 1;
            }
        } else {
                $beginOfWeek = (shsDate::dateToDays($day,$month,$year)
                    - $this_weekday);
        }

        return(shsDate::daysToDate($beginOfWeek,$format));
    } 

    // Find the month day of the end of week for given date,
    function endOfWeek($day="",$month="",$year="",$format="%Y%m%d")
    {
	   if(empty($year) || empty($month) || empty($day) ) {
	   		$day   = $dateArray['mday'];
			$month = $dateArray['mon'];
			$year  = $dateArray['year'];
       }

        $this_weekday = shsDate::dayOfWeek($day,$month,$year);

        $last_dayOfWeek = (shsDate::dateToDays($day,$month,$year)
            + (6 - $this_weekday + DATE_CALC_BEGIN_WEEKDAY));

        return(shsDate::daysToDate($last_dayOfWeek,$format));
    } 

    // Converts a date to number of days since a distant unspecified epoch.
    function dateToDays($day="",$month="",$year="")
    {
	   if(empty($year) || empty($month) || empty($day) ) {
	   		$day   = $dateArray['mday'];
			$month = $dateArray['mon'];
			$year  = $dateArray['year'];
       }

        $century = (int) substr($year,0,2);
        $year = (int) substr($year,2,2);

        if($month > 2) {
            $month -= 3;
        } else {
            $month += 9;
            if($year) {
                $year--;
            } else {
                $year = 99;
                $century --;
            }
        }

        return (floor(( 146097 * $century) / 4 ) +
            floor(( 1461 * $year) / 4 ) +
            floor(( 153 * $month + 2) / 5 ) +
            $day + 1721119);
    }

    // Converts number of days to a distant unspecified epoch.
    function daysToDate($days,$format="%Y%m%d")
    {

        $days       -=  1721119;
        $century    =   floor(( 4 * $days - 1) / 146097);
        $days       =   floor(4 * $days - 1 - 146097 * $century);
        $day        =   floor($days / 4);

        $year       =   floor(( 4 * $day +  3) / 1461);
        $day        =   floor(4 * $day +  3 - 1461 * $year);
        $day        =   floor(($day +  4) / 4);

        $month      =   floor(( 5 * $day - 3) / 153);
        $day        =   floor(5 * $day - 3 - 153 * $month);
        $day        =   floor(($day +  5) /  5);

        if($month < 10) {
            $month +=3;
        } else {
            $month -=9;
            if($year++ == 99) {
                $year = 0;
                $century++;
            }
        }

        $century = sprintf("%02d",$century);
        $year = sprintf("%02d",$year);
        return(shsDate::dateFormat($day,$month,$century.$year,$format));
    } 
	
    //  Formats the date in the given format, much like
    //  strfmt(). 
    /*
     *  formatting options:
     *
     *  %a        abbreviated weekday name (Sun, Mon, Tue)
     *  %A        full weekday name (Sunday, Monday, Tuesday)
     *  %b        abbreviated month name (Jan, Feb, Mar)
     *  %B        full month name (January, February, March)
     *  %d        day of month (range 00 to 31)
     *  %e        day of month, single digit (range 0 to 31)
     *  %E        number of days since unspecified epoch (integer)
     *             (%E is useful for passing a date in a URL as
     *             an integer value. Then simply use
     *             daysToDate() to convert back to a date.)
     *  %j        day of year (range 001 to 366)
     *  %m        month as decimal number (range 1 to 12)
     *  %n        newline character (\n)
     *  %t        tab character (\t)
     *  %w        weekday as decimal (0 = Sunday)
     *  %U        week number of current year, first sunday as first week
     *  %y        year as decimal (range 00 to 99)
     *  %Y        year as decimal including century (range 0000 to 9999)
     *  %%        literal '%'
     */
    function dateFormat($day="",$month="",$year="",$format)
    {
	   if(empty($year) || empty($month) || empty($day) ) {
	   		$day   = $dateArray['mday'];
			$month = $dateArray['mon'];
			$year  = $dateArray['year'];
       }

        if(!shsDate::isValidDate($day,$month,$year)) {
			$output .= 'invalid date (mm dd yyyy): ' . $month . ' ' . $day . ' ' . $year; 
        }
		else
		{
			$output = "";
	
			for($strpos = 0; $strpos < strlen($format); $strpos++) {
				$char = substr($format,$strpos,1);
				if($char == "%") {
					$nextchar = substr($format,$strpos + 1,1);
					switch($nextchar) {
						case "a":
							$output .= shsDate::getWeekdayAbbrname($day,$month,$year);
							break;
						case "A":
							$output .= shsDate::getWeekdayFullname($day,$month,$year);
							break;
						case "b":
							$output .= shsDate::getMonthAbbrname($month);
							break;
						case "B":
							$output .= shsDate::getMonthFullname($month);
							break;
						case "d":
							$output .= sprintf("%02d",$day);
							break;
						case "e":
							$output .= $day;
							break;
						case "E":
							$output .= shsDate::dateToDays($day,$month,$year);
							break;
						case "j":
							$output .= shsDate::julianDate($day,$month,$year);
							break;
						case "m":
							$output .= sprintf("%02d",$month);
							break;
						case "n":
							$output .= "\n";
							break;
						case "t":
							$output .= "\t";
							break;
						case "w":
							$output .= shsDate::dayOfWeek($day,$month,$year);
							break;
						case "U":
							$output .= shsDate::weekOfYear($day,$month,$year);
							break;
						case "y":
							$output .= substr($year,2,2);
							break;
						case "Y":
							$output .= $year;
							break;
						case "%":
							$output .= "%";
							break;
						default:
							$output .= $char.$nextchar;
					}
					$strpos++;
				} else {
					$output .= $char;
				}
			}
		}
        return $output;
    } 

    function getYear()
    {
        return $this->dateArray['year'];
    }

    function getMonth()
    {
        return $this->dateArray['mon'];
    } 

    function getDay()
    {
        return $this->dateArray['mday'];
    }

    function getMonthFullname()
    {
        return $this->dateArray['month'];
    } 

    function getMonthAbbrname($length=3)
    {
        return substr($this->getMonthFullname(), 0, $length);
    } 

    function getWeekdayFullname()
    {
        return $this->dateArray['weekday'];
    } 

    function getWeekdayAbbrname($length=3)
    {
        return substr(getWeekdayFullname(0,$length));
    } 

} 
?>