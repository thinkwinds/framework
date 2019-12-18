<?php 
/**
 * @author thinkwinds <info@thinkwinds.com>
 * @copyright ©2020-2021 thinkwinds.com
 * @license http://www.thinkwinds.com
 */
namespace Thinkwinds\Framework\Libraries;

use Cache;

class ThinkwindsCall 
{

	public $objects = [];
    public $isadmin = false;

	public function getCallModule($module = '') 
	{
		$modules = [
			'system'	=> [
				'path'=>'Thinkwinds\Framework\Libraries\Call',
				'name'=>'系统模型'
			]
		];
		$modules = thinkwinds_widget('s_call_model', $modules, true);
		return $module ? (isset($modules[$module]) ? $modules[$module] : []) : $modules;
	}

    public function getCallType($type = '') 
    {
        $types = [
            'html'    => [
                'module'=>'system',
                'name'=>'自定义html'
            ]
        ];
        $types = thinkwinds_widget('s_call_model_type', $types, true);
        return $type ? (isset($types[$type]) ? $types[$type] : []) : $types;
    }

	/**
	 * 获取类别对象
	 *
	 * @return  object
	 */
    public function get($module = '', $type = '')
    {
        if (!$module || strpos($module, '.') !== FALSE) 
        {
            return NULL;
        }
        if (!$type || strpos($type, '.') !== FALSE) 
        {
            return NULL;
        }
        $modelInfo = $this->getCallModule($module);
        if (!$modelInfo) 
        {
            return NULL;
        }
		$class = ucfirst($type);
		$files = $modelInfo['path'];
		$fieldClass = $this->field_class($files, $class);
		if(!class_exists($fieldClass)) 
        {
            return NULL;
		}
		if (isset($this->objects[$class])) 
        {
			return $this->objects[$class];
		} else {
			return $this->objects[$class] = new $fieldClass();
		}
	}
    
    /**
     * Return the full path to the given  class.
     *
     * @param  string  $class
     * @return string
     */
    protected function field_class($namespace, $class)
    {
        return "{$namespace}\\{$class}";
    }
}