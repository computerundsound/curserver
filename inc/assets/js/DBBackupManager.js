/*
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2017.03.27 at 21:51 MESZ
 */
///<reference path="../dts/jquery.d.ts" />
///<reference path="../dts/bootbox.d.ts" />
var DBBackupManager;
(function (DBBackupManager) {
    var DBBackup = /** @class */ (function () {
        function DBBackup(urlMySqlDumpFile, secret) {
            this.ajaxURL = "/inc/ajax/ajax_db_backup.php";
            this.secret = '';
            this.sendData = {
                action: "dbBackupCurServer"
            };
            this.urlMySqlDumpFile = "";
            var dbBackup = this;
            this.secret = secret;
            this.urlMySqlDumpFile = urlMySqlDumpFile;
            console.log("Start DBBackupManager");
            $(".hostmask_db_curserver_backup").on("click", function () {
                $('#hostmask_db_curserver_backup_info').show();
                dbBackup._createBackup();
            });
        }
        DBBackup.prototype._createBackup = function (all) {
            if (all === void 0) { all = false; }
            var sendDataLocal = this.sendData, alertMessage, dbBackup = this;
            console.log(this.ajaxURL);
            alertMessage = "<h3>Download curServer - Database</h3>";
            if (all) {
                sendDataLocal.action = 'dbBackupAll';
                alertMessage = "<h3>Download all Database</h3>";
            }
            $.post(this.ajaxURL, sendDataLocal, function (data) {
                console.log(data);
                if (data.success === true) {
                    alertMessage += "<p>DB Backup created. <a href='"
                        + dbBackup.urlMySqlDumpFile
                        + "'>Download " + dbBackup.urlMySqlDumpFile + "</a></p>";
                }
                else {
                    alertMessage += "<p>Error while creating MySQL-Dump-File:</p>" +
                        "<h4>Are you shure, you have mysqldump.exe in your PATH-Variable?</h4>" +
                        "<p>Messages from System:</p>" +
                        "<dl>" +
                        "<dt>Action</dt><dl>" + data.action + "</dl>" +
                        "<dt>MysqlDumpFilePath</dt><dl>" + data.mysqlDumpFilePath + "</dl>" +
                        "<dt>Return</dt><dl>" + data.JSON["return"] + "</dl>" +
                        "<dt>Result</dt><dl>" + data.JSON.result + "</dl>" +
                        "<dt>ExecString</dt><dl>" + data.JSON.exec_str + "</dl>" +
                        "<dt>CMD Output</dt><dl>" + data.JSON.output.join('<br>') + "</dl>" +
                        "</dl>";
                }
                // console.log(data);
                bootbox.alert(alertMessage, function () {
                    $.post(dbBackup.ajaxURL, { action: "deleteMySQLDumpFile" });
                });
            }, 'JSON').fail(function (data) {
                alert("Error");
                console.log(data);
            });
        };
        return DBBackup;
    }());
    var ajaxURL = $("[name=javascriptVariables][data-name=mysqlFileURL]").attr("data-value");
    var secret = $("[name=javascriptVariables][data-name=secret]").attr("data-value");
    //noinspection JSUnusedLocalSymbols
    var dBBackup = new DBBackup(ajaxURL, secret);
})(DBBackupManager || (DBBackupManager = {}));
//# sourceMappingURL=DBBackupManager.js.map