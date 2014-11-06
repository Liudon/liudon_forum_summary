<?php
/**
 * uninstall.php
 *
 * 作者：Don(i@liudon.org)
 */
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

$sql = <<<EOF

DELETE FROM `pre_common_syscache` WHERE cname like 'liudon_forum_summary_%';

EOF;

runquery($sql);

$finish = TRUE;
