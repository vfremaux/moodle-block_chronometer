<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

defined('MOODLE_INTERNAL') || die();

class block_chronometer_renderer extends plugin_renderer_base {

    function chronometer($controlpanel, $loaddotmatrix, $time) {
        $str = '';

        $str .= '<script type="text/javascript">';
        $str .= "
            var s = {$time->seconds};
            var m = {$time->minutes};
            var h = {$time->hours};
            var j = {$time->days};
            var daytag = '".get_string('daytag', 'block_chronometer')."';
        ";

        $config = get_config('block_chronometer');

        $fontsizeclass = 'font-size-'.$config->fontsize;

        $str .= '</script>';
        $str .= '<form action="" method="post" name="chronometerForm" id="chronometerForm">';
        $str .= $controlpanel;
        $str .= '<p align="center">';
        $str .= '<span id="chrono-display" class="chronometer fontsforweb_fontid_1091 '.$fontsizeclass.'">0 '.get_string('daytag', 'block_chronometer').' 00:00:00 / 0</span><br /><br />';
        $str .= '<span id="chrono-display-sec" class="chronometer fontsforweb_fontid_1091 '.$fontsizeclass.'">0 / 0 sec</span> (total)';
        $str .= '</p>';
        $fonturl = new moodle_url('/blocks/chronometer/fonts/dotmatrx.ttf');
        $str .= '<a href="'.$fonturl.'" target="_blank" style="font-size : smaller">'.$loaddotmatrix.'</a>';
        $str .= '</form>';

        return $str;
    }
}