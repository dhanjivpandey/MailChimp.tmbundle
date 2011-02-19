<?php

/**
* Config
*
* load up any needed configs
* save any needed configs
*
* Using phpini files
*
*/
class mConfig {
    
    var $ini_path = null;

    //These get set on load of the .ini file.
    var $api_key = null;
    var $campaign_id = null;

    function __construct($path) {

        if(!file_exists($path)) {
            trigger_error("Missing config file: {$path}");
            exit();
        }
        
        $this->ini_path = $path;
        $this->load();
    }
    
    
    /**
     * Write the .ini back
     *
     * @return void
     **/
    public function save() {
        $to_write = array('api_key', 'campaign_id');
        $output = '';
        foreach ($to_write as $key) {
            $output.= $this->_ini_line($key, $this->{$key}, true);
        }
        
        file_put_contents($this->ini_path, $output);
        
    }
    
	/**
	 * undocumented function
	 *
	 * @return string
	 **/
	function _ini_line($key, $value, $newline = false) {

		$line = trim($key).'="'. str_replace('"', '&quot;', $value) .'"';

		if($newline) {
			$line .= "\n";
		}

		return $line;
	}
    
    
    /**
     * Load the config file
     *
     * @return void
     **/
    public function load() {
        $settings = parse_ini_file($this->ini_path);
        foreach ($settings as $key => $value) {
            $this->{$key} = $value;
        }
    }

}
