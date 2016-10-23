/*
 * Created by cu on 22.10.2016.
 */


///<reference path="../dts/jquery.d.ts" />
///<reference path="../dts/bootbox.d.ts" />

interface SendData {
    "action": string,
}

module DBBackupManager {


    class DBBackup {

        ajaxURL: string = "/inc/ajax/ajax_db_backup.php";
        secret: string = '';
        sendData: SendData = {
            action: "dbBackupCurServer"
        };
        urlMySqlDumpFile: string = "";

        constructor(urlMySqlDumpFile, secret) {

            let dbBackup = this;

            this.secret = secret;
            this.urlMySqlDumpFile = urlMySqlDumpFile;

            console.log("Start DBBackupManager");

            $(".hostmask_db_curserver_backup").on("click", function () {

                dbBackup._createBackup();

            });

        }

        private _createBackup(all: boolean = false) {
            let sendDataLocal: SendData = this.sendData,
                alertMessage: string,
                dbBackup = this;


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
                } else {

                    alertMessage += "<p>Error while creating MySQL-Dump-File:</p>" +
                        "<p>Messages from System:</p>" +
                        "<dl>" +
                        "<dt>Action</dt><dl>" + data.action + "</dl>" +
                        "<dt>MysqlDumpFilePath</dt><dl>" + data.mysqlDumpFilePath + "</dl>" +
                        "<dt>Return</dt><dl>" + data.JSON.return + "</dl>" +
                        "<dt>Result</dt><dl>" + data.JSON.result + "</dl>" +
                        "<dt>CMD Output</dt><dl>" + data.JSON.output.join('<br>') + "</dl>" +
                        "</dl>";

                }

                // console.log(data);
                bootbox.alert(alertMessage, function () {
                    $.post(dbBackup.ajaxURL, {action: "deleteMySQLDumpFile"});
                });

            }, 'JSON').fail(function (data) {
                alert("Error");
                console.log(data)
            });

        }
    }

    let ajaxURL = $("[name=javascriptVariables][data-name=mysqlFileURL]").attr("data-value");
    let secret = $("[name=javascriptVariables][data-name=secret]").attr("data-value");

    //noinspection JSUnusedLocalSymbols
    let dBBackup = new DBBackup(ajaxURL, secret);


}