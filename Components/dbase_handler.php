<?php
/* DBase Handler (dbf)
 *    handles dbase resource
 */

class DBase_Handler
{
    private $resource;
    private $size; // Records Count
    private $header = array ();
    private $dataopt = array (); // Data optimizer

    private function setHeader ()
    {
        $this-> header = dbase_get_header_info ($this-> resource);
    }

    public function __construct ($resource)
    {
        $this-> resource = $resource;
        $this-> setHeader ();
        $this-> size = dbase_numrecords ($this-> resource);
    }

    public function __destruct ()
    {
        dbase_close ($this-> resource);
    }

    public function getRecord ($record_number, $dataopt = true)
    {
        if ($record_number > $this-> size)
            return false;
        else
        {
            if ($this-> dataopt [$record_number])
                return $this-> dataopt [$record_number];
            else
            {
                $record = dbase_get_record ($this-> resource, $record_number);
                if ($dataopt === true) // Data saving optimizer
                {
                    $this-> dataopt [$record_number] = $record;
                    return $this-> getRecord ($record_number);
                } else
                    return $record;
            }
        }
    }

    public function getHeaderNumber ($headerText)
    {
        foreach ($this-> header as $index => $header)
        {
            if ($header ['name'] == $headerText)
            {
                return $index;
                break;
            }
        }

        return false;
    }

    public function getHeader ($headerNumber)
    {
        if ($headerNumber <= sizeof ($this-> header))
            return $this-> header [$headerNumber];
        else
            return false;
    }

    public function getSize ()
    {
        return $this-> size;
    }
}