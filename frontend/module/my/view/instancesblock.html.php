<?php $this->app->loadLang('instance');?>
<?php js::set('instanceIdList',  array_column($instances, 'id'));?>
<div class="cell main-table instance-container">
  <h3 class='text-center'><?php echo $lang->instance->installedService;?></h3>
  <?php if(empty($instances)):?>
  <div class="table-empty-tip">
    <p><span class="text-muted"><?php echo $lang->instance->empty;?></span></p>
  </div>
  <?php else:?>
  <table class="table">
    <thead>
      <tr>
        <th><?php echo $lang->instance->name;?></th>
        <th><?php echo $lang->instance->version;?></th>
        <th><?php echo $lang->instance->space?></th>
        <th><?php echo $lang->instance->status?></th>
        <th><?php echo $lang->instance->cpu;?></th>
        <th><?php echo $lang->instance->mem;?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($instances as $instance):?>
      <tr>
        <td><?php echo html::a($this->createLink('instance', 'view', "id=$instance->id"), $instance->name);?></td>
        <td><?php echo $instance->appVersion;?></td>
        <td><?php echo html::a($this->createLink('space', 'browse', "id=$instance->space"), $instance->spaceData->name);?></td>
        <td class="instance-status" instance-id="<?php echo $instance->id;?>" data-status="<?php echo $instance->status;?>">
          <?php echo $this->instance->printStatus($instance, false);?>
        </td>
        <?php $metrics= zget($instancesMetrics, $instance->id);?>
        <td><?php $this->instance->printCpuUsage($metrics->cpu);?></td>
        <td><?php $this->instance->printMemUsage($metrics->memory);?></td>
      </tr>
      <?php endforeach;?>
    </tbody>
  </table>
  <div class="table-footer"><?php echo $pager->show('right', 'pagerjs');?></div>
  <?php endif;?>
</div>
