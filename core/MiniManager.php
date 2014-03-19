<?php

abstract class MiniManager {
	private $staffs = array();
	private $staff_type;
	
	public function __construct($staff_type) {
		$this->staffs = array();
		$this->staff_type = $staff_type;
	}

	public function handle(MiniRequest $request){
		$name = $this->get_staff_name($request);
		if($name){
			$staff = $this->get_staff($name);
			if($staff===null){
				throw new Exception("No registered class for '$name'");
			}
			return $this->handle_request($request, $staff);
		}else{
			return $this->handle_request($request, null);
		}
	}
	
	public function get_staff($name){
		$name = $this->normalize($name);
		if(!array_key_exists($name, $this->staffs)){
			return null;
		}else{
			return $this->staffs[$name];
		}
	}

	public function register_staff($name, $staff_class){
		$staff = new $staff_class();
		if(is_subclass_of($staff, $this->staff_type)){
			$name = $this->normalize($name);
			$this->staffs[$name] = $staff;
		}else{
			throw new Exception("Class '$staff_class' is not of type '$this->staff_type'");
		}
	}
	
	protected function normalize($name){
		return strtoupper($name);
	}
	
	protected abstract function get_staff_name(MiniRequest $request);
	protected abstract function handle_request(MiniRequest $request, $staff);
}
?>