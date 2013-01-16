<?PHP //$Id: block_use_stats.php,v 1.42.2.2 2007/05/31 00:00:00 fremaux Exp $

/**
 * This block needs to be reworked.
 * The new roles system does away with the concepts of rigid student and
 * teacher roles.
 */
class block_chronometer extends block_base {
    function init() {
        global $COURSE;
        if (isteacher($COURSE->id))
            $this->title = get_string('blockname','block_chronometer');
        else
            $this->title = get_string('blocknameforstudents','block_chronometer');
        $this->version = 2007090100;
    }

    /**
    * is the bloc configurable ?
    */
    function has_config() {
        return false;
    }
    
    /**
    * do we have local config
    */
    function instance_allow_config() {
        return false;
    }
    
    /**
    * check conditions for visibility
    */
    function is_empty(){
        
        $this->get_content();
        return(empty($this->content->text) && empty($this->content->footer));
    }

    /**
    *
    */
    function user_can_addto(&$page) {
        global $CFG, $COURSE;

        // guests never see anything
        if (isguest()) return false;

        if (!isteacher($COURSE->id)){
            if ($COURSE->id > 1){ // if not MyMoodle, students see something if a teacher allowed to
                if (!$this->config->studentscanuse){
                    return false;
                }
            }
            else{ // if MyMoodle students see something if they are allowed to by global config
                if (!$CFG->block_use_stats_studentscanuse){
                    return false;
                }
            }
        }
        return true;
    }

    /**
    *
    */
    function user_can_edit() {
        return false;
    }

    /**
    * Produce content for the bloc
    */
    function get_content() {
        global $USER, $CFG, $COURSE;
        
        if ($this->content !== NULL) {
            return $this->content;
        }

        $this->content = new stdClass;
        $this->content->text = '';
        $this->content->footer = '';
        
        if (empty($this->instance)) {
            return $this->content;
        }
        
        $this->content->text = implode('', file($CFG->dirroot.'/blocks/chronometer/chrono.html'));
        $this->content->text = str_replace('<%%STOP%%>', get_string('stop', 'block_chronometer'), $this->content->text );
        $this->content->text = str_replace('<%%START%%>', get_string('start', 'block_chronometer'), $this->content->text );
        $this->content->text = str_replace('<%%RESET%%>', get_string('reset', 'block_chronometer'), $this->content->text );
        $this->content->text = str_replace('<%%WWWROOT%%>', $CFG->wwwroot, $this->content->text );
        $this->content->text = str_replace('<%%LOADDOTMATRIX%%>', get_string('loaddotmatrix', 'block_chronometer'), $this->content->text );
        $this->content->text = str_replace('<%%DAYTAG%%>', get_string('daytag', 'block_chronometer'), $this->content->text );

        return $this->content;
    }
}

?>
