/*
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cu1723.de
 *
 * LastModified: 2017.03.27 at 21:51 MESZ
 */


interface SendData {
    "action": string,
}

import CuLoader from "./standards/CuLoader";
import $ from 'jquery';
import "bootbox";

export default class DBBackupManager {

    ajaxURL: string = "/ajax/ajax_db_backup.php";
    secret: string  = '';

    urlMySqlDumpFile: string = "";

    constructor(urlMySqlDumpFile, secret) {

        let dbBackup = this;

        this.secret           = secret;
        this.urlMySqlDumpFile = urlMySqlDumpFile;


        $(".hostmask_db_curserver_backup").on("click", function () {

            $('#hostmask_db_curserver_backup_info').show();

            CuLoader.show();

            dbBackup._createBackup();

        });

        $(".hostmask_db_curserver_backup_download").on("click", function () {

            $("#cu-iframe").attr('src', dbBackup.ajaxURL + "?action=DownloadBackupFile");


        });

        $(".hostmask_db_curserver_backup_delete").on("click", function () {

            bootbox.confirm('Are you sure?', function (data) {
                if (true === data) {
                    dbBackup._deleteFile();
                }
            });


        });


        $(".hostmask_db_curserver_backup_restore").on("click", function () {

            bootbox.confirm('Are you sure that you want to restore all Databases?', function (data) {

                if (true === data) {

                    dbBackup._restore();

                }
            });
        });
    }

    private static _reload() {
        document.location.href = "#";
    }

    private _deleteFile() {

        let callback = DBBackupManager._reload;

        let dataToSend = {

            action: "DeleteDbBackupFile"

        };

        // $.post(this.ajaxURL, dataToSend, function (data: AjaxResponseDeleteFile) {
        //
        //     let message       = "File Deleted";
        //     let classForAlert = "alert-warning";
        //
        //     if (data.hasError) {
        //         message       = 'Could not delete File. ' + data.errorMessage;
        //         classForAlert = 'danger';
        //     }
        //
        //     let messageBootbox = '<div class="alert alert-' +
        //                          classForAlert +
        //                          '">' +
        //                          message +
        //                          '</div>';
        //
        //     // bootbox.alert({message: messageBootbox, callback: callback});
        //
        // });

    }

    private _restore() {

        // CuLoader.show();

        let dataToSend = {
            action: "RestoreMySqlBackupIntoDataBase"
        };

        // $.post(this.ajaxURL, dataToSend, function (data: AjaxResponseRestoreDB) {
        //
        //     CuLoader.hide();
        //
        //     if (data.hasError === false) {
        //         bootbox.alert('Database updated - please restart mysql-server', DBBackupManager._reload);
        //     } else {
        //
        //         bootbox.alert('Could not restore Database: ' + data.errorMessage, DBBackupManager._reload);
        //     }
        //
        // });

    }

    private _createBackup() {

        let callback = DBBackupManager._reload;

        // let sendDataLocal: SendData = {
        //     action: "CreateMysqlBackup"
        // };

        // $.post(this.ajaxURL, sendDataLocal, function (data: AjaxResponseCreateMysqlBackup) {
        //
        //     console.log(data);
        //
        //     CuLoader.hide();
        //
        //     let message = "";
        //
        //     try {
        //
        //         if (data.hasError === false) {
        //
        //             message =
        //                 '<p>The file has been created in <div class="form-group"><input class="form-control input-alert-url" value="' +
        //                 data.fileUrl +
        //                 '" readonly /></div></p>';
        //
        //             bootbox.alert({message: message, callback: callback});
        //
        //         } else {
        //             message = '<p class="warning">Error creating Backupfile: </p><p>' +
        //                       data.errorMessage + "</p>";
        //
        //             bootbox.alert({
        //                               message:  message,
        //                               callback: callback
        //                           });
        //         }
        //     } catch (exception) {
        //
        //         alert(exception);
        //         console.log(exception);
        //
        //     }
        //
        // }, 'JSON').fail(function (data) {
        //     alert("Error getting AJAXResponse");
        //     console.log(data)
        // });

    }
}
