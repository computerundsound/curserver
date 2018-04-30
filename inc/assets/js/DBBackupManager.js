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
            this.urlMySqlDumpFile = "";
            var dbBackup = this;
            this.secret = secret;
            this.urlMySqlDumpFile = urlMySqlDumpFile;
            $(".hostmask_db_curserver_backup").on("click", function () {
                $('#hostmask_db_curserver_backup_info').show();
                dbBackup._createBackup();
            });
        }
        DBBackup.prototype._createBackup = function (all) {
            if (all === void 0) { all = false; }
            var sendDataLocal = {
                action: "CreateMysqlBackup"
            };
            $.post(this.ajaxURL, sendDataLocal, function (data) {
                console.log(data);
                try {
                    if (data.hasError === false) {
                        bootbox.alert('<p>The file has been created in <div class="form-group"><input class="form-control input-alert-url" value="' +
                            data.fileUrl +
                            '" readonly /></div></p>');
                    }
                    else {
                        bootbox.alert('<p class="warning">Error creating Backupfile: </p><p>' +
                            data.errorMessage +
                            '</p>');
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
        return DBBackup;
    }());
    var ajaxURL = $("[name=javascriptVariables][data-name=mysqlFileURL]").attr("data-value");
    var secret = $("[name=javascriptVariables][data-name=secret]").attr("data-value");
    //noinspection JSUnusedLocalSymbols
    var dBBackup = new DBBackup(ajaxURL, secret);
})(DBBackupManager || (DBBackupManager = {}));
//# sourceMappingURL=DBBackupManager.js.map