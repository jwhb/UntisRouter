<?php $this->load->helper('html'); 
echo doctype('html5'); ?> 
<html>
<head>
  <meta charset="utf-8">
  <?php echo meta('viewport', 'width=device-width, initial-scale=1.0'); ?>
  <title><?php if(isset($grade) && !isset($substitutions)) echo "$grade &middot; "; echo "$title &middot; " . $this->config->item('app_name'); ?></title>
  <?php echo link_tag('assets/css/pure-min.css'); ?> 
  <?php echo link_tag('assets/css/app.css'); ?> 
  <?php echo link_tag('assets/css/font-awesome.min.css'); ?> 
  <?php echo link_tag('assets/img/favicon.ico', 'icon', 'image/x-icon'); ?> 
  <?php echo $this->config->item('tracking', ''); ?> 
</head>
<body>
  <div id="layout">
    <!-- Menu toggle -->
    <a href="#menu" id="menuLink" class="pure-menu-link">
      <span></span>
    </a>
    <div id="menu">
<?php echo $sidebar; ?> 
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
  <script src="<?php echo $this->config->base_url(); ?>assets/js/ui.js"></script>
</body>
</html>
