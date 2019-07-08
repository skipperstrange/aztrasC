<?php


/*This loader loads adaptors in th root adaptor folder. much more convinient if 
* adaptor is located in the root. system responds faster
*/
function loadAdaptor($adaptor)
{
	$file = ADAPTORS_PATH . $adaptor . '.ad';
	if(file_exists($file)) {
		require_once ($file);
	}
	else {
		echo "adaptor does not exist. Use autoloadAdaptor($adaptor) instead";
	}
}

//This loader loads adaptors in th root adaptor folder ie lib/adaptors/SQL/.
function loadSQLAdaptor($adaptor)
{
	$file = ADAPTORS_PATH . 'SQL' . DS . $adaptor . '.ad';

	if(file_exists($file)) {
		require_once ($file);
	}
	else {
		echo "adaptor does not exist. Use autoloadAdaptor($adaptor) instead";
	}

}


//This loader loads adaptors in th root adaptor folder ie lib/adaptors/SQL/.
function loadHelperAdaptor($adaptor)
{
	$file = ADAPTORS_PATH . 'Helper' . DS . $adaptor . '.ad';

	if(file_exists($file)) {
		require_once ($file);
	}
	else {
		echo "adaptor does not exist. Use autoloadAdaptor($adaptor) instead";
	}

}



//This loader loads adaptors in th root adaptor folder ie lib/adaptors/Socket/.
function loadSocketAdaptor($adaptor)
{
	$file = ADAPTORS_PATH . 'Socket' . DS . $adaptor . '.ad';

	if(file_exists($file)) {
		require_once ($file);
	}
	else {
		echo "adaptor does not exist. Use autoloadAdaptor($adaptor) instead";
	}

}

/*This loader loads adaptors in th root adaptor folder. much more convinient if 
* you don not know whaer the adaptor is located in the root.system responds reliable
* but could cause lag in load time
*/
function autoLoadAdaptor($adaptor)
{

	$file = ADAPTORS_PATH.$adaptor . '.ad';
	$found = false;
	$dir = FileSystem::getDirectories(ADAPTORS_PATH);
	if(file_exists($file)) {
		require_once ($file);
        $found = true;
	}
	else {

		foreach($dir as $d) {
			$file = ADAPTORS_PATH . $d . DS . $adaptor . '.ad';
			if(file_exists($file)) {
				require_once ($file);
				$found = true;
			}
		}
	}
	if($found == false) {
		echo "<h3 style=\"margin-bottom:0px;\">The adaptor $adaptor does not exists. Available Adaptors</h3>";
		foreach($dir as $d):
			echo "<h4 style=\"font-size:13px; margin-bottom:0px;\">$d</h4>";
			if($dirfound = FileSystem::scanDirectory(ADAPTORS_PATH . $d . DS)) {
				for($i = 0; $i < count($dirfound); $i++)
					echo "<span style=\"font-size:13px;\">" . str_replace('.ad', '', $dirfound[$i]) .
						", </span>";
			}
			else {
				echo "<span style=\"font-size:13px;\">No adaptors available here </span>";
			}
			echo "<hr />";
		endforeach;
	}
}