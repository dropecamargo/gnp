<?php 

class SessionCart 
{
	public static function addItem($item) {
		Session::push($item['key'], $item);
		return SessionCart::show($item['key'],$item['template']);
	}

	public static function show($key, $template) {
		$list = Session::get($key);
		return View::make($template)->with('list', $list)->render();	
	} 
}