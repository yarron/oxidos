<?php defined('SYSPATH') or die('No direct script access.');

abstract class Kohana_Kohanalytics
{
	// Kohanalytics instance
	protected static $_instance;

	/**
	 * Singleton pattern
	 *
	 * @return Auth
	 */
	public static function instance()
	{
		
        if ( ! isset(Kohanalytics::$_instance))
		{
			// Load the configuration for this type
			$config = Kohana::$config->load('kohanalytics');
           
			// Create a new session instance
			Kohanalytics::$_instance = new Kohanalytics($config);
		}
	
		return Kohanalytics::$_instance;
	}

	protected $_config;
	protected $_gapi;

	/**
	 * Loads configuration options.
	 *
	 * @return  void
	 */
     
	public function __construct($config = array())
	{
	
        // Save the config in the object
		$this->_config = $config;
		
		// Load the GAPI http://code.google.com/p/gapi-google-analytics-php-interface/ library
		require MODPATH.'kohanalytics/vendor/gapi/gapi.class.php';
			
		$this->_gapi = new gapi($this->_config['username'], $this->_config['password']);
		
		// Set the default start and end dates. Maybe take this into config?
		$this->start_date = date('Y-m-d', strtotime('1 month ago'));
		$this->end_date   = date('Y-m-d');
	}

    /**
     * Statistics per day
     * 
     * @param string $start_date
     * @param string $end_date
     * @param mixed $metrics
     * @return array
     */
     
	public function daily_visit_count($start_date = FALSE, $end_date = FALSE, $metrics = array('pageviews', 'visits'))
	{
		if ( ! $start_date)
		{
			$start_date = date('Y-m-d', strtotime('1 day ago'));
		}

		if ( ! $end_date)
		{
			$end_date = date('Y-m-d');
		}

		// Work out the size for the container needed to hold the results, else we get results missed!
        $days = floor((strtotime($end_date) - strtotime($start_date)) / Date::DAY) + 2;

		$results = $this->_gapi->requestReportData($this->_config['report_id'], array('date'), $metrics, array('date'), NULL, $start_date, $end_date, 1, $days);
        
        return $results;
	}

    /**
     * Statistica per month
     * 
     * @param string $start_date
     * @param string $end_date
     * @param mixed $metrics
     * @return array
     */
	public function monthly_visit_count($start_date = FALSE, $end_date = FALSE, $metrics = array('pageviews', 'visits'))
	{
		
        if ( ! $start_date)
		{
			$start_date = date('Y-m-d', strtotime('first day of 6 months ago'));
		}
		
		if ( ! $end_date)
		{
			$end_date = date('Y-m-d', strtotime('last day of last month'));
		}
        
		// Work out the size for the container needed to hold the results, else we get results missed!
        $months = floor((strtotime($end_date) - strtotime($start_date)) / Date::MONTH) + 2;
		$results = $this->_gapi->requestReportData($this->_config['report_id'], array('month'), $metrics, array('-month'), NULL, $start_date, $end_date, 1, $months);
        krsort ($results);
        reset($results);
        return $results;
  
	}

    /**
     * Custom statistics
     * 
     * @param mixed $dimension
     * @param mixed $metrics
     * @param mixed $sort
     * @param mixed $max_results
     * @return array
     */
	public function query($dimension, array $metrics, $sort = NULL, $max_results = NULL)
	{
		if ( ! is_null($sort))
		{
			$sort = array($sort);
		}

		$results = $this->_gapi->requestReportData($this->_config['report_id'], array($dimension), $metrics, $sort, NULL, $this->start_date, $this->end_date, 1, $max_results);

		$data = array();
		foreach ($results as $r)
		{
            foreach ($metrics as $metric)
            {
			    $data[$r->{'get'.ucwords($dimension)}()][$metric] = $r->{'get'.ucwords($metric)}();
            }
		}

		return $data;
	}
    
}