<?php
/**
 * The model file of app instance module of QuCheng.
 *
 * @copyright Copyright 2021-2022 北京渠成软件有限公司(BeiJing QuCheng Software Co,LTD, www.qucheng.com)
 * @license   ZPL (http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author    Jianhua Wang <wangjianhua@easycrop.ltd>
 * @package   instance
 * @version   $Id$
 * @link      https://www.qucheng.com
 */
class InstanceModel extends model
{
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('cne');
    }

    /**
     * Get by id.
     *
     * @param  int $id
     * @access public
     * @return object|null
     */
    public function getByID($id)
    {
        $instance = $this->dao->select('*')->from(TABLE_INSTANCE)->where('id')->eq($id)->andWhere('deleted')->eq(0)->fetch();
        if(!$instance) return null;

        $instance->spaceData = $this->dao->select('*')->from(TABLE_SPACE)->where('deleted')->eq(0)->andWhere('id')->eq($instance->space)->fetch();

        return $instance;
    }

    /**
     * Get by id list.
     *
     * @param  array $idList
     * @access public
     * @return array
     */
    public function getByIdList($idList)
    {
        $instances = $this->dao->select('*')->from(TABLE_INSTANCE)->where('id')->in($idList)->andWhere('deleted')->eq(0)->fetchAll('id');
        $spaces    = $this->dao->select('*')->from(TABLE_SPACE)->where('deleted')->eq(0)->andWhere('id')->in(array_column($instances, 'space'))->fetchAll('id');
        foreach($instances as $instance) $instance->spaceData = zget($spaces, $instance->space, new stdclass);

        return $instances;
    }

    /**
     * Get instances list by account.
     *
     * @param  string $account
     * @param  object $pager
     * @access public
     * @return array
     */
    public function getByAccount($account = '', $pager = null)
    {
        $instances = $this->dao->select('instance.*')->from(TABLE_INSTANCE)->alias('instance')
            ->leftJoin(TABLE_SPACE)->alias('space')->on('space.id=instance.space')
            ->where('instance.deleted')->eq(0)
            ->beginIF($account)->andWhere('space.owner')->eq($account)->fi()
            ->orderBy('instance.id desc')
            ->beginIF($pager)->page($pager)->fi()
            ->fetchAll('id');

        $spaces = $this->dao->select('*')->from(TABLE_SPACE)
            ->where('deleted')->eq(0)
            ->andWhere('id')->in(array_column($instances, 'space'))
            ->fetchAll('id');

        foreach($instances as $instance) $instance->spaceData = zget($spaces, $instance->space, new stdclass);

        return $instances;
    }

    /**
     * Create instance status.
     *
     * @param  object $instance
     * @access public
     * @return object
     */
    public function createInstance($instance)
    {
        $this->dao->insert(TABLE_INSTANCE)->data($instance)->exec();

        return $this->getByID($this->dao->lastInsertID());
    }

    /**
     * Update instance status.
     *
     * @param  int    $int
     * @param  string $status
     * @access public
     * @return int
     */
    public function updateStatus($id, $status)
    {
        return $this->updateByID($id, array('status' => trim($status)));
    }

    /**
     * Update instance by id.
     *
     * @param  int          $id
     * @param  object|array $newInstance
     * @access public
     * @return void
     */
    public function updateByID($id, $newInstance)
    {

        return $this->dao->update(TABLE_INSTANCE)->data($newInstance)
            ->autoCheck()
            ->checkIF(isset($newInstance->name), 'name', 'notempty')
            ->checkIF(isset($newInstance->status), 'status', 'in', $this->lang->instance->statusList)
            ->where('id')->eq($id)->exec();
    }

    /**
     * If actions are allowed to do.
     *
     * @param  string $action
     * @param  object $instance
     * @access public
     * @return boolean
     */
    public function canDo($action, $instance)
    {
        $busy = in_array($instance->status, array('creating', 'initializing', 'starting', 'stopping', 'suspending', 'destroying'));
        switch($action)
        {
            case 'start':
                return !($busy || in_array($instance->status, array('running', 'abnormal', 'destroyed')));
            case 'stop':
                return !($busy || in_array($instance->status, array('stopped', 'installationFail')));
            case 'uninstall':
                return !$busy;
            case 'visit':
                return $instance->status == 'running';
            default:
                return false;
        }
    }

    /**
     * Install app.
     *
     * @param  object $app
     * @param  array  $settings settings of app, for example: cup, memory.
     * @param  int    $spaceID
     * @access public
     * @return false|object Failure: return false, Success: return instance
     */
    public function install($app, $settings = array(), $spaceID = null)
    {
        $this->loadModel('store');
        $this->app->loadLang('store');

        $this->loadModel('space');
        if($spaceID)
        {
            $space = $this->space->getByID($spaceID);
        }
        else
        {
            $space = $this->space->defaultSpace($this->app->user->account);
        }

        $appData            = new stdclass;
        $appData->cluser    = '';
        $appData->namespace = $space->k8space;
        $appData->name      = "{$app->chart}-{$this->app->user->account}-" . date('YmdHis'); //name rule: chartName-userAccount-YmdHis;
        $appData->chart     = $app->chart;
        $appData->settings  = $settings;

        $result = $this->cne->installApp($appData);
        if($result->code != 200) return false;

        $instanceData = new stdclass;
        $instanceData->appId     = $app->id;
        $instanceData->appName   = $app->alias;
        $instanceData->name      = $app->alias;
        $instanceData->logo      = $app->logo;
        $instanceData->desc      = $app->desc;
        $instanceData->source    = 'cloud';
        $instanceData->chart     = $app->chart;
        $instanceData->version   = $app->app_version;
        $instanceData->space     = $space->id;
        $instanceData->k8name    = $appData->name;
        $instanceData->status    = 'creating';
        $instanceData->createdBy = $this->app->user->account;
        $instanceData->createdAt = date('Y-m-d H:i:s');

        $instance = $this->createInstance($instanceData);
        if(dao::isError()) return false;

        $this->loadModel('action')->create('instance', $instance->id, 'install', '', json_encode(array('result' => $result, 'app' => $app)));

        $status = $result->code == 200 ? 'initializing' : 'installationFail';
        $this->updateStatus($instance->id, $status);

        return  $instance;
    }

    /*
     * Uninstall app instance.
     *
     * @param  object $instance
     * @access public
     * @return bool
     */
    public function uninstall($instance)
    {
        $params = new stdclass;
        $params->cluster   = '';// Multiple cluster should set this field.
        $params->name      = $instance->k8name;
        $params->namespace = $instance->spaceData->k8space;

        $result = $this->cne->uninstallApp($params);
        if($result->code == 200) $this->dao->update(TABLE_INSTANCE)->set('deleted')->eq(1)->where('id')->eq($instance->id)->exec();

        return $result;
    }

    /*
     * Start app instance.
     *
     * @param  object $instance
     * @access public
     * @return object
     */
    public function start($instance)
    {
        $params = new stdclass;
        $params->cluster   = '';
        $params->name      = $instance->k8name;
        $params->chart     = $instance->chart;
        $params->namespace = $instance->spaceData->k8space;

        $result = $this->cne->startApp($params);
        if($result->code == 200) $this->dao->update(TABLE_INSTANCE)->set('status')->eq('starting')->where('id')->eq($instance->id)->exec();

        return $result;
    }

    /*
     * Stop app instance.
     *
     * @param  object $instance
     * @access public
     * @return object
     */
    public function stop($instance)
    {
        $params = new stdclass;
        $params->cluster   = '';// Mulit cluster should set this field.
        $params->name      = $instance->k8name;
        $params->chart     = $instance->chart;
        $params->namespace = $instance->spaceData->k8space;

        $result = $this->cne->stopApp($params);
        if($result->code == 200) $this->dao->update(TABLE_INSTANCE)->set('status')->eq('stopping')->where('id')->eq($instance->id)->exec();

        return $result;
    }

    /*
     * Query and update instances status.
     *
     * @param  array $instances
     * @access public
     * @return array  new status list [{id:xx, status: xx, changed: true/false}]
     */
    public function batchFresh(&$instances)
    {
        $statusList   = array();
        foreach($instances as $instance)
        {
            $instance = $this->freshStatus($instance);

            $status = new stdclass;
            $status->id     = $instance->id;
            $status->status = $instance->status;

            $statusList[] = $status;
        }

        return $statusList;
    }

    /*
     * Query and update instance status.
     *
     * @param  object $instance
     * @access public
     * @return object
     */
    public function freshStatus($instance)
    {
        $params = new stdclass;
        $params->cluster   = '';
        $params->name      = $instance->k8name;
        $params->chart     = $instance->chart;
        $params->namespace = $instance->spaceData->k8space;

        $instance->runDuration = 0;
        $result = $this->cne->queryStatus($params);
        if($result->code != 200) return $instance;
        $instance->runDuration = intval($result->data->age);

        if($instance->status != $result->data->status)
        {
            $instance->status = $result->data->status;

            if(isset($result->data->access_host) && $result->data->access_host) $instance->domain = $result->data->access_host;

            $this->dao->update(TABLE_INSTANCE)
                ->set('status')->eq($instance->status)
                ->beginIF($instance->domain)->set('domain')->eq($instance->domain)->fi()
                ->where('id')->eq($instance->id)
                ->exec();
        }

        return $instance;
    }

    /**
     * Print instance status.
     *
     * @param  object $instance
     * @param  bool   $showText
     * @access public
     * @return void
     */
    public function printStatus($instance, $showText = true)
    {
        $html = zget($this->lang->instance->htmlStatuses, $instance->status, $this->lang->instance->htmlStatuses['busy']);
        echo $showText ? $html . "<span>" . zget($this->lang->instance->statusList, $instance->status, '') . "</span>" : $html;
    }

    /**
     * Print CPU usage.
     *
     * @param  object $metrics
     * @static
     * @access public
     * @return viod
     */
    public static function printCpuUsage($metrics)
    {
        $rate  = $metrics->rate;
        $color = 'red';
        if($rate == 0) $color = 'gray';
        elseif($rate < 60) $color = 'green';
        elseif($rate < 80) $color = 'orange';

        $tip = "{$rate}% = {$metrics->usage} / {$metrics->limit}";
        commonModel::printProgress($rate, $color, $tip);
    }

    /**
     * Print memory usage.
     *
     * @param  object $metrics
     * @static
     * @access public
     * @return viod
     */
    public static function printMemUsage($metrics)
    {
        $rate  = $metrics->rate;
        $color = 'red';
        if($rate == 0) $color = 'gray';
        elseif($rate < 60) $color = 'green';
        elseif($rate < 80) $color = 'orange';

        $tip = "{$rate}% = " . helper::formatKB($metrics->usage / 1024) . ' / ' . helper::formatKB($metrics->limit / 1024);
        commonModel::printProgress($rate, $color, $tip);
    }

    /*
     * Print action buttons.
     *
     * @param  object $instance
     * @access public
     * @return void
     */
    public function printActions($instance)
    {
        $actionHtml = '';

        $disableStart = !$this->canDo('start', $instance);
        $actionHtml  .= html::commonButton("<i class='icon-play'></i>", "instance-id='{$instance->id}' title='{$this->lang->instance->start}'", "btn-start btn btn-lg btn-action " . ($disableStart ? 'disabled' : ''));

        $disableStop = !$this->canDo('stop', $instance);
        $actionHtml .= html::commonButton('<i class="icon-off"></i>', "instance-id='{$instance->id}' title='{$this->lang->instance->stop}'", 'btn-stop btn btn-lg btn-action ' . ($disableStop ? 'disabled' : '') . "'");

        $disableUninstall = !$this->canDo('uninstall', $instance);
        $actionHtml      .= html::commonButton('<i class="icon-trash"></i>', "instance-id='{$instance->id}' title='{$this->lang->instance->uninstall}'", 'btn-uninstall btn btn-lg btn-action ' . ($disableUninstall ? 'disabled' : '') . "'");

        if($instance->domain)
        {
            $disableVisit = !$this->canDo('visit', $instance);
            $actionHtml  .= html::a('//'.$instance->domain, '<i class="icon icon-menu-my"></i>', '', "title='{$this->lang->instance->visit}' " . 'target="_blank"  class="btn btn-lg btn-action btn-link ' . ($disableVisit ? 'disabled' : '') . '"');
        }

        echo $actionHtml;
    }

    /**
     * Print message of action log of instance.
     *
     * @param  object $instance
     * @param  object $log
     * @access public
     * @return void
     */
    public function printLog($instance, $log)
    {
        $action = zget($this->lang->instance->actionList, $log->action, $this->lang->actions);
        echo $log->actorName . sprintf($action, $instance->appName);
    }

    /*
     * Convert CPU digital to readable format.
     *
     * @param  array  $cpuList
     * @access public
     * @return array
     */
    public function getCpuOptions($cpuList)
    {
        $newList = array();
        foreach($cpuList as $cpuValue) $newList[$cpuValue] = $cpuValue . $this->lang->instance->cpuCore;
        return $newList;
    }

    /*
     * Convert memory digital to readable format.
     *
     * @param  array  $memList
     * @access public
     * @return array
     */
    public function getMemOptions($memList)
    {
        $newList = array();
        foreach($memList as $memValue) $newList[$memValue] = helper::formatKB(intval($memValue / 1024));
        return $newList;
    }

    /*
     * Get instance switcher.
     *
     * @param  object  $instance
     * @access public
     * @return string
     */
    public function getSwitcher($instance)
    {
        $space  = $this->dao->select('id,name')->from(TABLE_SPACE)->where('id')->eq($instance->space)->fetch();
        $output = $this->loadModel('space')->getSwitcher($space, 'space', 'browse');

        $instanceLink = helper::createLink('instance', 'view', "id=$instance->id");

        $output .= "<div class='btn-group header-btn'>";
        $output .= html::a($instanceLink, $instance->appName, '', 'class="btn"');
        $output .= "</div>";

        return $output;
    }

    /**
     * Get switcher of custom installation page of store.
     *
     * @param  object $app
     * @access public
     * @return array
     */
    public function getCustomInstallSwitcher($app)
    {
        $output  = $this->loadModel('store')->getAppViewSwitcher($app);
        $output .= "<div class='btn-group header-btn'>";
        $output .= html::a(helper::createLink('instance', 'custominstall', "id=$app->id"), $this->lang->instance->customInstall, '', 'class="btn"');
        $output .= "</div>";

        return $output;
    }
}