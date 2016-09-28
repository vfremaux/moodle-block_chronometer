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

class block_chronometer extends block_base {

    function init() {
        global $PAGE;
        $this->title = get_string('pluginname', 'block_chronometer');
        $PAGE->requires->js('/blocks/chronometer/js/chronometer.js');
        try {
            $PAGE->requires->css('/blocks/chronometer/fonts/font.css');
        } catch (Exception $e) {
        }
    }

    /**
    * is the bloc configurable ?
    */
    function has_config() {
        return true;
    }

    /**
    * is the bloc configurable ?
    */
    function instance_allow_multiple() {
        return false;
    }

    /**
    * do we have local config
    */
    function instance_allow_config() {
        return true;
    }

    /**
    * check conditions for visibility
    */
    function is_empty(){
        $this->get_content();
        return(empty($this->content->text) && empty($this->content->footer));
    }

    /**
     * Produce content for the bloc
     */
    function get_content() {
        global $USER, $CFG, $COURSE, $DB, $PAGE;

        $timespent = $DB->get_record('block_chronometer', array('courseid' => $COURSE->id, 'userid' => $USER->id));

        if (!$timespent) {
            if (empty($this->time)) {
                $this->time = new StdClass;
                $this->time->seconds = 0;
                $this->time->minutes = 0;
                $this->time->hours = 0;
                $this->time->days = 0;
            }
        } else {
            $this->time->seconds = $timespent % 60;
            $remains = $timespent - $this->time->seconds;
            $this->time->minutes = $remains % 3600;
            $remains = $remains - $this->time->minutes;
            $this->time->hours = $remains % DAYSECS;
            $remains = $remains - $this->time->hours;
            $this->time->days = $remains;
        }

        $context = context_block::instance($this->instance->id);

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass;
        $this->content->text = '';
        $this->content->footer = '';

        if (empty($this->instance)) {
            return $this->content;
        }

        $start = get_string('start', 'block_chronometer');
        $stop = get_string('stop', 'block_chronometer');
        $reset = get_string('reset', 'block_chronometer');
        if (has_capability('block/chronometer:hascontrol', $context)) {
            $controlpanel = "
              <p align=\"center\">
                <input type=\"button\" name=\"Submit\" value=\"{$start}\" onClick=\"startChronometer();\" />
                <input type=\"button\" name=\"Submit2\" value=\"{$stop}\" onClick=\"stopChronometer();\" />
                <input type=\"button\" name=\"Submit3\" value=\"{$reset}\" onClick=\"resetChronometer();\" />
              </p>";
        } else {
            $controlpanel = '';
        }
        $loaddotmatrix = get_string('loaddotmatrix', 'block_chronometer');

        $renderer = $PAGE->get_renderer('block_chronometer');
        $this->content->text = $renderer->chronometer($controlpanel, $loaddotmatrix, $this->time);

        return $this->content;
    }
}

