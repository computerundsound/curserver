<?php
/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Date: 15.06.2014
 * Time: 23:43
 *
 * Created by IntelliJ IDEA
 *
 * Filename: index.php
 */


if (version_compare('5.5', PHP_VERSION, '>')) {
    include __DIR__ . '/hostlister4.php';
} else {
    include __DIR__ . '/hostlister5.php';
}