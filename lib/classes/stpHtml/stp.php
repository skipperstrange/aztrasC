<?

//takes an array and removes all empty value keys
/**
 *@abstract function that removes all empty keys in an array
 *@author skipper
 *@param array
 */
function stpArrayRemoveEmpty($arr)
{

	if(!is_array($arr)) {
		echo "Make sure the parameter is an array";
	}
	else {
		$arr = array_filter($arr);
	}
	return $arr;
}


//takes an array and removes all empty value keys
/**
 *@abstract function that removes all empty keys in an array and returns them in order
 * keys will be replaced by indexed keys
 *@author skipper
 *@param array
 */
function stpArrayRemoveEmptyOrder($arr)
{

	$arr = array_filter($arr);

	$newMy = array();
	$i = 0;

	foreach($arr as $key => $value) {
		if(!is_null($value)) {
			$newMy[$i] = $value;
			$i++;
		}
	}
	return $newMy;
}


require_once 'stpHtml.php';
require_once 'stpForms.php';
require_once 'stpTables.php';
