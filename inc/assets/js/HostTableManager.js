/**
 * Copyright by Jörg Wrase - www.Computer-Und-Sound.de
 * Date: 21.06.2014
 * Time: 04:38
 *
 * Created by IntelliJ IDEA
 *
 */
'use strict';
/*jshint globalstrict: true*/
/*jshint bitwise:true, curly:true, eqeqeq:true, forin:true, noarg:true, noempty:true, nonew:true, undef:true, strict:true, browser:true */

/*global $:false, alert:false, confirm:false, prompt:false, bootbox: false, document:true */


function HostTableManager() {
    this.bind_click_show_edit();
    this.bind_update_btn();
    this.bind_kill_btn();
    this.bind_add_btn();
    this.bind_prozess_btns();
}

HostTableManager.prototype.input_standard_subdomain = '';
HostTableManager.prototype.input_standard_tld = $(
    "meta[name=javascriptVariables][data-name=standardTLD]")
    .attr("data-value");
HostTableManager.prototype.input_standard_ip = '127.0.0.1';
HostTableManager.prototype.input_standard_vhost_dir = 'd:/_SERVER/_SELF';
HostTableManager.prototype.input_standard_domain = '';
HostTableManager.prototype.input_standard_vhost_htdocs_relativ = '/htdocs';

HostTableManager.prototype.bind_add_btn = function () {
    var thiz = this;

    $('#hostmask_add_btn').click(function () {
        thiz.show_add_mask();
    });
};

HostTableManager.prototype.bind_click_show_edit = function () {
    var thiz = this;
    var host_data_array;

    $('[data-action="edit_host"]').click(function () {
        var id = $(this).attr('data-action_id');

        $.post("/inc/ajax/ajax_get_host_datas.php", {action: 'load_host', action_id: id}, function (data) {
            try {
                host_data_array = $.parseJSON(data);
            } catch (e) {

                bootbox.alert(e.message);
            }
            thiz.show_edit_mask(host_data_array);
        })

         .fail(function () {
             alert("error");
         });

    });

};


HostTableManager.prototype.bind_kill_btn = function () {
    $("[data-action='kill_host']").click(function () {

        var action_id = $(this).attr('data-action_id');
        var host_name = $(this).attr('data-host_name');
        var confirm_msg = 'Do you want to remove Host <strong>' + host_name + '</strong>?';

        bootbox.confirm(confirm_msg, function (data) {
            if (data === true) {
                document.form_host_action.action.value = 'host_kill';
                document.form_host_action.action_id.value = action_id;
                document.form_host_action.submit();
            }
        });

    });
};

HostTableManager.prototype.bind_update_btn = function () {
    $('.host_action_btn').click(function () {
        document.form_host_data.submit();
    });
};

HostTableManager.prototype.show_edit_mask = function (host_data) {

    for (var key in host_data) { // jshint ignore:line
        $('#hostmask_' + key).val(host_data[key]);
    }

    var id = host_data.id;

    $('#hostmask_action').val('host_update');

    $('#hostmask_action_id').val(id);
    $('#hostmask_headline').html('Edit Host');
    $('#hostmask_submit_btn').html('Update');

    $('#modal-mask-host-edit').modal('show');

};

HostTableManager.prototype.show_add_mask = function () {

    var host_data_array = ['subdomain', 'domain', 'tld', 'ip', 'vhost_dir', 'vhost_htdocs', 'comment'];

    this.set_inputs_standards();

    $('#hostmask_action_id').val('');

    $('#hostmask_action').val('host_add');
    $('#hostmask_headline').html('New Host');
    $('#hostmask_submit_btn').html('Insert');

    host_data_array.forEach(function (element) { // jshint ignore:line
        $('#hostmask_' + element).val('');
    });

    this.set_inputs_standards();

    $('#modal-mask-host-edit').modal('show');
};

HostTableManager.prototype.bind_prozess_btns = function () {
    $('#hostmask_process_vhostfile_btn').click(function () {
        document.form_host_action.action.value = 'host_prozess_vhostfile';
        document.form_host_action.submit();
    });
    $('#hostmask_process_hostfile_btn').click(function () {
        document.form_host_action.action.value = 'host_prozess_hostfile';
        document.form_host_action.submit();
    });
};

HostTableManager.prototype.set_inputs_standards = function () {

    var subdomain = this.input_standard_subdomain;
    var domain = this.input_standard_domain;
    var tld = this.input_standard_tld;
    var ip = this.input_standard_ip;
    var vhost_dir = this.input_standard_vhost_dir;
    var vhost_dir_rel = this.input_standard_vhost_htdocs_relativ;

    $('[name="subdomain"]').val(subdomain);
    $('[name="domain"]').val(domain);
    $('[name="tld"]').val(tld);
    $('[name="ip"]').val(ip);
    // noinspection JSJQueryEfficiency
    $('[name="vhost_dir"]').val(vhost_dir);
    $('[name="vhost_htdocs"]').val(vhost_dir + vhost_dir_rel);

    // noinspection JSJQueryEfficiency
    $('[name="vhost_dir"]').blur(function () {
        var value = $(this).val();
        $('[name="vhost_htdocs"]').val(value + vhost_dir_rel);
    });


};