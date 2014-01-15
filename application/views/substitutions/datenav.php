        <ul class="pure-paginator date_nav">
          <li><a class="pure-button" href="<?php echo $this->config->base_url('grades/' . $grade . '/' . $dates['before']->format('d/m/Y')); ?>">&#171;
              <?php echo strftime('%a, %d.%m.%y', $dates['before']->getTimestamp()); ?></a></li>
          <li><a class="pure-button pure-button-active" href="<?php echo $this->config->base_url('grades/' . $grade . '/' . $dates['base']->format('d/m/Y')); ?>">
              <?php echo strftime('%a, %d.%m.%y', $dates['base']->getTimestamp()); ?></a></li>
          <li><a class="pure-button" href="<?php echo $this->config->base_url('grades/' . $grade . '/' . $dates['after']->format('d/m/Y')); ?>">
              <?php echo strftime('%a, %d.%m.%y', $dates['after']->getTimestamp()); ?> &#187;</a></li>
        </ul>
