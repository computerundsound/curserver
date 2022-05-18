/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Date: 21.06.2014
 * Time: 04:38
 *
 * Created by IntelliJ IDEA
 *
 */

'use strict';

import $ from 'jquery';
import 'bootbox';
import 'bootstrap'

export default class HostTableManager {

    private inputStandardSubdomain = '';

    private inputStandardTld = $("meta[name=javascriptVariables][data-name=standardTLD]")
        .attr("data-value");

    private inputStandardIp                 = '127.0.0.1';
    private inputStandardVhostDir           = '';
    private inputStandardDomain             = '';
    private inputStandardVhostHtdocsRelativ = '/htdocs';

    constructor() {
        this.bindAddBtn();
    }

    private bindAddBtn = function () {
        let thiz = this;

        $('#hostmask_add_btn').on('click', function () {
            thiz.showAddMask();
        });
    };

    private showAddMask() {

        let hostDataArray = ['subdomain', 'domain', 'tld', 'ip', 'vhost_dir', 'vhost_htdocs', 'comment'];

        this.setInputsStandards();

        $('#hostmask_action_id').val('');

        $('#hostmask_action').val('host_add');
        $('#hostmask_headline').html('New Host');
        $('#hostmask_submit_btn').html('Insert');

        hostDataArray.forEach(function (element) { // jshint ignore:line
            $('#hostmask_' + element).val('');
        });

        this.setInputsStandards();

        $('#modal-mask-host-edit').modal('show');
    }

    private setInputsStandards() {

        var subdomain   = this.inputStandardSubdomain;
        var domain      = this.inputStandardDomain;
        var tld         = this.inputStandardTld;
        var ip          = this.inputStandardIp;
        var vhostDir    = this.inputStandardVhostDir;
        var vhostDirRel = this.inputStandardVhostHtdocsRelativ;

        $('[name="subdomain"]').val(subdomain);
        $('[name="domain"]').val(domain);
        $('[name="tld"]').val(tld);
        $('[name="ip"]').val(ip);
        // noinspection JSJQueryEfficiency
        $('[name="vhost_dir"]').val(vhostDir);
        $('[name="vhost_htdocs"]').val(vhostDir + vhostDirRel);

        // noinspection JSJQueryEfficiency
        $('[name="vhost_dir"]').blur(function () {
            var value = $(this).val();
            $('[name="vhost_htdocs"]').val(value + vhostDirRel);
        });

    };
}