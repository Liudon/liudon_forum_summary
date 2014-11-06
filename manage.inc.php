<?php
/**
 * manage.inc.php
 *
 * @author Don <i@liudon.org>
 */
if(!defined('IN_DISCUZ') || !defined('IN_MODCP')) {
    exit('Access Denied');
}

$fid = intval($_G['fid']);

if ($fid < 1) {
    showmessage('parameters_error');
}

$hasPerm = false;
if ($_G['adminid'] == 1 || $_G['forum']['ismoderator']) {
    $hasPerm = true;
}

if (!$hasPerm) {
    showmessage('admin_nopermission');
}

$update = false;

require_once libfile('function/editor');
require_once libfile('function/discuzcode');
require_once libfile('function/cache');

if (submitcheck('editsubmit')) {
    $update = true;
    $value = '';
    if ($_GET['rulesnew']) {
        $value = preg_replace('/on(mousewheel|mouseover|click|load|onload|submit|focus|blur)="[^"]*"/i', '', discuzcode($_GET['rulesnew'], 1, 0, 0, 0, 1, 1, 0, 0, 1));
    }
    C::t('common_setting')->update_batch(array('liudon_forum_summary_' . $fid => $value));
    updatecache('setting');
}

if ($_G['setting']['liudon_forum_summary_' . $fid]) {
    $_G['forum']['summary'] = html2bbcode($_G['setting']['liudon_forum_summary_' . $fid]);
}
