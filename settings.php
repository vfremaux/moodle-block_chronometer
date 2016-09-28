<?php

$sizeoptions = array(
    'little' => get_string('little', 'block_chronometer'),
    'medium' => get_string('medium', 'block_chronometer'),
    'big' => get_string('big', 'block_chronometer')
);

$settings->add(new admin_setting_configselect('block_chronometer/fontsize', get_string('fontsize', 'block_chronometer'),
                   get_string('configfontsize', 'block_chronometer'), 'medium', $sizeoptions));

