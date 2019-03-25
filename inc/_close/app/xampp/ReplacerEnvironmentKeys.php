<?php /**
 * Copyright Jörg Wrase - www.Computer-Und-Sound.de
 * Hire me! coder@cusp.de
 *
 * LastModified: 2019.03.25 at 00:24 MEZ
 */

/** @noinspection PhpComposerExtensionStubsInspection */

namespace app\xampp;


/**
 * Class VHostFiles
 *
 * @package _unittests\tests\installer\xampp
 */
class ReplacerEnvironmentKeys
{

    public const  VHOST_FILE_IF_VERSION_IS_GREATER_OR_EQUAL_THAN_5_4 = 'vhostFile_if_version_is_greater_or_equal_5.4';
    public const  VHOST_FILE_IF_VERSION_IS_SMALLER_THAN_5_4          = 'vhostFile_if_version_is_smaller_than_5.4';
    public const  VHOST_FILE_IF_VERSION_IS_SMALLER_THAN_5            = 'vhostFile_if_version_is_smaller_than_5';

}