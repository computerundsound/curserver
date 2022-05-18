/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
import $ from 'jquery';
import "popper.js";
import "bootstrap";
import 'datatables.net';
import CuLoader from "./js/standards/CuLoader";

import './js/TableManager';
import HostManager from "./js/HostManager";
import axios from "axios";
import Swal from 'sweetalert2';

$(function () {
    let $hostFileContentLabel: JQuery<HTMLElement>;
    let $hostFileContent: JQuery<HTMLElement>;

    CuLoader.hide();
    $('.useTableData').DataTable();

    $hostFileContent      = $('textarea[name=hostfile_content]');
    $hostFileContentLabel = $("label[for=hostfile_content]");

    $hostFileContentLabel.on('click', function () {
        $hostFileContent.select();
    });

    let ajaxURL = $("[name=javaScriptVariables][data-name=mysqlFileURL]").attr("data-value");
    let secret  = $("[name=javaScriptVariables][data-name=secret]").attr("data-value");

    // let dBBackup    = new DBBackupManager(ajaxURL, secret);
    let hostManager = new HostManager();

    hostManager.listen();

    $("[data-action='write_vhost_files']").on('click', function () {

        Swal.fire({
                      title:             'Write updated VHost-files?',
                      text:              "You won't be able to revert this!",
                      icon:              'question',
                      showCancelButton:  true,
                      confirmButtonText: 'Yes, update!',
                  }).then((result) => {
            if (result.isConfirmed) {

                axios.post('/ajax/write_vhost_files').then(function (response) {
                    console.log(response);

                    Swal.fire('Jep');

                });
            }
        })
    });

    $("[data-action='new_include_hostfile_apache']").on('click', function () {

        Swal.fire({
                      title:             'Update includes in "apache/conf/extra/httpd-vhosts.conf?',
                      text:              "You won't be able to revert this!",
                      icon:              'question',
                      showCancelButton:  true,
                      confirmButtonText: 'Yes, update!',
                  }).then((result) => {
            if (result.isConfirmed) {

                axios.post('/ajax/update_apache_include_vhosts').then(function (response) {
                    console.log(response);

                    Swal.fire('Jep');

                });


            }
        })
    });

    $("[data-form_submit]").on("click", function () {
        let formName = $(this).attr('data-form_submit');
        $("form[name='" + formName + "']").submit();
    });


});