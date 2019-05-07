<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Date: 02.07.2014
 * Time: 21:54
 *
 * Created by IntelliJ IDEA
 *
 * Filename: SortHandler.php
 */

namespace app\hostfile;

use computerundsound\culibrary\CuRequester;

/**
 * Class SortHandler
 *
 * @package app\hostfile
 */
class SortHandler
{

    private $currentSortItem;
    private $currentSortDirection;

    private $variableName = 'sort_handler_array';


    /**
     * @param $p_name_appendix
     */
    public function __construct($p_name_appendix)
    {

        $this->variableName .= $p_name_appendix;

        $akt_sort_array = CuRequester::getGetPostSession($this->variableName);

        /** array $akt_sort_array */
        if (!isset($akt_sort_array['item'])) {
            $akt_sort_array['item'] = 'domain';
        }

        if (!isset($akt_sort_array['direction'])) {
            $akt_sort_array['direction'] = 'ASC';
        }

        $_SESSION[$this->variableName] = $akt_sort_array;

        $this->currentSortItem      = $akt_sort_array['item'];
        $this->currentSortDirection = $akt_sort_array['direction'];
    }


    /**
     * @return string
     */
    public function getCurrentSortDirection()
    {

        return $this->currentSortDirection;
    }


    /**
     * @return string
     */
    public function getCurrentSortItem()
    {

        return $this->currentSortItem;
    }


    /**
     * @return string
     */
    public function getVariableName()
    {

        return $this->variableName;
    }
}