<?php
	class Math extends CI_Model{
		public function add($a,$b){
			return $a+$b;
		}
		public function sub($a,$b){
			return $a-$b;
		}
	}
?>