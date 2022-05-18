import $ from 'jquery';
import "popper.js";
import {Modal} from "bootstrap";
import axios from "axios";

export default class HostManager {

    public listen() {

        let modalHostDelete = new Modal(document.getElementById('modal_ask_delete_host'));
        let modalHostEdit   = new Modal(document.getElementById('modal_edit_host'));

        let $tableData = $(".useTableData");

        $("[data-modal-host_ask_delete=true]").on("click", function () {
            let hostId = $("[name=modal_ask_delete_host_id]").val();

            axios.get('/ajax/html_content/delete_host/' + hostId).then(function (response) {

                location.reload();
            });
        });

        $tableData.on('click', '[data-action=kill_host]', function () {
            let hostName = $(this).attr('data-host_name');
            let hostId   = $(this).attr('data-host_id');
            $('#modal_ask_delete_host_hostname').html(hostName);
            $("[name=modal_ask_delete_host_id]").val(hostId);
            modalHostDelete.show();
        });

        $tableData.on('click', '[data-action=edit_host]', function () {
            let hostName = $(this).attr('data-host_name');
            let hostId   = $(this).attr('data-host_id');

            axios.get('/ajax/html_content/edit_host/' + hostId).then(function (response) {
                console.log(response);

                $('#modal_edit_host_content').html(response.data);

                modalHostEdit.show();
            });
        });

        $("[data-action='create_host']").on('click', function () {
            let hostName = $(this).attr('data-host_name');

            axios.get('/ajax/html_content/create_host').then(function (response) {
                console.log(response);

                $('#modal_edit_host_content').html(response.data);

                modalHostEdit.show();
            });

        });

    }
}