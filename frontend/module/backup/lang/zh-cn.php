<?php
$lang->backup->common       = '系统备份';
$lang->backup->shortCommon  = '备份';
$lang->backup->systemInfo   = '系统信息';
$lang->backup->index        = '备份首页';
$lang->backup->history      = '备份记录';
$lang->backup->delete       = '删除备份';
$lang->backup->backup       = '备份';
$lang->backup->restore      = '回滚';
$lang->backup->change       = '保留时间';
$lang->backup->changeAB     = '修改';
$lang->backup->rmPHPHeader  = '去除安全设置';
$lang->backup->setting      = '设置';
$lang->backup->backupPerson = '备份人';
$lang->backup->type         = '备份类型';

$lang->backup->settingAction = '备份设置';

$lang->backup->name           = '名称';
$lang->backup->currentVersion = '当前版本';
$lang->backup->latestVersion  = '最新版本';

$lang->backup->time     = '备份时间';
$lang->backup->files    = '备份文件';
$lang->backup->allCount = '总文件数';
$lang->backup->count    = '备份文件数';
$lang->backup->size     = '大小';
$lang->backup->status   = '状态';
$lang->backup->running  = '运行中';

$lang->backup->upgrade  = '升级';
$lang->backup->rollback = '回滚';
$lang->backup->restart  = '重启';
$lang->backup->delete   = '删除';

$lang->backup->statusList['success'] = '成功';
$lang->backup->statusList['fail']    = '失败';

$lang->backup->typeList['manual']    = '手动备份';
$lang->backup->typeList['auto']      = '升级前自动备份';

$lang->backup->settingDir = '备份目录';
$lang->backup->settingList['nofile'] = '不备份附件和代码';
$lang->backup->settingList['nosafe'] = '不需要防下载PHP文件头';

$lang->backup->waitting        = '<span id="backupType"></span>正在进行中，请稍候...';
$lang->backup->progressSQL     = '<p>SQL备份中，已备份%s</p>';
$lang->backup->progressAttach  = '<p>SQL备份完成</p><p>附件备份中，共有%s个文件，已经备份%s个</p>';
$lang->backup->progressCode    = '<p>SQL备份完成</p><p>附件备份完成</p><p>代码备份中，共有%s个文件，已经备份%s个</p>';
$lang->backup->confirmDelete   = '是否删除备份？';
$lang->backup->confirmRestore  = '是否还原该备份？';
$lang->backup->holdDays        = '备份保留最近 %s 天';
$lang->backup->copiedFail      = '复制失败的文件：';
$lang->backup->restoreTip      = '还原功能只还原数据库。';
$lang->backup->versionInfo     = '点击查看新版本介绍';
$lang->backup->confirmUpgrade  = '请确认是否升级渠成平台？';
$lang->backup->upgrading       = '升级中';

$lang->backup->success = new stdclass();
$lang->backup->success->backup  = '备份成功！';
$lang->backup->success->restore = '还原成功！';
$lang->backup->success->upgrade = '升级成功！';
$lang->backup->success->degrade = '降级成功！';

$lang->backup->error = new stdclass();
$lang->backup->error->noCreateDir = '备份目录不存在，也无法创建该目录';
$lang->backup->error->noWritable  = "<code>%s</code> 不可写！请检查该目录权限，否则无法备份。";
$lang->backup->error->noDelete    = "文件 %s 无法删除，修改权限或手工删除。";
$lang->backup->error->restoreSQL  = "数据库还原失败，错误：%s";
$lang->backup->error->restoreFile = "附件还原失败，错误：%s";
$lang->backup->error->backupFile  = "附件备份失败，错误：%s";
$lang->backup->error->backupCode  = "代码备份失败，错误：%s";

$lang->backup->error->upgradeFail       = "升级失败!";
$lang->backup->error->upgradeOvertime   = "升级超时!";
$lang->backup->error->degradeFail       = "降级失败!";
$lang->backup->error->beenLatestVersion = "已经是最新版，无需升级!";
$lang->backup->error->requireVersion    = "必须上传版本号!";
