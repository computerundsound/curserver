/*
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2017.03.27 at 21:51 MESZ
 */

///<reference path="../dts/jquery.d.ts" />
///<reference path="../dts/bootbox.d.ts" />

interface SendData {
    "action": string,
}

module DBBackupManager {

    class DBBackup {

        ajaxURL: string = "/inc/ajax/ajax_db_backup.php";
        secret: string  = '';

        urlMySqlDumpFile: string = "";

        constructor(urlMySqlDumpFile, secret) {

            let dbBackup = this;

            this.secret           = secret;
            this.urlMySqlDumpFile = urlMySqlDumpFile;


            $(".hostmask_db_curserver_backup").on("click", function () {

                $('#hostmask_db_curserver_backup_info').show();

                dbBackup._createBackup();

            });

        }

        private _createBackup(all: boolean = false) {

            let sendDataLocal: SendData = {
                action: "CreateMysqlBackup"
            };

            $.post(this.ajaxURL, sendDataLocal, function (data: AjaxResponseCreateMysqlBackup) {

                console.log(data);

                try {

                    if (data.hasError === false) {

                        bootbox.alert('<p>The file has been created in <div class="form-group"><input class="form-control input-alert-url" value="' +
                                      data.fileUrl +
                                      '" readonly /></div></p>');

                    } else {
                        bootbox.alert('<p class="warning">Error creating Backupfile: </p><p>' +
                                      data.errorMessage +
                                      '</p>')
                    }
                } catch (exception) {

                    alert(exception);
                    console.log(exception);

                }

            }, 'JSON').fail(function (data) {
                alert("Error getting AJAXResponse");
                console.log(data)
            });

        }
    }

    let ajaxURL = $("[name=javascriptVariables][data-name=mysqlFileURL]").attr("data-value");
    let secret  = $("[name=javascriptVariables][data-name=secret]").attr("data-value");

    //noinspection JSUnusedLocalSymbols
    let dBBackup = new DBBackup(ajaxURL, secret);

}