/*
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2018.04.30 at 05:41 MESZ
 */
var CuLoader = /** @class */ (function () {
    function CuLoader() {
    }
    CuLoader.show = function () {
        CuLoader.$cuLoader.show();
    };
    CuLoader.hide = function () {
        CuLoader.$cuLoader.hide();
    };
    CuLoader.$cuLoader = $("#cuLoader");
    return CuLoader;
}());
//# sourceMappingURL=CuLoader.js.map