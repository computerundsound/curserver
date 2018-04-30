/*
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2018.04.29 at 03:03 MESZ
 */

interface AjaxResponseCreateMysqlBackup {
    hasError: boolean,
    errorMessage: string,
    fileUrl: string
}

interface AjaxResponseDeleteFile {
    hasError: boolean,
    errorMessage: string,
}

interface AjaxResponseRestoreDB {
    hasError: boolean,
    errorMessage: string,
}
