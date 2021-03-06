<?php include '../../common/view/header.lite.html.php';?>
<main id="main">
  <div class="container">
    <div id='mainContent' class='main-content'>
      <div class='main-header'>
        <h2><?php echo $lang->misc->qucheng->labels['about'];?></h2>
      </div>
      <table class='table table-form'>
        <tr>
          <td class='text-center w-160px'>
            <img class="about-logo" src='<?php echo $config->webRoot . 'theme/default/images/main/' . $lang->logoImg;?>' />
            <h4>
              <?php printf($lang->misc->qucheng->version, getenv('APP_VERSION')); ?>
            </h4>
          </td>
          <td>
            <p style="font-size:16px; text-align:center;"> <?php echo $lang->quchengSummary;?></p>
            <div class='text-center'><?php echo html::a($config->officalWebsite, $lang->misc->qucheng->officalWebsite, '_blank', "class='btn btn-link'");?></div>
          </td>
        </tr>
        <tr>
          <td><div class='text-center'><?php echo $lang->designedByAIUX;?></div></td>
          <td class="copyright text-right text-middle">
            <?php echo $lang->misc->copyright;?>
          </td>
        </tr>
      </table>
    </div>
  </div>
</main>
<?php include '../../common/view/footer.lite.html.php';?>
