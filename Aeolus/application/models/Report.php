<?php
class Application_Model_Report
{
	protected $average_duration;
	protected $minimum_duration;
	protected $maximum_duration;
	protected $duration_sd;
	protected $number_of_open_incidents;
	protected $number_of_closed_incidents;
	protected $incidents_pr_personnel;
	
	public function __set($name, $value)
	{
		$this->$name = $value;
	}
	public function __get($name)
	{
		return $this->$name;
	}
}