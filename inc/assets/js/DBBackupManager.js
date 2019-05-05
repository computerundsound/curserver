"use strict";
/*
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2017.03.27 at 21:51 MESZ
 */
Object.defineProperty(exports, "__esModule", { value: true });
///<reference path="../dts/jquery.d.ts" />
///<reference path="../dts/bootbox.d.ts" />
///<reference path="Interfaces/IAjaxResponse.ts" />
///<reference path="Interfaces/IAjaxResponse.ts" />
var CuLoader_1 = require("./CuLoader");
var DBBackupManager = /** @class */ (function () {
    function DBBackupManager(urlMySqlDumpFile, secret) {
        this.ajaxURL = "/inc/ajax/ajax_db_backup.php";
        this.secret = '';
        this.urlMySqlDumpFile = "";
        var dbBackup = this;
        this.secret = secret;
        this.urlMySqlDumpFile = urlMySqlDumpFile;
        $(".hostmask_db_curserver_backup").on("click", function () {
            $('#hostmask_db_curserver_backup_info').show();
            CuLoader_1.CuLoader.show();
            dbBackup._createBackup();
        });
        $(".hostmask_db_curserver_backup_download").on("click", function () {
            $("#cu-iframe").attr('src', dbBackup.ajaxURL + "?action=DownloadBackupFile");
        });
        $(".hostmask_db_curserver_backup_delete").on("click", function () {
            bootbox.confirm('Are you sure?', function (data) {
                if (data === true) {
                    dbBackup._deleteFile();
                }
            });
        });
        $(".hostmask_db_curserver_backup_restore").on("click", function () {
            bootbox.confirm('Are you sure that you want to restore all Databases?', function (data) {
                if (data === true) {
                    dbBackup._restore();
                }
            });
        });
    }
    DBBackupManager._reload = function () {
        document.location.href = "#";
    };
    DBBackupManager.prototype._deleteFile = function () {
        var callback = DBBackupManager._reload;
        var dataToSend = {
            action: "DeleteDbBackupFile"
        };
        $.post(this.ajaxURL, dataToSend, function (data) {
            var message = "File Deleted";
            var classForAlert = "alert-warning";
            if (data.hasError) {
                message = 'Could not delete File. ' + data.errorMessage;
                classForAlert = 'danger';
            }
            var messageBootbox = '<div class="alert alert-' +
                classForAlert +
                '">' +
                message +
                '</div>';
            bootbox.alert({ message: messageBootbox, callback: callback });
        });
    };
    DBBackupManager.prototype._restore = function () {
        CuLoader_1.CuLoader.show();
        var dataToSend = {
            action: "RestoreMySqlBackupIntoDataBase"
        };
        $.post(this.ajaxURL, dataToSend, function (data) {
            CuLoader_1.CuLoader.hide();
            if (data.hasError === false) {
                bootbox.alert('Database updated - please restart mysql-server', DBBackupManager._reload);
            }
            else {
                bootbox.alert('Could not restore Database: ' + data.errorMessage, DBBackupManager._reload);
            }
        });
    };
    DBBackupManager.prototype._createBackup = function () {
        var callback = DBBackupManager._reload;
        var sendDataLocal = {
            action: "CreateMysqlBackup"
        };
        $.post(this.ajaxURL, sendDataLocal, function (data) {
            console.log(data);
            CuLoader_1.CuLoader.hide();
            var message = "";
            try {
                if (data.hasError === false) {
                    message =
                        '<p>The file has been created in <div class="form-group"><input class="form-control input-alert-url" value="' +
                            data.fileUrl +
                            '" readonly /></div></p>';
                    bootbox.alert({ message: message, callback: callback });
                }
                else {
                    message = '<p class="warning">Error creating Backupfile: </p><p>' +
                        data.errorMessage + "</p>";
                    bootbox.alert({
                        message: message,
                        callback: callback
                    });
                }
            }
            catch (exception) {
                alert(exception);
                console.log(exception);
            }
        }, 'JSON').fail(function (data) {
            alert("Error getting AJAXResponse");
            console.log(data);
        });
    };
    return DBBackupManager;
}());
var ajaxURL = $("[name=javascriptVariables][data-name=mysqlFileURL]").attr("data-value");
var secret = $("[name=javascriptVariables][data-name=secret]").attr("data-value");
//noinspection JSUnusedLocalSymbols
var dBBackup = new DBBackupManager(ajaxURL, secret);
//# sourceMappingURL=DBBackupManager.js.map