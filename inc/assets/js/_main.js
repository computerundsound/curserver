/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Date: 21.06.2014
 * Time: 04:31
 *
 * Created by IntelliJ IDEA
 *
 * Filename: _main.js
 */

/*global HostTableManager:false, $ */

var host_table_manager_coo = {};

$(document).ready(function () {
    'use strict';
    host_table_manager_coo = new HostTableManager();

    var $hostFileContent = $('textarea[name=hostfile_content]');

    $hostFileContent.on('click', function () {
        this.select();
    });

});