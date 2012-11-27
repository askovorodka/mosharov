<?php 

class a
{
	public $count=0;
	function count()
	{
		return $this->count++;
	}
}


$a = new a();

$i = $a->count();

echo $i;

$i = $a->count();

echo $i;

$b=$a;

$i=$b->count();

echo $i;

?>