        <p style="text-align: center;">Für die gew&uuml;nschte Stufe (<?php echo $grade; ?>) konnten keine Eintr&auml;ge am gew&uuml;nschten Datum (<?php echo $dates['base']->format('d.m.Y'); ?>) gefunden werden!
        <a href="<?php echo $this->config->base_url(); ?>"><br />Zur&uuml;ck</a></p>
        
        <ul class="pure-paginator date_nav">
            <li><a class="pure-button" href="<?php echo $this->config->base_url('grades/' . $grade . '/' . $dates['before']->format('d/m/Y')); ?>">&#171; <?php echo $dates['before']->format('D d.m.Y'); ?></a></li>
            <li><a class="pure-button pure-button-active" href="<?php echo $this->config->base_url('grades/' . $grade . '/' . $dates['base']->format('d/m/Y')); ?>"><?php echo $dates['base']->format('D d.m.Y'); ?></a></li>
            <li><a class="pure-button" href="<?php echo $this->config->base_url('grades/' . $grade . '/' . $dates['after']->format('d/m/Y')); ?>"><?php echo $dates['after']->format('D d.m.Y'); ?> &#187;</a></li>
        </ul>
