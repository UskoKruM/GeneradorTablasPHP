<?php

function hace_cuanto($wFecha1, $wFecha2 = NULL) {
    $fecha1 = new Datetime($wFecha1);
    if (!$wFecha2) {
        $fecha2 = new Datetime('now');
    } else {
        $fecha2 = new Datetime($wFecha2);
    }
    if ($fecha1 > $fecha2)
        return;
    // $r_str = array();
    $intervalo = $fecha1->diff($fecha2);
    $diff = $intervalo->format('%ya-%mm-%dd-%hh-%ii-%ss');
    preg_match_all("/[1-9]+[a-z]+/", $diff, $match_diff);
    $time_str = array('a' => 'año',
        'm' => 'mes',
        'd' => 'día',
        'h' => 'hora',
        'i' => 'minuto',
        's' => 'segundo'
    );
    foreach ($match_diff[0] as $time) {
        $times = intval($time);
        $index_time = str_replace($times, '', $time);
        $string = $time_str[$index_time];
        $string .= $time > 1 ? ($string === 'mes' ? 'es' : 's' ) : '';
        $r_str[] = sprintf('%d %s', $time, $string);
    }
    $ult = end($r_str);
    $prev = prev($r_str);
    $r_str = array_reduce($r_str, function($r, $v) use($prev, $ult, $r_str) {
        if (count($r_str) > 1) {
            $v = $prev === $v ? sprintf('%s ', $v) : ($ult === $v ? sprintf('y %s', $v) : sprintf('%s, ', $v));
        }
        $r .= $v;
        return $r;
    });
    return $r_str;
}
