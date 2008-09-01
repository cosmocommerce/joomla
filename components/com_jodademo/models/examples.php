<?php
/**
 * @version     $Id: controller.php 10786 2008-08-24 06:55:34Z plamendp $
 * @package     Joomla
 * @subpackage  Jodademo
 * @copyright   Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );

/**
 * Examples Model
 *
 * @package     Joomla
 * @subpackage  Jodademo
 */
class JodademoModelExamples extends JModel
{
    function Test1() { // Just building a simple query
        $dataset = JFactory::getDBSet();
        $qb = $dataset->getQueryBuilder();
        $qb->select('"#__1234"')->from("#__content");
        $result = $qb->getSQL();

        $text["explain"] = "Build a query";
        $text["result"] = $result;
        return $text;
    }

    function Test2() {  // Getting data from DB
        $dataset = JFactory::getDBSet();
        $qb = $dataset->getQueryBuilder();
        $qb->select(array("id","title"))->from("#__content");
        $dataset->addSQL($qb->getSQL());
        $dataset->open();
        $data = $dataset->fetchAll();
        $result = "";
        foreach ( $data as $row ) {
            $result .= $row["id"] . ":" . $row["title"] . "\n";
        }

        $text["explain"] = "Getting data from database";
        $text["result"] = $result;
        return $text;
    }


    function Test3() {
        $dataset = JFactory::getDBSet();
        $qb = $dataset->getQueryBuilder();
        $result = "";
        //$result = $qb->replaceString('select " plamen " #__plam"en " ""#__""test from me', "#__", "jos_");

        
        $s = "SELECT '#__field0', '#__field0', `field1`, \"field2\", 'field3\"plus\"' FROM #__TABLE";
        
        $q = "'";
        $nq = "`";
        
        $pattern = "/$q([^$q]*)$q/";
        
        $matches = array();
        $b = preg_match_all($pattern, $s, $matches);

        $result = $s . "\n" . $pattern."\n\n";
        if ($b) {
            $result .= "Result:\n\n";
            if ( is_array($matches) ) {
                $full = $matches[0];
                $subs_count = count($matches) - 1;
                
                $result .= "Full:\n";
                foreach ($full as $match) {
                    $result .= $match . "\n"; 
                }
                if ( $subs_count > 0 ) {
                    $result .= "\n\nSub patterns:\n";
                    for ($i = 1; $i <= $subs_count; $i++ ) {
                        $submatches = $matches[$i];
                        $result .= "\n$i:\n";
                        foreach ( $submatches as $match ){
                            $result .= $match . "\n"; 
                        }
                    }
                }
            }
        }
        
        $text["explain"] = "REGEX";
        $text["result"] = $result;
        return $text;
    }








    function Tests() {
    	$max_tests = 100;

        $texts = array();
    	for ($i=1; $i<=100; $i++) {
    		$method = "test" . "$i";
            if ( method_exists($this, $method) ) {
            	$texts["t$i"] = $this->$method();
            }
    	}
        return $texts;
    }

}