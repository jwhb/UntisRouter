<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> &middot; <?php echo $this->config->item('app_name'); ?></title>
    <link rel="stylesheet" href="<?php echo $this->config->base_url(); ?>/assets/css/pure-min.css">
    <link rel="stylesheet" href="<?php echo $this->config->base_url(); ?>/assets/css/app.css">
    <?php echo $this->config->item('tracking', ''); ?>
  </head>
  <body>
    <div id="layout">
      <!-- Menu toggle -->
      <a href="#menu" id="menuLink" class="pure-menu-link">
        <span></span>
      </a>
      <div id="menu">
        <div class="pure-menu pure-menu-open">
<?php echo $sidebar; ?> 
        </div>
      </div>
      <div id="main">
        <div class="header">
          <h1><?=$title?></h1>
        </div>
        <div class="content">
<?php echo $content; ?>
        </div>
      </div>
    </div>
    <script src="<?php echo $this->config->base_url(); ?>/assets/js/ui.js"></script>
  </body>
</html>
