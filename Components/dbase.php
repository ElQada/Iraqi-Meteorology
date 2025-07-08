<?php

set_time_limit (0);
// site_path defined by parent
require_once "dbase_handler.php";

/* DBase (dbf)
 *    manage dbf files, exports and search functionality
 *    with buildin optimizers for fast performance
 */

class DBase
{
    private $handler = false;
    private $searchopt = array (); // Search optimizer

    private function unload ()
    {
        if ($this-> handler !== false)
            unset ($this-> handler);
    }

    public function __construct ($file = false)
    {
        if ($file !== false)
            $this-> load ($file);
    }

    public function __destruct ()
    {
        $this-> unload ();
    }

    public function load ($file)
    {
        $resource = dbase_open ($file, 0);
        $this-> handler = new DBase_Handler ($resource);

        return $this-> handler;
    }

    /* Search
     *    search for string inside header
     *    returns record number
     *        false returned if not found or error occurred
     *    limit_results gets int or false, limit_results equels one will limit the
     *        search results for one result only, false for no limit
     */
    public function search ($headerText, $string, $limit_results = false, $handler = false)
    {
        if ($handler === false)
            $handler = $this-> handler;

        if ($this-> searchopt [$headerText][$string])
            return $this-> searchopt [$headerText][$string];
        else
        {
            $size = $handler-> getSize ();
            if ( ( $headerNumber = $handler-> getHeaderNumber ($headerText) ) !== false)
            {
                $results = array ();
                for ($i = 1; $i < $size; $i++)
                {
                    $record = $handler-> getRecord ($i, false); // Disabled optimizer to prevent memory overflow
                    if (trim ($record [$headerNumber]) == $string)
                    {
                        $results[] = $i;

                        if ( ($limit_results !== false) && (sizeof ($results) == $limit_results) )
                            break;
                    }
                }

                if (sizeof ($results) > 0)
                {
                    $this-> searchopt [$headerText][$string] = $results;
                    return $this-> search ($headerText, $string, $handler);
                }

                return false;
            } else
                return false;
        }
    }
}