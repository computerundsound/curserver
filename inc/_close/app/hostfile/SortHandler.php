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

namespace hostfile;

use computerundsound\culibrary\CuNet;

/**
 * Class SortHandler
 *
 * @package hostfile
 */
class SortHandler {

    private $akt_sort_item      = 'domain';
    private $akt_sort_direction = 'ASC';

    private $vari_name = 'sort_handler_array';


    /**
     * @param $p_name_appendix
     */
    public function __construct($p_name_appendix) {

        $this->vari_name .= $p_name_appendix;

        $akt_sort_array = CuNet::get_post_session($this->vari_name);

        /** array $akt_sort_array */
        if (!isset($akt_sort_array['item'])) {
            $akt_sort_array['item'] = 'domain';
        }

        if (!isset($akt_sort_array['direction'])) {
            $akt_sort_array['direction'] = 'ASC';
        }

        $_SESSION[$this->vari_name] = $akt_sort_array;

        $this->akt_sort_item      = $akt_sort_array['item'];
        $this->akt_sort_direction = $akt_sort_array['direction'];
    }


    /**
     * @return string
     */
    public function getAktSortDirection() {
        return $this->akt_sort_direction;
    }


    /**
     * @return string
     */
    public function getAktSortItem() {
        return $this->akt_sort_item;
    }


    /**
     * @return string
     */
    public function get_vari_name() {
        return $this->vari_name;
    }
}