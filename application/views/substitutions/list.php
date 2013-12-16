        <table class="pure-table pure-table-bordered vp_table" >
          <thead>
            <tr>
              <th>Klasse</th>
              <th>Stunde</th>
              <th>Fach</th>
              <th>Raum</th>
              <th>Art</th>
              <th>Lehrer</th>
            </tr>
          </thead>
          <tbody>
        <?php foreach($substitutions as $subst): ?> 
            <tr>
              <td><?php echo $subst->grade; ?></td>
              <td><?php echo $subst->time; ?></td>
              <td><?php echo $subst->class; ?></td>
              <td><?php echo $subst->room; ?></td>
              <td><?php echo $subst->type; ?></td>
              <td><?php echo $subst->teacher; ?></td>
            </tr>
        <?php endforeach; ?>
            </tbody>
        </table>

        
        <ul class="pure-paginator date_nav">
            <li><a class="pure-button" href="<?php echo $this->config->base_url('grades/' . $grade . '/' . $dates['before']->format('d/m/Y')); ?>">&#171; <?php echo $dates['before']->format('D d.m.Y'); ?></a></li>
            <li><a class="pure-button pure-button-active" href="<?php echo $this->config->base_url('grades/' . $grade . '/' . $dates['base']->format('d/m/Y')); ?>"><?php echo $dates['base']->format('D d.m.Y'); ?></a></li>
            <li><a class="pure-button" href="<?php echo $this->config->base_url('grades/' . $grade . '/' . $dates['after']->format('d/m/Y')); ?>"><?php echo $dates['after']->format('D d.m.Y'); ?> &#187;</a></li>
        </ul>
