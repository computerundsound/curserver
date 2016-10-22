<?php
/*
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Date: 12.09.2015
 * Time: 03:34
 * 
 * Created by IntelliJ IDEA
 *
 */

namespace hostfile;


/**
 * Class VHostFileList
 *
 * @package hostfile
 */
class VHostFileList {

	protected $vhostsList = [];

	/**
	 * @param \hostfile\VHostFileHandler $vHostFileHandler
	 */
	public function add(VHostFileHandler $vHostFileHandler) {
		$this->vhostsList[] = $vHostFileHandler;
	}

	/**
	 *
	 */
	public function reset() {
		reset($this->vhostsList);
	}

	/**
	 *
	 */
	public function clear() {
		$this->vhostsList = [];
	}

	/**
	 * @return array
	 */
	public function getListAsArray() {
		return $this->vhostsList;
	}

	/**
	 * @return mixed
	 */
	public function getNext() {
		$vHost = next($this->vhostsList);

		return $vHost;
	}
}