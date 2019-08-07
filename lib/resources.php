<?php
class Resources_Debt {
  function nicetime($unix_date) {
    if(empty($unix_date)) {
      return "No date provided";
    }

    $periods         = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
    $lengths         = array("60","60","24","7","4.35","12","10");
    $now             = time();

    if($now > $unix_date) {
      $difference     = $now - $unix_date;
      $tense         = "ago";
    } else {
      $difference     = $unix_date - $now;
      $tense         = "from now";
    }

    for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
      $difference /= $lengths[$j];
    }

    $difference = round($difference);

    if($difference != 1) {
      $periods[$j].= "s";
    }

    return "$difference $periods[$j] {$tense}";
  }

  function ownName($cadena) {
    $cadena=mb_convert_case($cadena, MB_CASE_TITLE, "utf8");
    return($cadena);
  }
}
?>