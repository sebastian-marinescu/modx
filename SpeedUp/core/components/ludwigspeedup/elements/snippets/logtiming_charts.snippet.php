<?php
/**
 * ludwigspeedup_logtiming
 * Copyright 2014 by Thomas Ludwig <thomas@ludwig.im>
 *
 * ludwigspeedup_logtiming is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option) any
 * later version.
 *
 * ludwigspeedup_logtiming is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * ludwigspeedup_logtiming; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
 * Suite 330, Boston, MA 02111-1307 USA
 *
 * @package ludwigspeedup
 */
/**
 * ludwigspeedup_logtiming
 *
 * Analyze Modx Speed
 *
 * @version 1.0
 * @author Thomas Ludwig <thomas@ludwig.im>
 * @copyright Copyright &copy; 2014
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License
 *          version 2 or (at your option) any later version for ludwigspeedup sourcecode
 * @package ludwigspeedup
 *         
 */
$PKG_NAME= 'LudwigSpeedUp';
$PKG_NAME_LOWER= strtolower( $PKG_NAME );

// Variables
$output = '';

// Check if package is installed and activated
$ldpath = MODX_CORE_PATH.'components/'. $PKG_NAME_LOWER .'/model/';
if(!$modx->addPackage($pak, $ldpath, $PKG_NAME_LOWER))
{
	return;

// Package is added
} else {

	$query = "	SELECT (   SELECT AVG(total_time)
				FROM   modx.ludwigspeedup_logtimings
				WHERE  from_modx_cache = 0
				) average_nocache,
				(
					SELECT AVG(total_time)
					FROM   modx.ludwigspeedup_logtimings
					WHERE  from_modx_cache = 1
				) average_cache,
				(
					SELECT AVG(total_time)
					FROM   modx.ludwigspeedup_logtimings
					WHERE  from_plugin_cache = 1
				) average_plugincache
				FROM modx.ludwigspeedup_logtimings LIMIT 1";
	
	$res = $modx->query( $query );
	if (is_object($res))
	{
 		$row = $res->fetch(PDO::FETCH_ASSOC);
		var_dump($row,true);
		exit();
	}	
	
	$data = array();
	for( $i = 0; $i < count( $tv_ary["memory_peak"] ); $i++  )
	{
		$n = $i + 1;
		$data[] = "[ $n," . $tv_ary["total_queries_time"][$i] . ',' . $tv_ary["total_parse_time"][$i] . ',' . $tv_ary["total"][$i] . " ]";
	}
	
	$output = $modx->getChunk( 'logtiming_charts', array(
		'data' => implode( ', ', $data ), 
		'legend' => "", 
		'vAxis.title' => "'Time [s]'", 
		'hAxis.title' => "'Measured Values'"
	) );
}

return ( $output );