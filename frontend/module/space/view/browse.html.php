<?php
/**
 * The browse view file of space module of QuCheng.
 *
 * @copyright   Copyright 2021-2022 北京渠成软件有限公司(BeiJiang QuCheng Software Co,LTD, www.qucheng.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Jianhua Wang <wangjianhua@easycorp.ltd>
 * @package     space
 * @version     $Id$
 * @link        https://www.qucheng.com
 */
?>
<?php include $this->app->getModuleRoot() . '/common/view/header.html.php';?>
<?php js::set('instanceNotices', $lang->instance->notices);?>
<?php js::set('instanceIdList',   array_column($instances, 'id'));?>
<div id='mainMenu' class='clearfix'>
  <form id="spaceSearchForm" method="post" class="not-watch load-indicator">
    <div class="hidden btn-toolbar pull-left">
        <div class="input-control search-box has-icon-left has-icon-right search-example" id="searchboxExample">
          <?php echo html::input('search', '', "type='search' placeholder='{$lang->space->searchInstance}' autocomplete='off' class='form-control search-input text-left'");?>
        </div>
        <span class="input-group-btn">
          <?php echo html::submitButton('<i class="icon icon-search"></i>', 'type="submit"', 'btn btn-secondary');?>
        </span>
    </div>
    <div class="btn-toolbar pull-right">
      <div class="btn-group">
      <?php $listUrl= $this->inLink('browse', "spaceID={$currentSpace->id}&browseType=bylist"); ?>
      <?php $cardUrl= $this->inLink('browse', "spaceID={$currentSpace->id}&browseType=bycard"); ?>
      <?php echo html::a($listUrl, "<i class='icon-list'></i>", '', "class='btn btn-icon " . ($browseType != 'bycard' ? 'text-primary':'') . "' title='{$lang->space->byList}'");?>
      <?php echo html::a($cardUrl, "<i class='icon-cards-view'></i>", '', "class='btn btn-icon " . ($browseType == 'bycard' ? 'text-primary':'') . "' title='{$lang->space->byCard}'");?>
      </div>
    </div>
  </form>
</div>
<div id='mainContent' class='main-row'>
<?php
if($browseType == 'bycard')
{
    include 'browsebycard.html.php';
}
else
{
    include 'browsebylist.html.php';
}
?>
</div>
<?php include $this->app->getModuleRoot() . '/common/view/footer.html.php';?>
