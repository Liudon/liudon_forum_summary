<?php
/**
 * summary.class.php
 *
 * @author Don <i@liudon.org>
 */
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class plugin_liudon_forum_summary {
}

class plugin_liudon_forum_summary_forum extends plugin_liudon_forum_summary {

    function index_forum_extra_output() {
        global $_G, $catlist, $forumlist;

        $cacheKeys = $return = array();
        foreach ($forumlist as $fid => $forum) {
            $cacheKeys[] = 'liudon_forum_summary_' . $fid;
        }
        loadcache($cacheKeys);

        foreach ($forumlist as $fid => $forum) {

            $html = '';
            if ($_G['cache']['plugin']['liudon_forum_summary']['show_forummanager']) {
                $html = '<div style="float:left;width:100px;"><font color="' . $_G['cache']['plugin']['liudon_forum_summary']['color'] . '">';
                if ($forum['moderators']) {
                    $id = 'moderate_' . $fid;
                    $html .= '<span id="' . $id . '" onmouseover="showMenu({\'ctrlid\':this.id})" style="background:url(\'static/image/common/arrow_down.gif\') 100% 50% no-repeat;cursor:pointer;padding-right:15px;">' . lang('template', 'forummanager') .'</span>';
                    $html .= '<ul ctrlid="' . $id . '" id="' . $id . '_menu" style="width:100px;overflow:hidden;padding:10px;text-align:left;border:1px solid #DDD;background:#FEFEFE;position:absolute;z-index:301;display:none;" >';
                    $html .= $forum['moderators'];
                    $html .= '</ul>';
                    // 隐藏默认的版主信息显示
                    $forum['moderators'] = '';
                } else {
                    $html .= '<a href="' . $_G['cache']['plugin']['liudon_forum_summary']['apply_url'] . '" target="_blank">' . lang('plugin/liudon_forum_summary', 'apply_forummanager') . '</a>';
                }
                $html .= '</font></div>';
            }

            $return[$fid] = $html;

            if ($forum['icon'] && $_G['cache']['liudon_forum_summary_' . $fid] && $catlist[$forum['fup']]['forumcolumns']) {
                $ctrlid = 'ctrl_summary_' . $fid;

                $html = '<div id="' . $ctrlid . '_menu" ctrlid="' . $ctrlid . '" class="p_pop" style="display:none;width:250px;overflow:hidden;margin-top:80px;">';
                if (is_array($forum['lastpost'])) {
                    $html .= '<a href="forum.php?mod=redirect&tid=' . $forum['lastpost']['tid'] . '&goto=lastpost#lastpost" class="xi2">' . cutstr($forum['lastpost']['subject'], 30) . '</a>';
                }
                $html .= $_G['cache']['liudon_forum_summary_' . $fid];
                $html .= '</div>';
                $forum['icon'] = '<div id="ctrl_summary_' . $fid . '" onmouseover="showMenu({\'ctrlid\':\'' . $ctrlid . '\'});">' . $forum['icon'] . '</div>' . $html;
                $forumlist[$fid] = $forum;
            }
        }

        return $return;
    }
}
