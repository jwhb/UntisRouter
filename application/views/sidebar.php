        <div class="pure-menu pure-menu-open">
          <ul>
            <?php foreach($menu as $entry): ?>
            <li<?php if(strtolower($entry['controller']) == $controller) echo ' class="pure-menu-selected"'; ?>><a href="<?php echo $this->config->base_url($entry['ref']); ?>"><?php echo $entry['title']; ?></a></li>
            <?php endforeach; ?>
            <li class="pure-menu-separator"></li>
            <li><a href="<?php echo $this->config->base_url('grades/EF'); ?>">EF</a></li>
            <li><a href="<?php echo $this->config->base_url('grades/Q1'); ?>">Q1</a></li>
            <li><a href="<?php echo $this->config->base_url('grades/Q2'); ?>">Q2</a></li>
            <li><a href="<?php echo $this->config->base_url('grades/all'); ?>">&Uuml;bersicht</a></li>
          </ul>
          <div class="pull-down sidebar-footer">
            <div><?php echo str_replace('{base_url}', $this->config->base_url(), $this->config->item('sidebar_copyright')); ?></div>
            <div class="pure-menu-separator"></div>
            <p><?php if(@$user['loggedin']): ?>
                <i class="fa fa-user"></i> <?php echo (isset($user['first_name']))? $user['first_name'] : ''; ?>
                <?php else: ?><i class="fa fa-sign-in"></i> <?php echo anchor('auth/create_user', lang('login_submit_btn')); endif; ?>
            </p>
          </div>
        </div>
