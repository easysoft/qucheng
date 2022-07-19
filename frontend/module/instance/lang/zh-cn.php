<?php
$lang->instance = new stdclass;
$lang->instance->name       = '名称';
$lang->instance->appName    = '应用模板';
$lang->instance->version    = '版本';
$lang->instance->status     = '状态';
$lang->instance->cpu        = 'CPU';
$lang->instance->mem        = '内存';
$lang->instance->space      = '空间';
$lang->instance->domain     = '域名';
$lang->instance->dbType     = '数据库';

$lang->instance->serviceInfo      = '服务信息';
$lang->instance->appTemplate      = '应用模板';
$lang->instance->source           = '来源';
$lang->instance->installAt        = '部署时间';
$lang->instance->runDuration      = '已运行';
$lang->instance->defaultAccount   = '默认用户';
$lang->instance->defaultPassword  = '默认密码';
$lang->instance->operationLog     = '操作记录';
$lang->instance->installedService = '已安装服务';
$lang->instance->installApp       = '安装应用';
$lang->instance->cpuUsage         = 'CPU';
$lang->instance->memUsage         = '内存';

$lang->instance->cneDB = '平台数据库';
$lang->instance->newDB = '新建数据库';

$lang->instance->backup = new stdclass;
$lang->instance->backup->date          = '日期';
$lang->instance->backup->operator      = '备份人';
$lang->instance->backup->type          = '备份类型';
$lang->instance->backup->backupStatus  = '备份状态';
$lang->instance->backup->restoreStatus = '还原状态';
$lang->instance->backup->action        = '操作';
$lang->instance->backup->restore       = '还原';
$lang->instance->backup->restoreInfo   = '还原信息';
$lang->instance->backup->delete        = '删除';
$lang->instance->backup->rebackup      = '重试备份';
$lang->instance->backup->create        = '创建备份';

$lang->instance->backup->statusList = array();
$lang->instance->backup->statusList['pending']        = '等待备份';
$lang->instance->backup->statusList['processing']     = '备份中';
$lang->instance->backup->statusList['completed']      = '完成备份';
$lang->instance->backup->statusList['executedFailed'] = '备份失败';
$lang->instance->backup->statusList['uploading']      = '上传中';
$lang->instance->backup->statusList['uploadFailed']   = '上传失败';
$lang->instance->backup->statusList['downloading']    = '下载中';
$lang->instance->backup->statusList['downloadFailed'] = '下载失败';

$lang->instance->restore = new stdclass;
$lang->instance->restore->statusList = array();
$lang->instance->restore->statusList['pending']        = '等待还原';
$lang->instance->restore->statusList['processing']     = '还原中';
$lang->instance->restore->statusList['completed']      = '完成还原';
$lang->instance->restore->statusList['executedFailed'] = '还原失败';
$lang->instance->restore->statusList['downloading']    = '下载中';
$lang->instance->restore->statusList['downloadFailed'] = '下载失败';

$lang->instance->log = new stdclass;
$lang->instance->log->date    = '日期';
$lang->instance->log->message = '内容';

$lang->instance->actionList = array();
$lang->instance->actionList['install']   = '安装了%s';
$lang->instance->actionList['uninstall'] = '卸载了%s';
$lang->instance->actionList['start']     = '启动了%s';
$lang->instance->actionList['stop']      = '关闭了%s';
$lang->instance->actionList['editname']  = '修改了名称';
$lang->instance->actionList['upgrade']   = '升级了%s';

$lang->instance->sourceList = array();
$lang->instance->sourceList['cloud'] = '渠成公共市场';
$lang->instance->sourceList['local'] = '本地市场';

$lang->instance->channelList = array();
$lang->instance->channelList['test']   = '测试版';
$lang->instance->channelList['stable'] = '稳定版';

$lang->instance->statusList = array();
$lang->instance->statusList['installationFail'] = '安装失败';
$lang->instance->statusList['creating']         = '创建中';
$lang->instance->statusList['initializing']     = '初始化';
$lang->instance->statusList['startup']          = '启动中';
$lang->instance->statusList['starting']         = '启动中';
$lang->instance->statusList['running']          = '运行中';
$lang->instance->statusList['suspending']       = '暂停中';
$lang->instance->statusList['suspended']        = '已暂停';
$lang->instance->statusList['installing']       = '安装中';
$lang->instance->statusList['uninstalling']     = '卸载中';
$lang->instance->statusList['stopping']         = '关闭中';
$lang->instance->statusList['stopped']          = '已关闭';
$lang->instance->statusList['destroying']       = '销毁中';
$lang->instance->statusList['destroyed']        = '已销毁';
$lang->instance->statusList['abnormal']         = '异常';
$lang->instance->statusList['unknown']          = '未知';

$lang->instance->htmlStatuses = array();
$lang->instance->htmlStatuses['running']          = "<span class='label label-info label-outline'>%s</span>";
$lang->instance->htmlStatuses['stopped']          = "<span class='label label-default label-outline'>%s</span>";
$lang->instance->htmlStatuses['abnormal']         = "<span class='label label-danger label-outline'>%s</span>";
$lang->instance->htmlStatuses['installationFail'] = $lang->instance->htmlStatuses['abnormal'];
$lang->instance->htmlStatuses['busy']             = "<span class='label label-warning label-success label-outline'>%s</span>";

$lang->instance->componentFields = array();
$lang->instance->componentFields['replicas']  = '副本数';
$lang->instance->componentFields['cpu_limit'] = 'CPU';
$lang->instance->componentFields['mem_limit'] = '内存';

$lang->instance->start         = '启动';
$lang->instance->restart       = '重启';
$lang->instance->stop          = '关闭';
$lang->instance->install       = '安装';
$lang->instance->update        = '更新';
$lang->instance->upgrade       = '升级';
$lang->instance->customInstall = '自定义安装';
$lang->instance->uninstall     = '卸载';
$lang->instance->visit         = '访问';
$lang->instance->editName      = '修改名称';
$lang->instance->cpuCore       = '核';

$lang->instance->notices = array();
$lang->instance->notices['success']          = '成功';
$lang->instance->notices['fail']             = '失败';
$lang->instance->notices['confirmStart']     = '确定启动该应用吗？';
$lang->instance->notices['confirmStop']      = '确定关闭该应用吗？';
$lang->instance->notices['confirmUninstall'] = '确定卸载该应用吗？';
$lang->instance->notices['startSuccess']     = '启动成功';
$lang->instance->notices['startFail']        = '启动失败';
$lang->instance->notices['stopSuccess']      = '关闭成功';
$lang->instance->notices['stopFail']         = '关闭失败';
$lang->instance->notices['uninstallSuccess'] = '卸载成功';
$lang->instance->notices['uninstallFail']    = '卸载失败';
$lang->instance->notices['installSuccess']   = '安装成功';
$lang->instance->notices['installFail']      = '安装失败';
$lang->instance->notices['upgradeSuccess']   = '升级成功';
$lang->instance->notices['upgradeFail']      = '升级失败';
$lang->instance->notices['backupSuccess']    = '备份成功';
$lang->instance->notices['backupFail']       = '备份失败';
$lang->instance->notices['restoreSuccess']   = '还原成功';
$lang->instance->notices['restoreFail']      = '还原失败';
$lang->instance->notices['deleteSuccess']    = '删除成功';
$lang->instance->notices['deleteFail']       = '删除失败';
$lang->instance->notices['starting']         = '启动中，请稍候...';
$lang->instance->notices['stopping']         = '关闭中，请稍候...';
$lang->instance->notices['installing']       = '安装中，请稍候...';
$lang->instance->notices['uninstalling']     = '卸载中，请稍候...';
$lang->instance->notices['upgrading']        = '升级中，请稍候...';
$lang->instance->notices['backuping']        = '备份中，请稍候...';
$lang->instance->notices['restoring']        = '还原中，请稍候...';
$lang->instance->notices['deleting']         = '删除中，请稍候...';
$lang->instance->notices['confirmInstall']   = '确定要安装(%s)?';
$lang->instance->notices['confirmUpgrade']   = '确定要升级 %s 到 %s 吗?';
$lang->instance->notices['confirmBackup']    = '确定要备份吗？';
$lang->instance->notices['confirmRestore']   = '本操作将用备份的数据覆盖当前的数据，确定要还原吗？';
$lang->instance->notices['confirmDelete']    = '确定要删除该备份数据吗？';


$lang->instance->nameChangeTo    = ' %s 修改为 %s  。';
$lang->instance->versionChangeTo = ' %s 升级为 %s  。';

$lang->instance->instanceNotExists = '服务不存在';
$lang->instance->caplicasTooSmall  = '副本数不能小于1';
$lang->instance->empty             = '暂无服务';
$lang->instance->noComponent       = '无组件，点击';
$lang->instance->noHigherVersion   = '未找到更高版本！';

$lang->instance->errors = new stdclass;
$lang->instance->errors->domainLength         = '域名长度必须介于2-20字符之间';
$lang->instance->errors->domainExists         = '域名已被占用，请使用其它域名。';
$lang->instance->errors->wrongDomainCharacter = '域名只能是英文字母和数字';
$lang->instance->errors->noAppInfo            = '获取应用数据失败，请稍候重试。';
$lang->instance->errors->notEnoughMemory      = '集群资源不足！';
$lang->instance->errors->restoreRunning       = '当前还原正在进行中，请等待当前还原完成。';
$lang->instance->errors->noBackup             = '无备份数据，';
$lang->instance->errors->wrongRequestData     = '提交的数据有误，请刷新页面后重试。';
