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
        <?php if(isset($substtext)): ?><div class="substtext">
          <h3>Anmerkungen</h3>
          <p><?php echo $substtext; ?></p>
        </div><?php endif;?> 
