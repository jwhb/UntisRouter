          <ul>
            <?php foreach($menu as $entry): ?>
            <li<?php if(strtolower($entry['controller']) == $controller) echo ' class="pure-menu-selected"'; ?>><a href="<?php echo $this->config->base_url($entry['ref']); ?>"><?php echo $entry['title']; ?></a></li>
            <?php endforeach; ?>
            <li class="pure-menu-separator"></li>
            <li><a href="<?php echo $this->config->base_url('grades/EF'); ?>">EF</a></li>
            <li><a href="<?php echo $this->config->base_url('grades/Q1'); ?>">Q1</a></li>
            <li><a href="<?php echo $this->config->base_url('grades/Q2'); ?>">Q2</a></li>
            <li><a href="<?php echo $this->config->base_url('grades/all'); ?>">&Uuml;bersicht</a></li>
            <?php /*foreach($grades as $grade):
            ?><li<?php if(strtolower($entry['controller']) == $controller) echo ' class="pure-menu-selected"'; ?>><a href="<?php echo $this->config->base_url('grades/' . $grade); ?>"><?php echo $grade; ?></a></li>
            <?php endforeach;*/ ?>
          </ul>
          <div id="sidebar-copyright" class="pull-down"><?php echo str_replace('{base_url}', $this->config->base_url(), $this->config->item('sidebar_copyright')); ?></div>
