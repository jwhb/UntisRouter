        <table class="pure-table pure-table-bordered vp_table" >
          <thead>
            <tr>
              <th>Stunde</th>
              <!-- <th>Klasse</th> -->
              <th>Fach</th>
              <th>Raum</th>
              <th>Art</th>
              <th>Lehrer</th>
              <th>Info</th>
            </tr>
          </thead>
          <tbody><?php
            foreach($substitutions as $subst): ?> 
            <tr>
              <td><?php echo $subst->time; ?></td>
              <!-- <td><?php echo $subst->grade; ?></td> -->
              <td><?php echo $subst->class; ?></td>
              <td><?php echo $subst->room; ?></td>
              <td><?php echo $subst->type; ?></td>
              <td><?php echo $subst->teacher; ?></td>
              <td><?php echo $subst->info_text; ?></td>
            </tr><?php endforeach; ?> 
          </tbody>
        </table>
        
        <ul class="pure-paginator date_nav">
            <li>
              <a class="pure-button" href="<?php echo $this->config->base_url('grades/' . $grade . '/' . $dates['before']->format('d/m/Y')); ?>">&#171;
              <?php echo strftime('%a, %d.%m.%y', $dates['before']->getTimestamp()); ?></a>
            </li>
            <li>
              <a class="pure-button pure-button-active" href="<?php echo $this->config->base_url('grades/' . $grade . '/' . $dates['base']->format('d/m/Y')); ?>">
              <?php echo strftime('%a, %d.%m.%y', $dates['base']->getTimestamp()); ?></a>
            </li>
            <li>
              <a class="pure-button" href="<?php echo $this->config->base_url('grades/' . $grade . '/' . $dates['after']->format('d/m/Y')); ?>">
              <?php echo strftime('%a, %d.%m.%y', $dates['after']->getTimestamp()); ?> &#187;</a>
            </li>
        </ul>
