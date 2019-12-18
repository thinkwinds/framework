<?php
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Libraries;

use Cache;

class ThinkwindsWidget
{

	/**
	 * List of all widgets set in config/widget.php
	 *
	 * @var	array
	 */
	protected $widgets = [];

	/**
	 * Array with class objects to use widgets methods
	 *
	 * @var array
	 */
	protected $_objects = [];

	/**
	 * In progress flag
	 *
	 * Determines whether widget is in progress, used to prevent infinte loops
	 *
	 * @var	bool
	 */
	protected $_in_progress = FALSE;
	protected $returns =	[];
	/**
	 * Class constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
	    $widget = Cache::get('widgetInject');
		$this->widgets =& $widget;
	}

	public function call_widget($which = '', $params = null, $isreturn = FALSE) 
	{
		if ( ! isset($this->widgets[$which])) 
		{
			if($isreturn) 
			{
				return $params;
			}
			return FALSE;
		}
		if (is_array($this->widgets[$which]) && ! isset($this->widgets[$which]['function'])) 
		{
			foreach ($this->widgets[$which] as $key=>$val)
			{
				$this->_run_widget($val, $which, $params, $isreturn);
			}
		} else {
			$this->_run_widget($this->widgets[$which], $which, $params, $isreturn);
		}
		if($isreturn) 
		{
			return isset($this->returns[$which]) ? $this->returns[$which] : $params;
		}
		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Run Widget
	 *
	 * Runs a particular widget
	 *
	 * @param	array	$data	Widget details
	 * @return	bool	TRUE on success or FALSE on failure
	 */
	protected function _run_widget($data, $which = '', $params = [])
	{
		if (is_callable($data)) 
		{
			is_array($data) ? $data[0]->{$data[1]}() : $data();
			return TRUE;
		} elseif ( ! is_array($data)) 
		{
			return FALSE;
		}

		if ($this->_in_progress === TRUE) 
		{
			return;
		}
		if(!isset($data['files']) || !$data['files']) 
		{
			$data['files'] = 'Thinkwinds\Framework\Widget';
		}
		if ( !isset($data['files']) ) 
		{
			return false;
		}
		$class		= empty($data['class']) ? FALSE : $data['class'];
		$function	= empty($data['fun']) ? FALSE : $data['fun'];
		if ($class === FALSE AND $function === FALSE) 
		{
			return false;
		}
		$_params = '';
		if (isset($data['params']) && !$params) 
		{
			$_params = $data['params'];
		}  else  {
			$_params = $params;
		}
		$this->_in_progress = TRUE;
		if(isset($this->returns[$which])) 
		{
			$_params = $this->returns[$which];
		}
		if ($class !== FALSE) 
		{
			$widgetClass = self::widget_class($data['files'], $data['class']);
			if(!class_exists($widgetClass)) 
			{
				return TRUE;
			}
			if (isset($this->_objects[$class])) 
			{
				if (method_exists($this->_objects[$class], $function)) 
				{
					$widget_return = $this->_objects[$class]->$function($_params);
				} else {
					return $this->_in_progress = FALSE;
				}
			} else {
				if ( ! method_exists($widgetClass, $function)) 
				{
					return $this->_in_progress = FALSE;
				}
				$this->_objects[$class] = new $widgetClass();
				$widget_return = $this->_objects[$class]->$function($_params);
			}
		} else {
			$widgetFunction = self::widget_function($data['files']);
			require base_path($widgetFunction);
			if ( ! function_exists($function)) 
			{
				return $this->_in_progress = FALSE;
			}
			$widget_return = $function($_params);
		}
		$this->returns[$which] = $widget_return;
		$this->_in_progress = FALSE;
		return TRUE;
	}
    
    /**
     * Return the full path to the given  class.
     *
     * @param  string  $class
     * @return string
     */
    protected function widget_class($namespace, $class)
    {
        return "{$namespace}\\{$class}";
    }

    protected function widget_function($files)
    {
        return "{$files}.php";
    }
}
