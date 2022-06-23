<?php
/**
 * The html template file of deny method of user module of QuCheng.
 *
 * @copyright   Copyright 2021-2022 北京渠成软件有限公司(BeiJing QuCheng Software Co,LTD, www.qucheng.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Jianhua Wang <wangjianhua@easycorp.ltd>
 * @package     user
 * @version     $Id$
 * @link        https://www.qucheng.com
 */
include '../../common/view/header.lite.html.php';
?>
<div class='container'>
  <div class='modal-dialog'>
    <div class='modal-header'><strong><?php echo $app->user->account, ' ', $lang->user->deny;?></strong></div>
    <div class='modal-body'>
      <div class='alert with-icon alert-pure'>
        <i class='icon-exclamation-sign'></i>
        <div class='content'>
        <?php
        if($denyType == 'nopriv')
        {
            $moduleName = isset($lang->$module->common)  ? $lang->$module->common  : $module;
            $methodName = isset($lang->$module->$method) ? $lang->$module->$method : $method;

            if($module == 'execution' && $method == 'gantt') $methodName = $methodName->common;

            /* find method name if method is lowercase letter. */
            if(!isset($lang->$module->$method))
            {
                $tmpLang = array();
                foreach($lang->$module as $key => $value) $tmpLang[strtolower($key)] = $value;
                $methodName = isset($tmpLang[$method]) ? $tmpLang[$method] : $method;
            }

            printf($lang->user->errorDeny, $moduleName, $methodName);
        }

        if($denyType == 'noview')
        {
            $menuName = $menu;
            if(isset($lang->menu->$menu))list($menuName) = explode('|', $lang->menu->$menu);
            printf($lang->user->errorView, $menuName);
        }
        ?>
        </div>
      </div>
    </div>
    <div class='modal-footer'>
    <?php
    $isOnlybody = helper::inOnlyBodyMode();
    unset($_GET['onlybody']);
    echo html::a('javascript:void(0)', $lang->my->common, ($isOnlybody ? '_parent' : ''), 'class="btn show-in-app" onclick="changeLeftNavigation()"');
    if($refererBeforeDeny) echo html::a(helper::safe64Decode($refererBeforeDeny), $lang->user->goback, ($isOnlybody ? '_parent' : ''), "class='btn'");
    echo html::a($this->createLink('user', 'logout', "referer=" . helper::safe64Encode($denyPage)), $lang->user->relogin, ($isOnlybody ? '_parent' : ''), "class='btn btn-primary'");
    ?>
    </div>
  </div>
</div>
<?php js::set('isOnlybody', $isOnlybody);?>
<?php js::set('indexLink', helper::createLink('my', 'index'));?>
</body>
<script>
/* Click my site to modify the left navigation. */
function changeLeftNavigation()
{
    if(window.parent && window.parent.$.apps && isOnlybody)
    {
        $.closeModal();
        window.parent.$.apps.open('my');
    }
    else
    {
        $.apps.close();
        $.apps.open('my');
    }
}
</script>
</html>