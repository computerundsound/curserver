/*
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2018.04.30 at 05:41 MESZ
 */

class CuLoader {

    protected static $cuLoader = $("#cuLoader");

    public static show() {

        CuLoader.$cuLoader.show();

    }


    public static hide() {
        CuLoader.$cuLoader.hide();
    }
}